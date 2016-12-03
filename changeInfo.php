<?php

	# getting info to connect to the database
	require'loginInfo.php';

	# new connection using login stored in "loginInfo.php"
	$conn = new mysqli($hostAddress, $uname, $pword, $database);
	if($conn->connect_error) die($conn->connect_error);

	//TODO error handling when not logged in
	# get username
	$username = $_COOKIE['loggedIn'];
	# get fieldname
	$field = $_POST['name'];

	if(!empty($_POST[$field])){
		$value = $_POST[$field];
		$type = "s";
		if($field=='password')
			$value = password_hash($_POST[$field], PASSWORD_DEFAULT);
		else if($field=='age')
			$type = "i";

		$stmt = $conn->prepare("UPDATE userInfo SET $field=? WHERE userName=?");
		if(!$stmt) die($conn->error);
		$stmt->bind_param($type."s", $value, $username); # 's' means string
		$stmt->execute();

		$stmt->close();
		$conn->close();

		echo json_encode(true);
	}

?>
