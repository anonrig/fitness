<?php

session_start();

/**
 * This module is responsible for handling the GET and POST requests
 * made by the client. Each function acts as a "service" provided to
 * the client as an "interface" for the system.
 */

require_once("include/autoLoader.php");

/**
 * Error handling
 */
 
function authorizationError($msg = null){
	header("HTTP/1.1 403 Forbidden");
	echo "[Authorization error] $msg";
	die();
}

function authenticationError($msg = null){
	header("HTTP/1.1 401 Unauthorized");
	echo "[Authentication error] $msg";
	die();
}

function internalError($msg = null){
	header("HTTP/1.1 500 Internal Server Error");
	echo "[Server error] $msg";
	die();
}
 
/**
 * User registration and authentication
 * 
 * How it works:
 * - The user sends username and password
 * - The server encrypts the password and compare it with the stored hash
 * - If they match 3 things are set:
 * 		1) $_SESSION["username"] = $username
 * 		2) $_SESSION["authenticated"] = true
 * 		3) $_SESSION["ip_address"] = $ipaddress (to prevent session hijacking)
 */
 
 
function createUser($userInfo){
	$newUser = new User($userInfo);
	echo $newUser->toJson();
}

function authenticate($username, $password){
	// Set and return the token
	$user = User::getUserById($username);
	if ($user != null){
		$isAuth = $user->authenticate($password);
		if ($isAuth != -1){
			$_SESSION["username"] = $username;
			$_SESSION["ip"] = $_SERVER["REMOTE_ADDR"];
			$_SESSION["authenticated"] = true;
			$_SESSION["name"] = $user->getName();
			$_SESSION["userid"] = $user->getUserId();
			echo "User successfully authenticated!\n";
		} else {
			authenticationError("Wrong password");
		}
	} else {
		authenticationError("User does not exist");
	}
}

function checkAuthentication(){
	// Verify the token and the IP address
	if (isset($_SESSION["authenticated"])){
		return true;
	}
	return false;
}

function getAuthenticatedUser(){
	$user = null;
	if (checkAuthentication()){
		$user = User::getUserById($_SESSION["username"]);
	}
	return $user;
}

function deAuthenticate(){
	session_destroy();
	echo "User deauthenticated (or never authenticated)";
}

function deleteUser(){
	if (count($_SESSION) != 0){
		$loggedUser = $_SESSION["username"];
		$toDelete = User::getUserById($loggedUser);
		$toDelete->remove();
		deAuthenticate();
		echo "User successfully deleted";
	} else {
		authorizationError("You must log in before you can delete your account");
	}
}

function addExercise($user, $exerciseInfo){
	if (!isset($user)){
		authorizationError("Couldn't add an exercise");
	}
	$user->addExercise($exerciseInfo);
	
	if ($db == null){
		$db = new DBHelper();
	}
	
	$name = $exerciseInfo['name'];
	$programId = $user->getFitnessProgram()->getProgramId();
	$day = $exerciseInfo['day'];
	$repetition = $exerciseInfo['repetition'];
	$query = "SELECT id FROM programdetails WHERE name='$name' AND program_id = '$programId' AND day = '$day' AND repetition= '$repetition'";  
    $result = $db -> query($query);
    echo $result[0][0];
}

function deleteExercise($user, $exerciseInfo){
	if (!isset($user)){
		authorizationError("Couldn't delete an exercise");
	}
	$exerciseId = $exerciseInfo['exerciseid'];
	$user->deleteExercise($exerciseId);
	echo "Successfully deleted";
}

function addFitnessProgram($user, $progInfo){
	if (!isset($user)){
		authorizationError("Couldn't add a fitness program");
	}
	$prog = FitnessProgram::getFitnessProgramByUser($user);
	$username = $user->getUsername();
	if (!isset($prog)){
		$prog = new FitnessProgram($user, $progInfo["title"], $progInfo["details"]);
		echo "Fitness program added for user $username";
	} else {
		internalError("User $username already has a fitnessProgram");
	}
}

function getFitnessProgram($user){
	$program = $user->getFitnessProgram();
	print_r($program->toJson());
}

/*
function editFitnessProgram($user, $title, $details, $exercises = null){
	$program = $user->getFitnessProgram();
	$program->setTitle($title);
	$program->setDetails($details);
	if (isset($exercises)){
		$program->setExercises($exercises);
	}
	$program->save();
}
*/


function addComment($user, $_POST){
	if (!isset($user)){
		authorizationError("Couldn't add a comment");
	}
	$fitnessprog = FitnessProgram::getFitnessProgramById($_POST['fitness_id']);
	$fitnessprog->addComment($user->getUserId(), $_POST['comment']);
	
}

function contactForm($_POST)
{
	$title = "Fitness: Contact Form by " . $_POST['sender'];
	$from = "From: " . $_POST['email'];
	mail("yagiznizipli@me.com", $title , $_POST['message'], $from );
}

function getAllUsers(){
	echo json_encode(User::getAllUsers());
}

function getAllPrograms(){
	echo json_encode(FitnessProgram::getAllPrograms());
}

function editProfile($user, $profileInfo){
	foreach ($profileInfo as $name => $value){
		$user->set($name, $value);
	}
	$user->save();
	print_r($user->toArray());
}

function adminEditUser($profileInfo){
	$userID = $profileInfo['adminedituserid'];
	$edittedUser = User::getUserByUserId($userID);
	
	unset($profileInfo['adminedituserid']);
	unset($profileInfo['operation']);
	
	$currentUser = getAuthenticatedUser(false);
	if ($currentUser->isAdmin()){
		//echo "girdi";
		try {
			foreach ($profileInfo as $name => $value){
				$edittedUser->set($name, $value);
				echo "$name -> $value";
			}
			
			$edittedUser->save();
			//var_dump($edittedUser);
			echo "User $userID correctly edited";
		} catch (Exception $e){
			internalError("Something went wrong. Maybe the user doesn't exist!");
		}
	} else {
		authenticationError("You are not an administrator!");
	}
}

function adminEditComment($_POST){
	$currentUser = getAuthenticatedUser(false);
	$comment_id = $_POST['id'];
	$comment_text = $_POST['comment_text'];
	
	if ($currentUser->isAdmin()){

		try {
			$currentUser->getUserType()->editComment($comment_id, $comment_text);
			echo "Comment $comment_id correctly edited";
		} catch (Exception $e){

			internalError("Something went wrong. Maybe the comment doesn't exist!");
		}
	} else {

		authenticationError("You are not an administrator!");
	}
}

function disableUser($userId){
	$currentUser = getAuthenticatedUser(false);
	if ($currentUser->isAdmin()){
		try {
			$currentUser->getUserType()->disableUser($userId);
			echo "User $userId correctly disabled";
		} catch (Exception $e){
			internalError("Something went wrong. Maybe the user doesn't exist!");
		}
	} else {
		authenticationError("You are not an administrator!");
	}
}

function enableUser($userId){
	$currentUser = getAuthenticatedUser(false);
	if ($currentUser->isAdmin()){
		try {
			$currentUser->getUserType()->enableUser($userId);
			echo "User $userId correctly enabled";
		} catch (Exception $e){
			internalError("Something went wrong. Maybe the user doesn't exist!");
		}
	} else {
		authenticationError("You are not an administrator!");
	}
}

function adminEditProgram($_POST){
	$idFitness = $_POST['id'];
	$detailFitness = $_POST['detail'];
	$titleFitness = $_POST['title'];
	$currentUser = getAuthenticatedUser(false);
	if ($currentUser->isAdmin()){
		try {
			$currentUser->getUserType()->editProgram($idFitness, $titleFitness, $detailFitness);
			echo "Program $idFitness correctly edited";
		} catch (Exception $e){
			internalError("Something went wrong. Maybe the user doesn't exist!");
		}
	} else {
		authenticationError("You are not an administrator!");
	}
}

function deleteComment($_POST){
	$comment_id = $_POST['comment_id'];
	$currentUser = getAuthenticatedUser(false);
	if ($currentUser->isAdmin()){
		try {
			$currentUser->getUserType()->deleteComment($comment_id);
			echo "Comment $comment_id successfully deleted";
		} catch (Exception $e){
			internalError("Something went wrong. Maybe the comment doesn't exist!");
		}
	} else {
		authenticationError("You are not an administrator!");
	}
}

function searchUsers($_POST){
	$searchKey = $_POST['key'];
	
	$result = User::searchUsers($searchKey);
	
	echo $result;
	
}

function mergeExercise($user, $exercise){
	if (!isset($user)){
		authorizationError("Couldn't add an exercise");
	}
	
	$exerciseId = $exercise['exerciseId'];
	$exerciseDay = $exercise['day'];
	//gets exercise id, and day of that exercise and returns the user's exercises on that day as a json
	
	
	$fitnessProg = $user->getFitnessProgram();
	
	$specificExercise = $fitnessProg->getExerciseById($exerciseId);
	$specificDay = $fitnessProg->displaySpecificDay($exerciseDay);
	
	print_r($specificDay);
}

function mergeExerciseStep2($user, $exercise){
	if (!isset($user)){
		authorizationError("Couldn't add an exercise");
	}
	$fitnessProg = $user->getFitnessProgram();
	$exerciseId = $exercise['id'];
	$exerciseDay = $exercise['day'];
	
	$fitnessProg->mergeExercise($exerciseId);
}

function editFitnessProgram($user, $information){
	
	if (!isset($user)){
		authorizationError("Couldn't edit exercise");
	}

	
	$fitnessTitle = $information['title'];
	$fitnessDetails = $information['details'];
	
	$fitnessprog = $user->getFitnessProgram();
	$fitnessprog->editFitnessProgram($fitnessTitle, $fitnessDetails);
	echo "Successfully edited fitness $fitnessTitle";
	
}

function getSpecificDay($user, $information){
	if (!isset($user)){
		authorizationError("Couldn't edit exercise");
	}
	
	$day = $information['day'];
	
	$fitnessprog = $user->getFitnessProgram();
	$result = $fitnessprog->displaySpecificDay($day);
	
	echo $result;
}

/**
 * Requests dispatcher
 */

$operation = isset($_POST["operation"])? $_POST["operation"] : null;

switch($operation){
	case "createUser":
		createUser($_POST);
		break;
	
	case "authenticate":
		authenticate($_POST["username"], $_POST["password"]);
		break;
		
	case "checkAuthentication":
		checkAuthentication();
		break;
		
	case "deAuthenticate":
		deAuthenticate();
		break;
	
	case "deleteUser":
		deleteUser();
		break;
	
	case "addExercise":
		$user = getAuthenticatedUser();
		addExercise($user, $_POST);
		break;
		
	case "deleteExercise":
		$user = getAuthenticatedUser();
		deleteExercise($user, $_POST);
		break;
		
	case "addFitnessProgram":
		$user = getAuthenticatedUser();
		addFitnessProgram($user, $_POST);
		break;
		
/*
	case "editFitnessProgram":
		$user = getAuthenticatedUser();
		if (count($_POST) <= 3){
			editFitnessProgram($user, $_POST["title"], $_POST["details"]);
		} else {
			editFitnessProgram($user, $_POST["title"], $_POST["details"], $_POST["exercises"]);
		}
		break;
*/
		
	case "removeFitnessProgram":
		// TODO 
		break;
		
	case "editProfile":
		$user = getAuthenticatedUser();
		editProfile($user, $_POST);
		break;
		
	case "adminEditUser": //edit function for administrators
		adminEditUser($_POST);
		break;
	
	
	case "getUserJSON": //should include username and password as $_POST params
		getUserJSON($_POST);
		break;
		
	case "getFitnessProgram":
		if (array_key_exists("programId", $_POST)){
			$program = FitnessProgram::getFitnessProgramById($_POST["programId"]);
			print_r($program->toJson());
		} else if (array_key_exists("userId", $_POST)){
			$user = User::getUserByUserId($_POST["userid"]);
			getFitnessProgram($user);
		} else {
			$user = getAuthenticatedUser();
			getFitnessProgram($user);
		}
		break;
		
	case "getAllUsers":
		getAllUsers();
		break;
		
	case "getAllPrograms":
		getAllPrograms();
		break;
		
	case "getAllComments":
		getAllComments($user, $_POST);
		break;
		
	case "addComment":
		$user = getAuthenticatedUser();
		addComment($user, $_POST);
		break;
		
	case "contact":
		contactForm($_POST);
		break;
		
	case "disableUser":
		disableUser($_POST["userId"]);
		break;
		
	case "enableUser":
		enableUser($_POST["userId"]);
		break;
		
	case "mergeExercise":
		$user = getAuthenticatedUser();
		mergeExercise($user, $_POST);
		break;
		
	case "mergeExerciseStep2":
		$user = getAuthenticatedUser();
		mergeExerciseStep2($user, $_POST);
		break;
		
	case "adminEditComment":
		adminEditComment($_POST);
		break;
		
	case "adminEditProgram":
		adminEditProgram($_POST);
		break;
		
	case "deleteComment":
		deleteComment($_POST);
		break;
		
	case "editFitnessProgram":
		$user = getAuthenticatedUser();
		editFitnessProgram($user, $_POST);
		break;
		
	case "editExercise":
		$user = getAuthenticatedUser();
		editExercise($user, $_POST);
		break;
	
	case "getSpecificDay":
		$user = getAuthenticatedUser();
		getSpecificDay($user, $_POST);
		break;
		
	case "search":
		searchUsers($_POST);
		break;
		
	default :
		// Must NOT be indented!!
echo <<<EOF
<h1>INFO:</h1>
	<p><b>operation</b>: what operation must be performed (createUser, deleteUser, authenticate, checkAuthentication, deAuthenticate, createFitnessProgram, addExercise)
	</p>
	<p>(Each operation has different parameters)
	</p>
EOF;
		break;
}
