<?php

	# getting info to connect to the database
		require'loginInfo.php';

		# new connection using login stored in "loginInfo.php"
		$conn = new mysqli($hostAddress, $uname, $pword, $database);
		if($conn->connect_error) die($conn->connect_error);

		# get user info based on username
		$user = getUser($_COOKIE["loggedIn"], $conn);

		


		#Delete account
		$query = "DELETE FROM userInfo WHERE userName='$user'";
		$result = $conn->query($query);
		if(!$result){
		      die($conn->error);
		}

		

		function getUser($username, $conn){
		# set up query and post it to database
		$stmt = $conn->prepare("SELECT * FROM userInfo WHERE userName = ?");
		$stmt->bind_param("s", $username); #? replaced with $username
		$stmt->execute();
		if(!$stmt) die ($conn->error);

		# store result
		$result = $stmt->get_result();
		$stmt->fetch();

		$stmt->close();

		return $result->fetch_assoc();
		}



?>
