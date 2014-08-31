<?php

/**
 * Utility class to connect to and manage the DB
 */

class DBHelper {
	private $username = "ynizipli_fitness";

	private $password = "4561230";

	private $host = "174.120.151.187";
	
	private $port = 3306;

	private $dbname = "ynizipli_fitness";

	private $pdo = null;
	
	/**
	 * Constructor (the connection is automagic).
	 */
	public function __construct(){
		$this->pdo = new PDO("mysql:host=$this->host; port=$this->port; dbname=$this->dbname",$this->username, $this->password);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	
	/**
	 * WARNING: this function should not be used explicitly
	 * since PHP already take care of disconnecting from the DB
	 * after the script terminates.
	 */
	public function disconnect(){
		// Destroy the PDO instance
		$this->pdo = null;
	}

	/**
	 * The array must contain the name of the param
	 * as key and the value as value.
	 * 
	 * Example:
	 * 
	 * array(":name" => "Bear Grylls", ":age" => 28)
	 */
	public function query($query, array $vars = null) {
		$dbh = $this->pdo;
		$result = null;
		
		// Create an object to parse and execute the prepared statement (avoid SQL injection)
		$stmt = $dbh->prepare($query);
		
		// Execute the query
		if (isset($vars)){
			$stmt->execute($vars);
		} else {
			$stmt->execute();
		}
		
		// Return the result
		try{
			$result = $stmt->fetchAll();
			return $result;
		} catch (PDOException $e){
			if (strstr($e->getMessage(), "General error")){
				return null; // no result, probably a INSERT or UPDATE
			} else {
				throw new PDOException($e->getMessage());
			}
		}
		
	}

}
