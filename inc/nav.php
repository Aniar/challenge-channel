<nav class="navbar">
	<p class="navbar-brand"><a href="#">Challenge Channel</a></p>
	<form class="navbar-form navbar-left">
		<div class="form-group">
			Search: <input type="text" name="searchbar">
			<input type="submit" class="btn btn-default">
		</div>
	</form>
	<div class="navbar-right">
		<p class="navbar-text">Signed in as
			<a href="#" class="navbar-link"><?php echo "{$user['userName']}"?></a>
		</p>
		<a href="logout.php"><button type="button" class="btn btn-default navbar-btn">Log Out</button></a>
	</div>
</nav>