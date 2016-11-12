<html>
	<head>
		<meta charset="utf-8">
		<title>Log In | Challenge Channel</title>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
		<script src="js/loginRequest.js"></script>
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
			  <input type="submit" value="Submit">
			</form>
			<p class='error'></p>
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