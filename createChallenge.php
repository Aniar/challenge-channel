<?php
	require_once 'loginInfo.php'; #getting info to connect to the database

  	#new connection
	$conn = new mysqli($hostAddress, $uname, $pword, $database); 
	if($conn->connect_error){
		echo json_encode(false);
		die();
	}

	#non task stuff
	$summary = $_POST['summary'];
	$numTasks = $_POST['numTasks'];
	if($_COOKIE['loggedIn'])
		$title = $_COOKIE['loggedIn'].":".$_POST['title'];
	else{ //Must be logged in to create challenge
		echo json_encode(false);
		die();
	}

	#get all tasks
	$tasks = $_POST['task'];

	# set up query and post it to database
	$stmt = $conn->prepare("INSERT INTO challenges VALUES(?,?,?,?)");
	if(!$stmt){
		echo json_encode(false);
		die();
	}
	$stmt->bind_param("ssbi", $title, $summary, $tasks, $numTasks); # 's' means string, 'b' is blob, 'i' is integer
	$stmt->send_long_data(2, serialize($tasks)); #have to send blobs this way as they may be super big
	$stmt->execute();

	$stmt->close();
	$conn->close();

	echo json_encode(true);

?>