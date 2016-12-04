<?php
	# getting info to connect to the database
	require'loginInfo.php';

	//TODO error handling for not logged in
	$username = $_COOKIE['loggedIn'];

	# new connection using login stored in "loginInfo.php"
	$conn = new mysqli($hostAddress, $uname, $pword, $database);
	if($conn->connect_error) die($conn->connect_error);

	# get bound challenges
	$stmt = $conn->prepare("SELECT challenges FROM userInfo WHERE userName = ?");
	if(!$stmt) die($conn->error);
	$stmt->bind_param("s", $username); # 's' means string
	$stmt->execute();

	# store result
	$result = $stmt->get_result();
	$stmt->fetch();

	$challenges = unserialize($result->fetch_assoc()['challenges']); # get array object
	//TODO if challenges null error
	$challenges[$_POST['title']] = $_POST['newValue']; # update currentTask
	$challenges = serialize($challenges); # serialize for storage

	# bind challenge list to username
	$stmt = $conn->prepare("UPDATE userInfo SET challenges = ? WHERE userName = ?");
	if(!$stmt) die($conn->error);
	$stmt->bind_param("bs", $challenges, $username); # 'b' means blob, 's' means string
	$stmt->send_long_data(0, $challenges); # 0 means arg[0]. Have to send blobs this way as they may be super big
	$stmt->execute();

	$stmt->close();
	$conn->close();

	echo json_encode(true);
?>