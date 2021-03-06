<?php
	require_once 'loginInfo.php'; # getting info to connect to the database

	$data['success'] = false;
  	# new connection
	$conn = new mysqli($hostAddress, $uname, $pword, $database); 
	if($conn->connect_error) databaseError($conn->connect_error);

	$username = $_COOKIE['loggedIn'];
	$summary = $_POST['summary'];
	$numTasks = $_POST['numTasks'];
	$title = $username.":".$_POST['title'];

	# get all tasks and serialize for storage
	$tasks = serialize($_POST['task']);

	# set up query and post it to database
	$stmt = $conn->prepare("INSERT INTO challenges VALUES(?,?,?,?)");
	if(!$stmt) databaseError($conn->error);

	$stmt->bind_param("ssbi", $title, $summary, $tasks, $numTasks); # 's' means string, 'b' is blob, 'i' is integer
	$stmt->send_long_data(2, $tasks); # 2 means arg[2]. Have to send blobs this way as they may be super big
	$stmt->execute();

	$stmt->close();
	$conn->close();

	$data['username'] = $username;
	$data['title'] = $_POST['title'];
	$data['success'] = true;

	echo json_encode($data);

	function databaseError($error){
		$data['error'] = $error;
		echo json_encode($data);
		exit();
	}

?>