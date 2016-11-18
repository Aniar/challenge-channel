<html>
	<head>
		<meta charset="utf-8">
		<title>Profile | Challenge Channel</title>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
		<script src="js/progressbar.js"></script>

	</head>
	<body>
		<div class="container">

		<nav class="navbar">
		<p class="navbar-brand"><a href="#">Challenge Channel</a></p>
		<form class="navbar-form navbar-left">
			<div class="form-group">
				Search: <input type="text" name="searchbar">
				<input type="submit" class="btn btn-default">
			</div>
		</form>
		<div class="navbar-right">
			<p class="navbar-text">Signed in as <a href="#" class="navbar-link">Steph Warsh</a> </p>
			<a href="logout.php"><button type="button" class="btn btn-default navbar-btn">Log Out</button></a>
		</div>
	</nav>

		<?php 

		echo <<< _END
		<h1>Challenge Channel</h1>
		<h2>User Profile</h2> <!-- we can use SQL to put the user's name here -->

		<div class="user-info">
			<!-- fill with list of user info and social network friends -->
			<ul>
				<li>firstname lastname</li>
				<li>{$_COOKIE["loggedIn"]}</li>
				<li># of friends</li>
			</ul>

		</div><!-- .user-info -->
_END
		?>

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

		<input id="exbar" type="text"
          data-provide="slider"
          data-slider-ticks="[1, 2, 3, 4, 5, 6, 7, 8, 9, 10]"
          data-slider-ticks-labels='["1", "2", "3", "4", "5", "6", "7", "8", "9", "10"]'
          data-slider-min="1"
          data-slider-max="10"
          data-slider-step="1"
          data-slider-value="1"
          data-slider-tooltip="hide" />
	</body>
</html>