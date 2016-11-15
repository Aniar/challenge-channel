<?php

	# main
	if(!empty($_POST['username']) && !empty($_POST['password'])){
		if(!authenticate($_POST['username'], $_POST['password']))
			$data['errors']['loginError'] = "Username or password is incorrect!";
		else
			$data['success'] = true;
		echo json_encode($data);
	}

	function authenticate($username, $password){

	 	# getting info to connect to the database
		require'loginInfo.php';

		# new connection using login stored in "loginInfo.php"
		$conn = new mysqli($hostAddress, $uname, $pword, $database);
		if($conn->connect_error) die($conn->connect_error);

		# set up query and post it to database
		$stmt = $conn->prepare("SELECT * FROM userInfo WHERE userName = ?");
		$stmt->bind_param("s", $username); #? replaced with $username
		$stmt->execute();
		if(!$stmt) die ($conn->error);

		# store result
		$result = $stmt->get_result();
		$stmt->fetch();

		# user not found or multiple identical usernames
		if($result->num_rows != 1) return false;

		$verified = false;

		# verify password
		if(password_verify($password, $result->fetch_assoc()['password'])){
			# set cookie to remember login for 1 month on entire domain
			date_default_timezone_set('UTC'); # prevents warnings about timezone
			setcookie("loggedIn", $username, strtotime("+1 month"), "/");
			
			$verified = true;
		}

		# cleanup
		$stmt->close();
		$conn->close();

		return $verified;
	}
?>