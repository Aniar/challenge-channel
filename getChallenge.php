<?php
	function getChallenge($name, $conn){
		# set up query and post it to database
		$stmt = $conn->prepare("SELECT * FROM challenges WHERE title = ?");
		if(!$stmt) die ($conn->error);
		$stmt->bind_param("s", $name); #? replaced with $name
		$stmt->execute();

		# store result
		$stmt->bind_result(
			$result['title'],
			$result['summary'],
			$result['tasks'],
			$result['numTasks']);
		$stmt->fetch();
		$stmt->close();

		return $result;
	}
?>