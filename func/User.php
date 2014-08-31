<?php

require_once ("include/autoLoader.php");

class User {
	
	private $id;
	
	private $username;

	private $password;

	private $name;

	private $email;

	private $salt;
	
	private $picture;
	
	private $age;
	
	private $gender;
	
	private $height;
	
	private $mass;
	
	private $experience;
	
	private $fat_percentage;
	
	private $bio;
	
	private $is_admin;
	
	private $userType = null;
	
	private $fitnessProgram = null;
	
	private static $dbTable = "users";

	private static $saltLength = 10;

	private static $db;
	
	/**
	 * Constructor
	 */
	public function __construct($userInfo = null, $saveToDb = true) {
		// TODO: check for null info (e.g. email)
		// Setup the database connection
		if (self::$db == null){
			self::$db = new DBHelper();
		}
		
		// A "dummy" user can be created (for testing) but the database is untouched
		if (isset($userInfo)){
			
			// Initialize all the instance variables
			foreach ($userInfo as $property => $value){
				// Exclude the tricky ones
				if (property_exists($this, $property)){	
					$this->$property = $value;
				}
			}
			// Generate salt and hashed password ONLY if the user is being created now!
			if (!isset($this->salt) || !isset($this->password)){
				$this -> salt = $this -> generateSalt();
				$this -> password = sha1($userInfo["password"] . $this -> salt);
			}
	
			if ($saveToDb){
		
				// Generate query to store the user in the DB
				$dbTable = self::$dbTable;
				$query = "INSERT INTO $dbTable (username, is_admin, salt, password, name, email, picture, gender, age, height, mass, experience, fat_percentage, bio, created_at, updated_at, provider)";
				$query .= "VALUES (";
				$query .= "'$this->username', '$this->is_admin', '$this->salt', '$this->password', '$this->name', '$this->email', '$this->picture', '$this->gender', '$this->age', '$this->height', '$this->mass', '$this->experience', '$this->fat_percentage', '$this->bio', DATE_ADD(NOW(), INTERVAL 8 HOUR), DATE_ADD(NOW(), INTERVAL 8 HOUR), 'php_script'";
				$query .= ");";
			
				// Will write to the DB
				self::$db -> query($query);
			}

			// Check if is admin
			if ($this->is_admin){
				$this->userType = new Administrator();
			}
			
			$myProgram = FitnessProgram::getFitnessProgramByUser($this);
			
			if (isset($myProgram)){
				$this->setFitnessProgram($myProgram);
			} 
		}
	}
	
	public static function searchUsers($searchKey){
		
		if (self::$db == null){
			self::$db = new DBHelper();
		}
		$dbTable = self::$dbTable;
		
		$query = "SELECT name, username, id FROM $dbTable WHERE username LIKE '%$searchKey%' OR name LIKE '%$searchKey%' OR email LIKE '%$searchKey%'";
		
		$result = self::$db->query($query);
		
		$last = array();
		foreach($result as $prop=>$value){
			$last[$prop] = $value;
		}
		
		return (json_encode($last));

	}
	
	public static function getCount(){
		if (self::$db == null){
			self::$db = new DBHelper();
		}
		
		$query = "SELECT COUNT(*) FROM users";
		
		$result = self::$db->query($query);
		
		return $result;
	}
	
	public function addExercise($exerciseInfo){	
		$fitnessProg = FitnessProgram::getFitnessProgramByUser($this);
		if (!isset($fitnessProg)){
			throw new RuntimeException("No fitness program is specified for the user, adding a new exercise was not possible");
		}
		// Here a fitness program is present
		$fitnessProg->addExercise($exerciseInfo);
	}
	
	public function deleteExercise($exerciseId){
		$fitnessProg = FitnessProgram::getFitnessProgramByUser($this);
		if (!isset($fitnessProg)){
			throw new RuntimeException("No fitness program is specified for the user, adding a new exercise was not possible");
		}
		// Here a fitness program is present
		$fitnessProg->deleteExercise($exerciseId);
		
	}
	//=================================== METHODS 
	
	// Private
	
	/**
	 * Check if the user has administrative privileges
	 * and changes the userType accordingly.
	 */
	private function setPrivileges(){
		if (self::$db == null){
			self::$db = new DBHelper();
		}
		/** TODO: check if the username is in the Administrator table
		 * and set the userType to an instance of the Administrator class */
		$dbTable = self::$dbTable;
		$username = $this->getUsername();
		$query = "SELECT is_admin FROM $dbTable WHERE username = $username";
		$result = self::$db->query($query);
		if (count($result) != 0){
			$this->isAdmin = $result[0]["is_admin"];
		} else {
			$this->isAdmin = false;
		}
	}
	
	/**
	 * If not specified otherwise this function
	 * generates a 10 characters long salt (random string)
	 */
	private function generateSalt($length = 10) {
		$symbols = "abcdefghijklmnopqrstuvwxyz";
		$symbols .= strtoupper($symbols);
		$symbols .= "+-*_";
		$random = str_shuffle($symbols);
		return substr($random, 0, $length);
	}

	// Public
	
	/**
	 * Return an instance of the user with the given username
	 */
	public static function getUserById($username) {
		// Execute query, populate instance and return it
		if (self::$db == null){
			self::$db = new DBHelper();
		}
		$dbTable = self::$dbTable;
		$query = "SELECT * FROM $dbTable WHERE username = '" . $username . "';";
		$result = self::$db -> query($query);
		$properties =  $result;
		// If no user is found return null
		if (count($properties) == 0) return null;
		// Create the instance to populate
		$user = new self($properties[0], false);
		return $user;
	}
	
	//find a user according to his/her user id.
	public static function getUserByUserId($userid) {
		// Execute query, populate instance and return it
		if (self::$db == null){
			self::$db = new DBHelper();
		}
		$dbTable = self::$dbTable;
		$query = "SELECT * FROM $dbTable WHERE id = '" . $userid . "';";
		$result = self::$db -> query($query);
		$properties =  $result;
		// If no user is found return null
		if (count($properties) == 0) return null;
		// Create the instance to populate
		$user = new self($properties[0], false);
		return $user;
	}
	
	/**
	 * Write the user to the database
	 */
	public function save(){
		// Exclude some properties
		$toExclude = array("userType", "fitnessProgram");
		$dbTable = self::$dbTable;
		$query = "UPDATE $dbTable ";
		$query .= "SET ";
		foreach($this as $property=>$value){
			if (!in_array($property, $toExclude)){
				$query .= "$property='$value',";
			}
		}
		$query = rtrim($query, ',');
		$query .= " WHERE username='".$this->username."';";
		self::$db->query($query);
	}
	
	/**
	 * Remove the user from the database
	 */
	public function remove(){
		$dbTable = self::$dbTable;
		$query = "DELETE FROM $dbTable ";
		$query .= "WHERE username='$this->username';";
		self::$db->query($query);
	}
	
	/**
	 * Determine if the given password matches the user's one
	 */
	public function authenticate($password){
		$dbTable = self::$dbTable;
		$hash = sha1($password.$this->salt);
		if ($hash == $this->password){
			$result = self::$db -> query("SELECT id FROM $dbTable WHERE username = '$this->username'");
			$this->id = $result[0];
			return $this->id;
		}
		return -1; // cannot return false because it's equal to 0
	}
	
	/**
	 * Convert this user into an array
	 */
	public function toArray(){
		$properties = array();
		foreach($this as $prop=>$value){
			$properties[$prop] = $value;
		}
		return $properties;
	}

	/**
	 * Convert this user into a JSON object
	 */
	public function toJson() {
		// Create a json string containing user's info
		return json_encode($this->toArray());
	}
	
	/**
	 * Magic methods
	 */

	/**
	 * Getters
	 */
	 
	public static function getAllUsers($page = 1){
		if (self::$db == null){
			self::$db = new DBHelper();
		}
		
		$dbTable = self::$dbTable;
		if ($page == 1) {
			$query = "SELECT * FROM $dbTable LIMIT 0, 10";
		} else {
			$count = $page * 10;
			$lCount = $count - 10;
			
			$query = "SELECT * FROM $dbTable LIMIT $lCount, $count";
		}
		$result = self::$db -> query($query);
		
		return $result;
		
	}
	
	public function getName(){
		return $this->name;
	}
	 
	public function getUserId(){
		$dbTable = self::$dbTable;
		$username = $this->username;
		$query = "SELECT id FROM $dbTable WHERE username = '$username'";
		$result = self::$db->query($query);
		$result = $result[0];
		$this->id = $result["id"];
		return $this->id;
	}
	
	public function getUserType(){
		return $this->userType;
	}
	
	public function getUserName(){
		return $this->username;
	}
	
	public function getBio(){
		return $this->bio;
	}
	
	public function getAge(){
		return $this->age;
	}
	
	public function getFatPercentage(){
		return $this->fat_percentage;
	}
	
	public function getGender(){
		return $this->gender;
	}
	
	public function getHeight(){
		return $this->height;
	}
	
	public function getMass(){
		return $this->mass;
	}
	
	public function getExperience(){
		return $this->experience;
	}
	
	public function getPicture(){
		return $this->picture;
	}
	
	public function getFitnessProgram(){
		return $this->fitnessProgram;
	}
	
	public function getEmail(){
		return $this->email;
	}
	
	public function getPassword(){
		return $this->password;
	}
	
	public function isAdmin(){
		return (boolean) $this->is_admin;
	}
	
	/**
	 * Setters
	 */

	public function setName($name){
		$this->name = $name;
	}

	/**
	 * Generic setter
	 */
	public function set($property, $value){
		if (property_exists($this, $property)){
			$this->$property = $value;
		}
	}

	/**
	 * Using type hinting to ensure that a real FitnessProgram
	 * is set in the user.
	 */
	public function setFitnessProgram(FitnessProgram $program){
		$this->fitnessProgram = $program;
	}
}

