<html>
<head>
	<meta charset="utf-8">
	<title>Add Challenge | Challenge Channel</title>
	<link rel="icon" href="img/checked.png">
	<link href="https://fonts.googleapis.com/css?family=Cabin:400,400i,700" rel="stylesheet">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<script src="js/createChallengeRequest.js"></script>
	<script src="js/generateTasks.js"></script>
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body id="new-challenge">

	<?php include 'inc/nav.php' ?>
	
	<div class="container main">
		
		<h1>Create a New Challenge</h1>
		<p>Customize your challenge with as many steps as you like for whatever goal you want to reach.</p>

		<form id="challengeForm" action="createChallenge.php" method="post">
			<label>Title: <br>
				<input type="text" name="title" required><br>
			</label>
			<label>Summary <br>
				<input type="text" name="summary"><br>
			</label>
			<label>Number of tasks: <br>
				<input type="number" name="numTasks" min="1" required><br>
			</label>
			<label class='task'> <br>
				<input type='submit' value='Create Challenge' class="btn btn-default">
			</label>
		</form>

		<p class='error'></p>
		<p id='message'></p>
		
	</div><!-- .container -->
</body><!-- #new-challenge -->
<html>