<?php
	require_once 'loginInfo.php'; # getting info to connect to the database

  	# new connection
	$conn = new mysqli($hostAddress, $uname, $pword, $database); 
	if($conn->connect_error){
		echo json_encode(false);
		die();
	}

	# non task stuff
	$summary = $_POST['summary'];
	$numTasks = $_POST['numTasks'];
	$title = $_COOKIE['loggedIn'].":".$_POST['title'];

	# get all tasks and serialize for storage
	$tasks = serialize($_POST['task']);

	# set up query and post it to database
	$stmt = $conn->prepare("INSERT INTO challenges VALUES(?,?,?,?)");
	if(!$stmt){
		echo json_encode(false);
		die();
	}
	$stmt->bind_param("ssbi", $title, $summary, $tasks, $numTasks); # 's' means string, 'b' is blob, 'i' is integer
	$stmt->send_long_data(2, $tasks); # 2 means arg[2]. Have to send blobs this way as they may be super big
	$stmt->execute();

	$stmt->close();
	$conn->close();

	echo json_encode(true);

?>