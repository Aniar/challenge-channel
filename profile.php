<html>
	<head>
		<meta charset="utf-8">
		<title>Profile | Challenge Channel</title>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
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
	</body>
</html>