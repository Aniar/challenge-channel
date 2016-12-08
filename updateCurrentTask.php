<?php
	# getting info to connect to the database
	require'loginInfo.php';

	$username = $_COOKIE['loggedIn'];
	$title = $_POST['title'];
	$newValue = $_POST['newValue'];

	# new connection using login stored in "loginInfo.php"
	$conn = new mysqli($hostAddress, $uname, $pword, $database);
	if($conn->connect_error) databaseError($conn->connect_error);

	# get bound challenges
	$stmt = $conn->prepare("SELECT challenges FROM userInfo WHERE userName = ?");
	if(!$stmt) databaseError($conn->error);
	$stmt->bind_param("s", $username); # 's' means string
	$stmt->execute();

	# store result
	$stmt->bind_result($result);
	$stmt->fetch();
	$stmt->close();

	if(!$result) databaseError("Invalid user or challenge");

	# get next task info
	$stmt = $conn->prepare("SELECT tasks FROM challenges WHERE title = ?");
	if(!$stmt) databaseError($conn->error);
	$stmt->bind_param("s", $title); # 's' means string
	$stmt->execute();

	# store result
	$stmt->bind_result($tasks);
	$stmt->fetch();
	$stmt->close();

	$data['nextTask'] = unserialize($tasks)[$newValue+1];
	$challenges = unserialize($result); # get array object
	if($data['nextTask'])
		$challenges[$title] = (int)$newValue; # update currentTask
	else
		$challenges[$title] = -1;
	$challenges = serialize($challenges); # serialize for storage

	# bind challenge list to username
	$stmt = $conn->prepare("UPDATE userInfo SET challenges = ? WHERE userName = ?");
	if(!$stmt) databaseError($conn->error);
	$stmt->bind_param("bs", $challenges, $username); # 'b' means blob, 's' means string
	$stmt->send_long_data(0, $challenges); # 0 means arg[0]. Have to send blobs this way as they may be super big
	$stmt->execute();
	$stmt->close();

	$conn->close();

	echo json_encode($data);

	function databaseError($error){
		$data['error'] = $error;
		echo json_encode($data);
		exit();
	}
?>