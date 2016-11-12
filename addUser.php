<?php

	#main
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

		#getting info to connect to the database
		require'loginInfo.php';

		#new connection using login stored in "loginInfo.php"
		$conn = new mysqli($hostAddress, $uname, $pword, $database);
		if($conn->connect_error) die($conn->connect_error);

		$firstName = get_post($conn, 'firstName');
		$lastName = get_post($conn, 'lastName');
		$userName = get_post($conn, 'userName');
		$email = get_post($conn, 'email');
		$password = password_hash(get_post($conn, 'password'), PASSWORD_DEFAULT);
		$age = get_post($conn, 'age');
		

		$test = &$conn; // TODO remove
		if(isConflict($test, 'userName', $userName)){
			$errors['userName'] = "Username taken";
		}
		if(isConflict($test, 'email', $email)){
			$errors['email'] = "Email address already in use";
		}
		if(!empty($errors)){
			$data['errors'] = $errors;
			$conn->close();
			return $data;
		}

		#insert into database

		#set up query and post it to database
		$stmt = $conn->prepare("INSERT INTO userInfo VALUES(?,?,?,?,?,?)");
		$stmt->bind_param("ssssss", $firstName, $lastName, $userName, $email, $password, $age);
		$stmt->execute();
		if(!$stmt) die ($conn->error);

		$stmt->close();
		$conn->close();

		$data['message'] = "Nice, your account has been created!";
		return $data;
	}

	function get_post($database, $var){
		return $database->real_escape_string($_POST[$var]);
	}

	# Check for database conflicts
	function isConflict($database, $fieldName, $fieldValue){

		#set up query and post it to database
		$stmt = $database->prepare("SELECT * FROM userInfo WHERE $fieldName = ?");
		$stmt->bind_param("s", $fieldValue);
		$stmt->execute();
		if(!$stmt) die ($database->error);

		#store result
		$result = $stmt->get_result();
		$stmt->fetch();

		$stmt->close();

		// $fieldName already being used 
		if($result->num_rows > 0){
			return true;
		}
		return false;
	}

?>