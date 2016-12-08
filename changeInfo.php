<?php

	# getting info to connect to the database
	require'loginInfo.php';

	$data['success'] = false;

	# get username
	$username = $_COOKIE['loggedIn'];
	# get fieldname
	$field = $_POST['name'];

	if(!empty($_POST[$field])){
		# new connection using login stored in "loginInfo.php"
		$conn = new mysqli($hostAddress, $uname, $pword, $database);
		if($conn->connect_error) die($conn->connect_error);

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

		$data['rows'] = $conn->affected_rows;
		if($conn->affected_rows < 0)
			$data['error'] = $conn->error;
		else
			$data['success'] = true;

		$stmt->close();
		$conn->close();
	}

	echo json_encode($data);

?>