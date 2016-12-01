<?php
	function getChallenge($name, $conn){
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