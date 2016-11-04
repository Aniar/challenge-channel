<?php  #learning php,mysql + javascript was heavily used
	require_once 'loginInfo.php'; #getting info to connect to the database


	function authenticate($username, $password, $databaseInfo){
		#new connection
		$conn = new mysqli($databaseInfo->hostAddress, $databaseInfo->username, $databaseInfo->password, $databaseInfo->database); 
		if($conn->connect_error) die($conn->connect_error);

		$stmt = $conn->prepare("SELECT * FROM userInfo WHERE userName = ?");
		$stmt->bind_param("s", $username);
		$stmt->execute();

		#get record and make into associative array
		$stmt->bind_result($result);

		#should NEVER have multiple identical usernames
		assert($stmt->num_rows==1);

		$verified = false;

		#verify password
		if(password_verify($password, $result->fetch_assoc()['password'])){
			#set cookie to remember login for 1 month on entire domain
			setcookie("loggedIn", true, strtotime("+1 month"), "/");
			
			$verified = true;
		}

		#cleanup
		$stmt->close();
		$conn->close();

		return $verified;
		}

	if($_COOKIE["loggedIn"]){
		echo "Already logged In!!!";
	}
	else{
		#create database login info object
		$databaseLogin = new stdClass;
		$databaseLogin->hostAddress =  $hostAddress;
		$databaseLogin->database = $database;
		$databaseLogin->username = $uname
		$databaseLogin->password = $pword;

		#check user in database
		if(authenticate($_POST["username"], $_POST["password"], $databaseLogin)){
			echo "Logged In!!!";
		}
		else{
			echo "Not logged in";
		}
	}

	echo " HELLO";

?>