<?php

	# getting info to connect to the database
	require'loginInfo.php';

	# new connection using login stored in "loginInfo.php"
	$conn = new mysqli($hostAddress, $uname, $pword, $database);
	if($conn->connect_error) die($conn->connect_error);

	//TODO error on not logged in
	# get username
	$username = $_COOKIE["loggedIn"];

	# log out
	setcookie("loggedIn", "", time()-3600);

	#Delete account
	$stmt = $conn->prepare("DELETE FROM userInfo WHERE userName=?");
	if(!$stmt) die ($conn->error);
	$stmt->bind_param("s", $username); #? replaced with $username
	$stmt->execute();

	$stmt->close();
	$conn->close();
?>
