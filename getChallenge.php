<?php

	echo json_encode(getChallenge($_POST["title"]));

	function getChallenge($name){
	 	# getting info to connect to the database
		require'loginInfo.php';

		# new connection using login stored in "loginInfo.php"
		$conn = new mysqli($hostAddress, $uname, $pword, $database);
		if($conn->connect_error) die($conn->connect_error);

		# set up query and post it to database
		$stmt = $conn->prepare("SELECT * FROM challenges WHERE title = ?");
		if(!$stmt) die ($conn->error);
		$stmt->bind_param("s", $name); #? replaced with $name
		$stmt->execute();

		# store result
		$result = $stmt->get_result();
		$stmt->fetch();

		return $result->fetch_assoc();
	}

?>