<?php

	# code to retrieve challenge from database
	require 'getChallenge.php';
	# getting info to connect to the database
	require'loginInfo.php';

	//TODO error handling for not logged in
	$username = $_COOKIE['loggedIn'];

	# new connection using login stored in "loginInfo.php"
	$conn = new mysqli($hostAddress, $uname, $pword, $database);
	if($conn->connect_error) die($conn->connect_error);

	# get challenge info
	$newChallenge = getChallenge($_POST['title'], $conn);

	# get bound challenges
	$stmt = $conn->prepare("SELECT challenges FROM userInfo WHERE userName = ?");
	if(!$stmt) die($conn->error);
	$stmt->bind_param("s", $username); # 's' means string
	$stmt->execute();

	# store result
	$result = $stmt->get_result();
	$stmt->fetch();

	$challenges = $result->fetch_assoc()['challenges'];
	if(is_null($challenges)) # No bound challenges
		$challenges = array($newChallenge['title'] => 1); # store challenge with currentTask as 1
	else{
		$challenges = unserialize($challenges); # get real array from serialized string
		$challenges[$newChallenge['title']] = 1; # store challenge with currentTask as 1
	}
	$challenges = serialize($challenges); # serialize for storage

	# bind challenge list to username
	$stmt = $conn->prepare("UPDATE userInfo SET challenges = ? WHERE userName = ?");
	if(!$stmt) die($conn->error);
	$stmt->bind_param("bs", $challenges, $username); # 'b' means blob, 's' means string
	$stmt->send_long_data(0, $challenges); # 0 means arg[0]. Have to send blobs this way as they may be super big
	$stmt->execute();

	$stmt->close();
	$conn->close();

	# create some extra data for the slider
	$newChallenge['ticks'] = range(1,$newChallenge['numTasks']);
	$newChallenge['ticks_labels'] = array_map('strval', range(1,$newChallenge['numTasks']));
	echo json_encode($newChallenge);

?>