<?php 	
	# Redirect to login page if not logged in
	if(!$_COOKIE['loggedIn']){
		# Redirect browser
		header('Location: unauthorized.html'); 
		exit();
	}
?>
<nav class="navbar">
	<p class="navbar-brand"><a href="profile.php">Challenge Channel</a></p>
	<div class="navbar-right">
		<p class="navbar-text">Signed in as
			<a href="profile.php" class="navbar-link"><?php echo "{$_COOKIE['loggedIn']}"?></a>
		</p>
		<a href="logout.php"><button type="button" class="btn btn-default navbar-btn">Log Out</button></a>
	</div>
</nav>