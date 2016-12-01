<?php

	# getting info to connect to the database
		require'loginInfo.php';

		# new connection using login stored in "loginInfo.php"
		$conn = new mysqli($hostAddress, $uname, $pword, $database);
		if($conn->connect_error) die($conn->connect_error);

		# get user info based on username
		$user = 'wwallisabc';
		//getUser($_COOKIE["loggedIn"], $conn);

		if(isset($_POST['fname'])){
			//first name
			# new connection using login stored in "loginInfo.php"
			$conn = new mysqli($hostAddress, $uname, $pword, $database);
			if($conn->connect_error) die($conn->connect_error);
			$fname = $_POST['fname'];

			$query = "UPDATE userInfo SET firstName='$fname' WHERE userName='wwallisabc';";
			$result = $conn->query($query);
			if(!$result){
			      die($conn->error);
			}

		} else if (isset($_POST['lname'])) {
			//last name
			$fname = $_POST['lname'];
			$conn = new mysqli($hostAddress, $uname, $pword, $database);
			if($conn->connect_error) die($conn->connect_error);
			
			
			$query = "UPDATE userInfo SET lastName='$lname' WHERE userName='wwallisabc';";
			$result = $conn->query($query);
			if(!$result){
			      die($conn->error);
			}

		} else if (isset($_POST['age'])){
			//age
			$conn = new mysqli($hostAddress, $uname, $pword, $database);
			if($conn->connect_error) die($conn->connect_error);
			$age = $_POST['age'];
			
			$query = "UPDATE userInfo SET age='$age' WHERE userName='wwallisabc';";
			$result = $conn->query($query);
			if(!$result){
			      die($conn->error);
			}

		} else if (isset($_POST['password'])){
			//password
			$conn = new mysqli($hostAddress, $uname, $pword, $database);
			if($conn->connect_error) die($conn->connect_error);
			$password = $_POST['password'];
			
			$query = "UPDATE userInfo SET password='$password' WHERE userName='wwallisabc';";
			$result = $conn->query($query);
			if(!$result){
			      die($conn->error);
			}
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
