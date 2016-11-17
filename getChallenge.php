<?php

	// getChallenge($_POST["title"]);
	echo json_encode(getChallenge('Test'));

	function getChallenge($name){
	 	# getting info to connect to the database
		require'loginInfo.php';

		# new connection using login stored in "loginInfo.php"
		$conn = new mysqli($hostAddress, $uname, $pword, $database);
		if($conn->connect_error) die($conn->connect_error);

		# set up query and post it to database
		$stmt = $conn->prepare("SELECT * FROM challenges WHERE title = ?");
		$stmt->bind_param("s", $name); #? replaced with $name
		$stmt->execute();
		if(!$stmt) die ($conn->error);

		# store result
		$result = $stmt->get_result();
		$stmt->fetch();

		return $result->fetch_assoc();
	}

?>