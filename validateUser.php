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
		if($conn->connect_error) databaseError($conn->connect_error);

		# set up query and post it to database
		$stmt = $conn->prepare("SELECT password FROM userInfo WHERE userName = ?");
		if(!$stmt) databaseError ($conn->error);
		$stmt->bind_param("s", $username); #? replaced with $username
		$stmt->execute();

		# store result
		$stmt->bind_result($result);
		$stmt->fetch();

		# cleanup
		$stmt->close();
		$conn->close();

		# verify password
		if($result && password_verify($password, $result)){
			# set cookie to remember login for 1 month on entire domain
			date_default_timezone_set('UTC'); # prevents warnings about timezone
			setcookie("loggedIn", $username, strtotime("+1 month"), "/");
			
			return true;
		}

		return false;
	}

	function databaseError($error){
		$data['errors']['database'] = $error;
		echo json_encode($data);
		exit();
	}
?>