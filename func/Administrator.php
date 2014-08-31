<?php

/**
 * This class is the role for users.
 * It's merely used to check if a user can access
 * administration functions (provided by the SystemManager).
 */
require_once("include/autoLoader.php");
 
class Administrator {
	/** TODO: we might move the SystemManager methods here */
	
	private $usersTable = "users";
	
	private $passwordField = "password";
	
	private static $db;
	
	public static function getDb(){
		if (!isset(self::$db)){
			self::$db = new DBHelper();
		}
		return self::$db;
	}
	public function deleteComment($id){
		
		$query = "DELETE FROM comments WHERE id='$id'";
		self::getDb()->query($query);
	}
	
    public function editComment($comment_id, $comment_text){
        
        $query = "UPDATE comments SET comment_text='$comment_text' WHERE id='$comment_id'";
        
        $result = self::getDb()->query($query);
    }
    
    public function editProgram($idFitness, $titleFitness, $detailFitness){
	    $query = "UPDATE programs SET title='$titleFitness', details='$detailFitness' WHERE id='$idFitness'";
	    
	    $result = self::getDB()->query($query);
    }
	
	public function disableUser($userId){
		// Simply change the password hash into HASH_disabled
		$user = User::getUserByUserId($userId);
		if (!isset($user)){
			$user = User::getUserById($userId);	
		}
		
		// If user doesn't exist throw an exception
		if (!isset($user)) throw new RuntimeException("User doesn't exist");
		
		$table = $this->usersTable;
		$field = $this->passwordField;
		$userPwd = $user->getPassword();
		if (strstr($userPwd, "_disabled")) return;
		$newValue = $userPwd . "_disabled";
		$query = "UPDATE $table SET $field = '$newValue' WHERE id = '$userId' OR username = '$userId'";
		self::getDb()->query($query);
	}
	
	public function enableUser($userId){
		// Simply change the password hash into HASH_disabled
		$user = User::getUserByUserId($userId);
		if (!isset($user)){
			$user = User::getUserById($userId);	
		}
		
		// If user doesn't exist throw an exception
		if (!isset($user)) throw new RuntimeException("User doesn't exist");
		
		$table = $this->usersTable;
		$field = $this->passwordField;
		$userPwd = $user->getPassword();
		if (!strstr($userPwd, "_disabled")) return;
		$newValue = str_replace("_disabled", "", $userPwd);
		$query = "UPDATE $table SET $field = '$newValue' WHERE id = '$userId' OR username = '$userId'";
		self::getDb()->query($query);
	}
	
	
	
}