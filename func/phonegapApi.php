<?

$con = mysql_connect("192.254.233.174:3306", "ynizipli_fitness", "4561230");
mysql_select_db("ynizipli_fitness", $con) or die("Error connecting to database!");

function authenticateMain($_POST)
{
	$userName = $_POST['username'];
	$password = $_POST['password'];
	
	$getSalt = mysql_query("SELECT salt FROM users WHERE username='$userName'");
	while($info = mysql_fetch_array($getSalt))
	{
		$userSalt = $info['salt'];
	} 	
	
	$hashedPassword = sha1($password.$userSalt);

	$query = mysql_query("SELECT * FROM users WHERE username='$userName' AND password='$hashedPassword'");
	$numQuery = mysql_num_rows($query);
	if ($numQuery != 1)
	{
		echo "fail";
	} else {
		echo "success";
	}
}

function authenticate($_POST)
{
	$userName = $_POST['username'];
	$password = $_POST['password'];
	
	$getSalt = mysql_query("SELECT salt FROM users WHERE username='$userName'");
	while($info = mysql_fetch_array($getSalt))
	{
		$userSalt = $info['salt'];
	} 	
	
	$hashedPassword = sha1($password.$userSalt);

	$query = mysql_query("SELECT * FROM users WHERE username='$userName' AND password='$hashedPassword'");
	$numQuery = mysql_num_rows($query);
	if ($numQuery != 1)
	{
		return "fail";
	} else {
		return "success";
	}
}


function getUserInformation($_POST) {
	
	if ((authenticate($_POST)) == "success")
	{
		$userName = $_POST['username'];
		$result = mysql_query("SELECT * FROM users WHERE username='$userName'");
		$arr = array();
		
		while($row = mysql_fetch_assoc($result)) {
			array_push($arr, $row);
		}

		echo json_encode($arr, JSON_FORCE_OBJECT);
	} else {
		echo "fail";
	}
}

function generateSalt($length = 10) {
	$symbols = "abcdefghijklmnopqrstuvwxyz";
	$symbols .= strtoupper($symbols);
	$symbols .= "+-*_";
	$random = str_shuffle($symbols);
	return substr($random, 0, $length);
}

function createUser($_POST) {
	$nameUser = $_POST['name']; 
	$usernameUser = $_POST['username'];
	$emailUser = $_POST['email'];
	$passwordUser = $_POST['password'];
	$pictureUser = $_POST['picture'];
	$ageUser = $_POST['age'];
	$heightUser = $_POST['height'];
	$massUser = $_POST['mass'];
	$expUser = $_POST['experience'];
	$fat_percentageUser =  $_POST['fat_percentage'];
	$genderUser = $_POST['gender'];
	$bioUser = $_POST['bio'];
	
	$generatedSalt = generateSalt();
	$hashedPassword = sha1($passwordUser.$generatedSalt);
	$query = "INSERT INTO users (username, salt, password, name, email, picture, gender, age, height, mass, experience, fat_percentage, bio, created_at, updated_at, provider) VALUES ('$usernameUser', '$generatedSalt', '$hashedPassword', '$nameUser', '$emailUser', '$pictureUser', '$genderUser', '$ageUser', '$heightUser', '$massUser', '$expUser', '$fat_percentageUser', '$bioUser', DATE_ADD(NOW(), INTERVAL 8 HOUR), DATE_ADD(NOW(), INTERVAL 8 HOUR), 'mobile_app')";
	
	if (mysql_query($query))
	{
		echo "success";
	} else {
		echo "fail";
	}
	
}

function getAllUsers($_POST) {
	if ((authenticate($_POST)) == "success")
	{
		$result = mysql_query("SELECT * FROM users");
		$arr = array();
		
		while($row = mysql_fetch_assoc($result)) {
			array_push($arr, $row);
		}

		echo json_encode($arr, JSON_FORCE_OBJECT);
	} else {
		echo "fail";
	}
}

function getAllFitnessPrograms($_POST) {
	if ((authenticate($_POST)) == "success")
	{
		$result = mysql_query("SELECT * FROM programs");
		$arr = array();
		
		while($row = mysql_fetch_assoc($result)) {
			array_push($arr, $row);
		}

		echo json_encode($arr, JSON_FORCE_OBJECT);
	} else {
		echo "fail";
	}
}

function getSpecificFitnessProgram($_POST) {
	if ((authenticate($_POST)) == "success")
	{
		$requestedFitnessId = $_POST['requested'];
		$result = mysql_query("SELECT * FROM programdetails pd, programs p WHERE p.user_id = pd.user_id AND p.user_id = '$requestedFitnessId' ORDER BY pd.day ASC");

		$arr = array();
		$detailsAdded = false;
		while($row = mysql_fetch_assoc($result)) {
			if (!$detailsAdded) {
				$detailsAdded = true;
				array_push($arr, $row);
			} else {
				unset($row["details"]);
				unset($row["created_at"]);
				unset($row["updated_at"]);
				unset($row["title"]);
				unset($row["user_id"]);
				array_push($arr, $row);
			}
		}

		echo json_encode($arr, JSON_FORCE_OBJECT);
	} else {
		echo "fail";
	}
}

function getCurrentUserId($currentUserName)
{	

	$result = "SELECT id FROM users WHERE username='$currentUserName'";
	$result = mysql_query($result);
	$result = mysql_fetch_assoc($result);
	return ($result['id']);
}

function myFitnessProgram($_POST) {
	if ((authenticate($_POST)) == "success")
	{
		$requestedFitnessId = getCurrentUserId($_POST['username']);
		$result = mysql_query("SELECT * FROM programdetails pd, programs p WHERE p.user_id = pd.user_id AND p.user_id = '$requestedFitnessId' ORDER BY pd.day ASC");

		$arr = array();
		$detailsAdded = false;
		while($row = mysql_fetch_assoc($result)) {
			if (!$detailsAdded) {
				$detailsAdded = true;
				array_push($arr, $row);
			} else {
				unset($row["details"]);
				unset($row["created_at"]);
				unset($row["updated_at"]);
				unset($row["title"]);
				unset($row["user_id"]);
				array_push($arr, $row);
			}
		}

		echo json_encode($arr, JSON_FORCE_OBJECT);
	} else {
		echo "fail";
	}
}

function getSpecificProfile($_POST) {
	if ((authenticate($_POST)) == "success")
	{
		$currentUserId = getCurrentUserId($_POST['username']);
		$requestedUserId = $_POST['requested'];
		$result = mysql_query("SELECT * FROM users WHERE id = '$requestedUserId'");

		$arr = array();
		$query = "SELECT * FROM friends WHERE user = '$currentUserId' AND friend='$requestedUserId'";
		$query = mysql_query($query);
		$query = mysql_num_rows($query);
		
		//did he/she
		$isfriend = "SELECT * FROM friendrequests WHERE sender='$currentUserId' AND receiver='$requestedUserId'";
		$isfriend = mysql_query($isfriend);
		$isfriend = mysql_num_rows($isfriend);
		
		
		$didaddme = "SELECT * FROM friendrequests WHERE sender='$requestedUserId' AND receiver='$currentUserId'";
		/* echo $didaddme; */
		$didaddme = mysql_query($didaddme);
		$didaddme = mysql_num_rows($didaddme);

		
		$counter = 0;
		while($row = mysql_fetch_assoc($result)) {
			array_push($arr, $row);
				$arr[$counter]['isfriend'] = (string)$query;
				$arr[$counter]['friendrequested'] = (string)$isfriend;
				$arr[$counter]['didaddme'] = (string)$didaddme;
			$counter++;
		}
		

		echo json_encode($arr, JSON_FORCE_OBJECT);
	} else {
		echo "fail";
	}
}



function addFriend($_POST){
	if ((authenticate($_POST)) == "success")
	{
		$currentUser = $_POST['username'];
		$currentUserId = getCurrentUserId($currentUser);
		$addedUser = $_POST['addeduser'];
		$query = "INSERT INTO friendrequests(sender, receiver, status, created_at, updated_at) VALUES ('$currentUserId', '$addedUser', '0', DATE_ADD(NOW(), INTERVAL 8 HOUR), DATE_ADD(NOW(), INTERVAL 8 HOUR))";
		
		if (mysql_query($query))
		{
			echo "success";
		} else {
			echo "fail";
		}
	}
	
}

function showAllFriends($_POST){
	if ((authenticate($_POST)) == "success")
	{
		$currentUser = $_POST['username'];
		$currentUserId = getCurrentUserId($currentUser);
		
		$query = "SELECT * FROM users u, friends f WHERE f.user = '$currentUserId' AND f.friend = u.id";
		
		if ($result = mysql_query($query))
		{
			$arr = array();
			while($row = mysql_fetch_assoc($result)) {
				array_push($arr, $row);
			}
	
			echo json_encode($arr, JSON_FORCE_OBJECT);
		} else {
			echo "fail";
		}
	}
}

function showFriendRequests($_POST){
	if ((authenticate($_POST)) == "success")
	{
		$currentUser = $_POST['username'];
		$currentUserId = getCurrentUserId($currentUser);
		
		$query = "SELECT u.id, u.name FROM users u, friendrequests fr WHERE fr.receiver = '$currentUserId' AND fr.sender = u.id";
		
		if ($result = mysql_query($query))
		{
			$arr = array();
			while($row = mysql_fetch_assoc($result)) {
				array_push($arr, $row);
			}
	
			echo json_encode($arr, JSON_FORCE_OBJECT);
		} else {
			echo "fail";
		}
	}
}
//
function acceptFriend($_POST){
	if ((authenticate($_POST)) == "success")
	{
		
		$currentUser = $_POST['username'];
		$currentUserId = getCurrentUserId($currentUser);
		$acceptedUser = $_POST['accepteduser'];
		$query = "DELETE FROM friendrequests WHERE sender='$acceptedUser'";
		if (mysql_query($query))
		{
			$query = "INSERT INTO friends(user, friend, status, created_at, updated_at) VALUES ('$currentUserId', '$acceptedUser', '1', DATE_ADD(NOW(), INTERVAL 8 HOUR), DATE_ADD(NOW(), INTERVAL 8 HOUR))";
			
			//echo $query;
			if (mysql_query($query))
			{
				$query = "INSERT INTO friends(user, friend, status, created_at, updated_at) VALUES ('$acceptedUser', '$currentUserId', '1', DATE_ADD(NOW(), INTERVAL 8 HOUR), DATE_ADD(NOW(), INTERVAL 8 HOUR))";
				if (mysql_query($query))
				{
					echo "success";
				} else {
					echo "fail";
				}
				
			} else {
				echo "fail";
			}
		} else {
			echo "fail";
		}
	}
}

function denyFriend($_POST){
	if ((authenticate($_POST)) == "success")
	{
		$currentUser = $_POST['username'];
		$currentUserId = getCurrentUserId($currentUser);
		$deniedUser = $_POST['denyuser'];
		$query = "DELETE FROM friendrequests WHERE sender='$deniedUser' AND receiver='$currentUserId'";
		//echo $query;
		if (mysql_query($query))
		{
			echo "success";
		} else {
			echo "fail";
		}
	} else {
		echo "fail";
	}
}



function addProgram($_POST)
{
	if ((authenticate($_POST)) == "success")
	{
		$currentUserId = getCurrentUserId($_POST['username']);
		$fitnessTitle = $_POST['programtitle'];
		$fitnessDescription = $_POST['programdesc'];
		$query = "INSERT INTO programs(title, details, user_id, created_at, updated_at) VALUES ('$fitnessTitle', '$fitnessDescription', '$currentUserId', DATE_ADD(NOW(), INTERVAL 8 HOUR), DATE_ADD(NOW(), INTERVAL 8 HOUR))";
		
		if (mysql_query($query))
		{
			$query = mysql_query("SELECT id FROM programs WHERE user_id = '$currentUserId'");
			$query = mysql_fetch_assoc($query);
			$query = $query['id'];
			echo $query;
		} else {
			echo "fail";
		}
	} else {
		echo "fail";
	}
}

function addExercise($_POST)
{
	if ((authenticate($_POST)) == "success")
	{
		$currentUserId = getCurrentUserId($_POST['username']);
		$currentProgramId = $_POST['programid'];
		$exerciseName = $_POST['exercisename'];
		$dayCount = $_POST['daycount'];
		
		$query = "INSERT INTO programdetails(name, program_id, day, user_id, created_at, updated_at) VALUES ('$exerciseName', '$currentProgramId', '$dayCount', '$currentUserId', DATE_ADD(NOW(), INTERVAL 8 HOUR), DATE_ADD(NOW(), INTERVAL 8 HOUR))";
		
		if (mysql_query($query))
		{
			echo "success";
		} else {
			echo "fail";
		}
	} else {
		echo "fail";
	}
}

function doHaveFitnessprogram($_POST)
{
	if ((authenticate($_POST)) == "success")
	{
		$currentUserId = getCurrentUserId($_POST['username']);
		$query = mysql_query("SELECT * FROM programs WHERE user_id='$currentUserId'");
		$query = mysql_num_rows($query);
		
		if ($query > 0)
		{
			echo "yes";
		} else {
			echo "no";
		}
	}
}
/**
 * Requests dispatcher
 */

$operation = isset($_POST["operation"])? $_POST["operation"] : null;

switch($operation){

	case "doHaveFitnessprogram":
		doHaveFitnessprogram($_POST);
		break;
		
	case "createUser":
		createUser($_POST);
		break;
	
	case "authenticate":
		authenticateMain($_POST);
		break;
		
	case "getUserInformation":
		getUserInformation($_POST);
		break;
		
	case "addProgram":
		addProgram($_POST);
		break;
		
	case "addExercise":
		addExercise($_POST);
		break;
		
	case "editProfile":
		editProfile($_POST);
		break;
		
	case "editProgram":
		editProgram($_POST);
		break;	
	
	case "getAllUsers":
		getAllUsers($_POST);
		break;
		
	case "getAllFitnessPrograms":
		getAllFitnessPrograms($_POST);
		break;
		
	case "getSpecificFitnessProgram":
		getSpecificFitnessProgram($_POST);
		break;
		
	case "getSpecificProfile":
		getSpecificProfile($_POST);
		break;
		
	case "addFriend":
		addFriend($_POST);
		break;
		
	case "acceptFriend":
		acceptFriend($_POST);
		break;
	
	case "denyFriend":
		denyFriend($_POST);
		break;
		
	case "showAllFriends":
		showAllFriends($_POST);
		break;
		
	case "showFriendRequests":
		showFriendRequests($_POST);
		break;
		
	case "myFitnessProgram":
		myFitnessProgram($_POST);
		break;
		
	default :
		// Must NOT be indented!!
echo <<<EOF
<h1>API GENERATOR</h1>
	
EOF;
		break;
}


?>