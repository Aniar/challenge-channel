<html>
<head>
	<meta charset="utf-8">
	<title>Settings | Challenge Channel</title>
	<link rel="icon" href="img/checked.png">
	<link href="https://fonts.googleapis.com/css?family=Cabin:400,400i,700" rel="stylesheet">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<script src="js/changeInfoRequest.js"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body id="settings">

	<?php include 'inc/nav.php' ?>

	<div class="container main">

		<h1>Edit Profile</h1>
		<p>Need to edit your profile information? Enter the new information into a field below and click "Submit" after each one to save.</p>

	<form action="changeInfo.php" method="post" class="changeInfo">
		<label>First Name <br>
			<input type="text" name="firstName">
		</label>
		<input type="submit" value="Submit" class="btn btn-default">
	</form>
	<hr>
	<form action="changeInfo.php" method="post" class="changeInfo">
		<label>Last Name <br>
			<input type="text" name="lastName">
		</label>
		<input type="submit" value="Submit" class="btn btn-default">
	</form>
	<hr>
	<form action="changeInfo.php" method="post" class="changeInfo">
		<label>Age <br>
			<input type="number" name="age" min="1" max="150">
		</label>
		<input type="submit" value="Submit" class="btn btn-default">
	</form>
	<hr>
	<form action="changeInfo.php" method="post" class="changeInfo">
		<label>Email <br>
			<input type="email" name="email">
		</label>
		<input type="submit" value="Submit" class="btn btn-default">
	</form>
	<hr>
	<form action="changeInfo.php" method="post" class="changeInfo">
		<label>Password <br>
			<input type="password" name="password">
		</label>
		<input type="submit" value="Submit" class="btn btn-default">
	</form>

	<form action="deleteUser.php" method="post">
		<input type="submit" value="Delete Account" class="btn btn-default">
	</form>

	<p id="message"></p>
	<p class="error"></p>
	</div> <!-- .container .main -->
</body>
</html>