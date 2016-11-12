<html>
<head>
	<meta charset="utf-8">
	<title>Sign Up | Challenge Channel</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body id="signup">
	<div class="box">
		<h1>Challenge Channel</h1>
		<h2 class="center">Get started</h2>

		<!-- html form --> 
		<p id='message'> </p>
		<form action="#" method="post" <pre>
			first name <input type="text" class="valid" name="firstName" required><br>
			last name <input type="text" class="valid" name="lastName" required><br>
			username <input type="text" class="valid" name="userName" required><br>
			email <input type="email" class="valid" name="email" required><br>
			password <input type="password" class="valid" name="password" required><br>
			age <input type="number" class="valid" name="age" min="1" max="150" required><br>
			<input type="submit" value="ADD RECORD">
			</pre>
		</form>
	</div>
</body>
</html>

<?php

	#main
	if(!empty($_POST['firstName']) &&
		!empty($_POST['lastName']) &&
		!empty($_POST['userName']) &&
		!empty($_POST['email']) &&
		!empty($_POST['password']) &&
		!empty($_POST['age']))
	{
		addUser();
	}

	function addUser(){
		#getting info to connect to the database
		require'loginInfo.php';

		#new connection using login stored in "loginInfo.php"
		$conn = new mysqli($hostAddress, $uname, $pword, $database);
		if($conn->connect_error) die($conn->connect_error);

		$firstName = get_post($conn, 'firstName');
		$lastName = get_post($conn, 'lastName');
		$userName = get_post($conn, 'userName');
		$email = get_post($conn, 'email');
		$password = password_hash(get_post($conn, 'password'), PASSWORD_DEFAULT);
		$age = get_post($conn, 'age');
		

		$test = &$conn;
		if(isConflict($test, 'userName', $userName) || isConflict($test, 'email', $email)){
			$conn->close();
			return;
		}

		#insert into database

		#set up query and post it to database
		$stmt = $conn->prepare("INSERT INTO userInfo VALUES(?,?,?,?,?,?)");
		$stmt->bind_param("ssssss", $firstName, $lastName, $userName, $email, $password, $age);
		$stmt->execute();
		if(!$stmt) die ($conn->error);

		$stmt->close();
		$conn->close();

		echo <<<_END
		<script>
		function msg() {
			document.getElementById("message").innerHTML = "Nice, you have an account now!";
		}
		window.onload = msg;
		</script>
_END;
#^no characters before or after this token
	}

	function get_post($database, $var){
		return $database->real_escape_string($_POST[$var]);
	}

	# Check for database conflicts
	function isConflict($database, $fieldName, $fieldValue){

		#set up query and post it to database
		$stmt = $database->prepare("SELECT * FROM userInfo WHERE ".$fieldName." = ?");
		$stmt->bind_param("s", $fieldValue);
		$stmt->execute();
		if(!$stmt) die ($database->error);

		#store result
		$result = $stmt->get_result();
		$stmt->fetch();

		$stmt->close();

		#{fieldName} already taken 
		if($result->num_rows > 0){
			echo <<<_END
			<script>
			function msg() {
				document.getElementById("message").innerHTML = "Sorry that {$fieldName} is taken";
			}
			window.onload = msg;
			</script>
_END;
#^no characters before or after this token
			return true;
		}
		return false;
	}

?>