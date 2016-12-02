<?php

	# getting info to connect to the database
	require'loginInfo.php';

	# new connection using login stored in "loginInfo.php"
	$conn = new mysqli($hostAddress, $uname, $pword, $database);
	if($conn->connect_error) die($conn->connect_error);

	# get username
	$username = $_COOKIE["loggedIn"];

	if(!empty($_POST['fname'])){
		# first name
		$fname = $_POST['fname'];

		$stmt = $conn->prepare("UPDATE userInfo SET firstName=? WHERE userName=?");
		if(!$stmt) die($conn->error);
		$stmt->bind_param("ss", $fname, $username); # 's' means string
		$stmt->execute();

	} else if (!empty($_POST['lname'])) {
		# last name
		$lname = $_POST['lname'];
		
		$stmt = $conn->prepare("UPDATE userInfo SET lastName=? WHERE userName=?");
		if(!$stmt) die($conn->error);
		$stmt->bind_param("ss", $lname, $username); # 's' means string
		$stmt->execute();

	} else if (!empty($_POST['age'])){
		# age
		$age = $_POST['age'];
		
		$stmt = $conn->prepare("UPDATE userInfo SET age=? WHERE userName=?");
		if(!$stmt) die($conn->error);
		$stmt->bind_param("is", $age, $username); # 'i' means integer, 's' means string
		$stmt->execute();

	} else if (!empty($_POST['email'])){
		# email
		$email = $_POST['email'];
		
		$stmt = $conn->prepare("UPDATE userInfo SET email=? WHERE userName=?");
		if(!$stmt) die($conn->error);
		$stmt->bind_param("ss", $email, $username); # 's' means string
		$stmt->execute();

	} else if (!empty($_POST['password'])){
		# password
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		
		$stmt = $conn->prepare("UPDATE userInfo SET password=? WHERE userName=?");
		if(!$stmt) die($conn->error);
		$stmt->bind_param("ss", $password, $username); # 's' means string
		$stmt->execute();
	}

?>
