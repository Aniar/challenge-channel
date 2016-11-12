<html>
	<head>
		<meta charset="utf-8">
		<title>Profile | Challenge Channel</title>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<script >function logOut(){window.location = "../logout.php";}</script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
		<script src="js/progressbar.js"></script>

	</head>
	<body>
		<div class="container">

		<?php include 'inc/nav.php';?>

		<h1>Challenge Channel</h1>
		<h2>User Profile</h2> <!-- we can use SQL to put the user's name here -->

		<div class="user-info">
			<!-- fill with list of user info and social network friends -->
			<ul>
				<li>firstname lastname</li>
				<li>username</li>
				<li># of friends</li>
			</ul>

		</div><!-- .user-info -->

		<div class="profile-picture">
			<!-- user's profile picture -->
			<img src="img/user.png">

		</div><!-- .profile-picture -->

		<div class="completed">
			<!-- user's completed/past challenges in a list -->
			<ul>
				<li>done</li>
				<li>done</li>
				<li>done</li>
			</ul>

		</div><!-- .completed -->

		<div class="current">

		</div><!-- .current -->
	</div><!-- .container -->

		<input type="checkbox" id="complete" onClick="finishBar()"><label for="complete"> Task Complete?</label>
			<section id="progressbar">
				<progress class="progress" value="20" max="100"></progress><span>Progress</span>
			</section>
	<input id="logOut" type="button" value="Log Out" onclick="logOut();" />

	</body>
</html>