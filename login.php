<html>
	<head>
		<meta charset="utf-8">
		<title>Log In | Challenge Channel</title>
		<link rel="icon" href="img/checked.png">
		<link href="https://fonts.googleapis.com/css?family=Cabin:400,400i,700" rel="stylesheet">		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
		<script src="js/loginRequest.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>
	<body id="login">
		<div class="box">
			<h1>Challenge Channel</h1>
			<h2>Back at it</h2>

			<form action="validateUser.php"  method="post">
			  <label>Username:<br>
			  	<input type="text" name="username" required>
			  </label>
			  <br>
			  <label>Password:<br>
			  	<input type="password" name="password" required>
			  </label>
			  <br>
			  <br>
			  <input type="submit" value="Submit" class="btn btn-default">
			</form>
			<p class="error"></p>
		</div>
	</body>
</html>

<?php
	if($_COOKIE["loggedIn"]){
		#Redirect browser
		header("Location: profile.php"); 
		exit();
	}
?>