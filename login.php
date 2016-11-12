<html>
	<head>
		<meta charset="utf-8">
		<title>Log In | Challenge Channel</title>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>
	<body id="login">
		<div class="box">
			<h1>Challenge Channel</h1>
			<h2>Back at it</h2>

			<p id='message'> </p>
			<form action="#"  method="post">
			  Username:<br>
			  <input type="text" name="username" required>
			  <br>
			  Password:<br>
			  <input type="password" name="password" required>
			  <br><br>
			  <input type="submit" value="Submit">
			</form>

			
		</div>
	</body>
</html>

<?php

	#main
	if($_COOKIE["loggedIn"]){
		#Redirect browser
		header("Location: profile.php"); 
		exit();
	}
	elseif(!empty($_POST['username']) && !empty($_POST['password'])){
		if(authenticate($_POST['username'], $_POST['password'])){
			#Redirect browser
			header("Location: profile.php"); 
			exit();
		}
		else{
			echo <<<_END
			<script>
			function msg() {
				document.getElementById("message").innerHTML = "Your username or password is incorrect!";
			}
			window.onload = msg;
			</script>
_END;
#^no characters before or after this token
		}
	}

	function authenticate($username, $password){

	 	#getting info to connect to the database
		require'loginInfo.php';

		#new connection using login stored in "loginInfo.php"
		$conn = new mysqli($hostAddress, $uname, $pword, $database);
		if($conn->connect_error) die($conn->connect_error);

		#set up query and post it to database
		$stmt = $conn->prepare("SELECT * FROM userInfo WHERE userName = ?");
		$stmt->bind_param("s", $username); #? replaced with $username
		$stmt->execute();
		if(!$stmt) die ($conn->error);

		#store result
		$result = $stmt->get_result();
		$stmt->fetch();

		#user not found or multiple identical usernames
		if($result->num_rows != 1) return false;

		$verified = false;

		#verify password
		if(password_verify($password, $result->fetch_assoc()['password'])){
			#set cookie to remember login for 1 month on entire domain
			setcookie("loggedIn", $username, strtotime("+1 month"), "/");
			
			$verified = true;
		}

		#cleanup
		$stmt->close();
		$conn->close();

		return $verified;
	}
?>