<?php

	# code to retrieve challenge from database
	require 'getChallenge.php';
	# getting info to connect to the database
	require'loginInfo.php';

	# new connection using login stored in "loginInfo.php"
	$conn = new mysqli($hostAddress, $uname, $pword, $database);
	if($conn->connect_error) die($conn->connect_error);

	$newChallenge = getChallenge($_POST["title"], $conn);

	$stmt = $conn->prepare("SELECT challenges FROM userInfo WHERE userName = ?");
	if(!$stmt) die($conn->error);
	$stmt->bind_param("ssbi", $title, $summary, $tasks, $numTasks); # 's' means string, 'b' is blob, 'i' is integer
	$stmt->execute();

	# store result
	$challenges = $stmt->get_result();
	$stmt->fetch();

	$challenges->fetch_assoc(); //Need to do this?
	$challenges = unserialize($challenges);
	$challenges[next] = [1, $newChallenge['title']];
	$challenges = serialize($challenges);


	$stmt = $conn->prepare("INSERT INTO userInfo(challenges) VALUES(?) WHERE userName = ?");
	if(!$stmt) die($conn->error);
	$stmt->bind_param("bs", $challenges, $_COOKIE['loggedIn']); # 'b' means blob
	$stmt->send_long_data(2, serialize($challenges)); #have to send blobs this way as they may be super big
	$stmt->execute();

	$stmt->close();

	echo json_encode($challenge);

	$conn->close;

?>