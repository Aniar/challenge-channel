<html>
	<head>
		<meta charset="utf-8">
		<title>Log In | Challenge Channel</title>
		<link rel="icon" href="img/checked.png">
		<link href="https://fonts.googleapis.com/css?family=Cabin:400,400i,700" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>
	<body id="login">
		<div class="box">
			<h1>You have been logged out!</h1>
			<a href="login.php">Click here to log in again</a>
		</div>
	</body>
</html>

<?php
setcookie("loggedIn", "", time()-3600, "/");
?>