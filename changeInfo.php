<?php

	# getting info to connect to the database
	require'loginInfo.php';

	# new connection using login stored in "loginInfo.php"
	$conn = new mysqli($hostAddress, $uname, $pword, $database);
	if($conn->connect_error) die($conn->connect_error);

	# get username
	$username = $_COOKIE["loggedIn"];
	updateDetails($username, 'firstName', "s", $conn);
	updateDetails($username, 'lastName', "s", $conn);
	updateDetails($username, 'age', "i", $conn);
	updateDetails($username, 'email', "s", $conn);
	updateDetails($username, 'password', "s", $conn);

	$conn->close();

	function updateDetails($username, $field, $type, $conn){
		if(!empty($_POST[$field])){
			$value = $_POST[$field];
			if($field=='password')
				$value = password_hash($_POST[$field], PASSWORD_DEFAULT);

			$stmt = $conn->prepare("UPDATE userInfo SET $field=? WHERE userName=?");
			if(!$stmt) die($conn->error);
			$stmt->bind_param($type."s", $value, $username); # 's' means string
			$stmt->execute();

			$stmt->close();
		}
	}

?>
