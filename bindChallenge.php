<?php

	# code to retrieve challenge from database
	require 'getChallenge.php';
	# getting info to connect to the database
	require'loginInfo.php';

	$username = $_COOKIE['loggedIn'];

	# new connection using login stored in "loginInfo.php"
	$conn = new mysqli($hostAddress, $uname, $pword, $database);
	if($conn->connect_error) databaseError($conn->connect_error);

	# get challenge info
	$newChallenge = getChallenge($_POST['creator'].":".$_POST['title'], $conn);

	if(!$newChallenge['title']) databaseError("Challenge does not exist.");

	# get bound challenges
	$stmt = $conn->prepare("SELECT challenges FROM userInfo WHERE userName = ?");
	if(!$stmt) databaseError($conn->error);
	$stmt->bind_param("s", $username); # 's' means string
	$stmt->execute();

	# store result
	$stmt->bind_result($challenges);
	$stmt->fetch();
	$stmt->close();

	if(is_null($challenges)) # No bound challenges
		$challenges = array($newChallenge['title'] => 0); # store challenge with currentTask as 1
	else{
		$challenges = unserialize($challenges); # get real array from serialized string
		if($challenges[$newChallenge['title']]) databaseError("Duplicate challenge");
		$challenges[$newChallenge['title']] = 0; # store challenge with currentTask as 1
	}
	$challenges = serialize($challenges); # serialize for storage

	# bind challenge list to username
	$stmt = $conn->prepare("UPDATE userInfo SET challenges = ? WHERE userName = ?");
	if(!$stmt) databaseError($conn->error);
	$stmt->bind_param("bs", $challenges, $username); # 'b' means blob, 's' means string
	$stmt->send_long_data(0, $challenges); # 0 means arg[0]. Have to send blobs this way as they may be super big
	$stmt->execute();

	$stmt->close();
	$conn->close();

	$newChallenge['tasks'] = unserialize($newChallenge['tasks']);

	echo json_encode($newChallenge);

	function databaseError($error){
		$newChallenge['error'] = $error;
		echo json_encode($newChallenge);
		exit();
	}

?>