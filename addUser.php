<?php

	# main
	if(!empty($_POST['firstName']) &&
		!empty($_POST['lastName']) &&
		!empty($_POST['userName']) &&
		!empty($_POST['email']) &&
		!empty($_POST['password']) &&
		!empty($_POST['age']))
	{
		echo json_encode(addUser());
	}

	function addUser(){
		$data = array();
		$errors = array();

		# getting info to connect to the database
		require'loginInfo.php';

		# new connection using login stored in "loginInfo.php"
		$conn = new mysqli($hostAddress, $uname, $pword, $database);
		if($conn->connect_error) return databaseError($conn->connect_error);

		$firstName = get_post($conn, 'firstName');
		$lastName = get_post($conn, 'lastName');
		$userName = get_post($conn, 'userName');
		$email = get_post($conn, 'email');
		$password = password_hash(get_post($conn, 'password'), PASSWORD_DEFAULT);
		$age = get_post($conn, 'age');
		

		if(isConflict($conn, 'userName', $userName)){
			$errors['userName'] = "Username taken";
		}
		if(isConflict($conn, 'email', $email)){
			$errors['email'] = "Email address already in use";
		}
		if(!empty($errors)){
			$data['errors'] = $errors;
			$conn->close();
			return $data;
		}

		# insert into database

		# set up query and post it to database
		$stmt = $conn->prepare("INSERT INTO userInfo VALUES(?,?,?,?,?,?,NULL)");
		if(!$stmt) return databaseError($conn->error);
		$stmt->bind_param("sssssi", $firstName, $lastName, $userName, $email, $password, $age); # 's' means string, 'i' is integer
		$stmt->execute();

		$stmt->close();
		$conn->close();

		$data['message'] = "Nice, your account has been created!";
		return $data;
	}

	function databaseError($error){
		$errors['database'] = $error;
		$data['errors'] = $errors;
		return $data;
	}

	function get_post($database, $var){
		return $database->real_escape_string($_POST[$var]);
	}

	# Check for database conflicts
	function isConflict($database, $fieldName, $fieldValue){

		# set up query and post it to database
		$stmt = $database->prepare("SELECT userName FROM userInfo WHERE $fieldName = ?");
		if(!$stmt) databaseError($database->error);
		$stmt->bind_param("s", $fieldValue);
		$stmt->execute();
		$stmt->store_result();
		# $fieldName already being used 
		if($stmt->num_rows > 0){
			$stmt->close();
			return true;
		}
		$stmt->close();
		return false;
	}

?>