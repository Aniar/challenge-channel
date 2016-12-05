<html>
	<head>
		<meta charset="utf-8">
		<title>Profile | Challenge Channel</title>
		<link rel="icon" href="img/checked.png">
		<link href="https://fonts.googleapis.com/css?family=Cabin:400,400i,700" rel="stylesheet">
		
		<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>
	<body id="profile">
		<?php include 'inc/nav.php'; ?>
		<div class="container main">

			<?php

				# getting info to connect to the database
				require'loginInfo.php';

				# new connection using login stored in "loginInfo.php"
				$conn = new mysqli($hostAddress, $uname, $pword, $database);
				if($conn->connect_error) die($conn->connect_error);

				# get user info based on username
				$user = getUser($_COOKIE['loggedIn'], $conn);
			?>

			<h1>Challenge Channel</h1>
			<aside>
			<h2><?php echo "{$user['firstName']}"?>'s Profile</h2>
		
			<div class="user-info">
				<p><a href="settings.php" rel="Edit Profile"><img src="img/settings.png" rel="Edit Profile"> Edit Profile</a></p>
				<p><?php echo "{$user['firstName']} {$user['lastName']}"?></p>
				<p><?php echo "{$user['userName']}"?></p>
				

			</div><!-- .user-info -->
		</aside><!--
		--><article>
			<h3>Completed Challenges</h3>
			<!-- user's completed/past challenges in a list -->
			<ul>
				<li><a href="#">10 day minimalism challenge</a></li>
				<li><a href="#">7 day squat challenge</a></li>
				<li><a href="#">5 day smartphone detox</a></li>
			</ul>

			<h3>Start a New Challenge</h3>
			<p><a href="newChallenge.php" rel="Create Challenge"><img src="img/plus.png" rel="plus"> Create your own challenge</a></p>
			<form action="bindChallenge.php" method="post" class="bindChallenge">
				<label>Enter Challenge Identifier: (format is creator:title)<br>
					<input type="text" name="title" required><br>
				</label>
				<input type="submit" value="Add Challenge" class="btn btn-default">
			</form>

			<h3>Current Challenges</h3>
		
		<div id="challenges">
		</div>
<?php 

	require "getChallenge.php";

	$challenges = unserialize($user['challenges']);
	if($challenges){
		foreach ($challenges as $title => $currentTask){
			# get challenge info
			$challengeData = getChallenge($title, $conn);
			$currentTaskInfo = unserialize($challengeData['tasks'])[$currentTask+1];
			$noSpaceTitle = preg_replace("/ /", "_", $title);
			echo"<label class='challenge'> $title
					<div id='{$noSpaceTitle}' data-currentTask='{$currentTask}' data-numTasks='{$challengeData['numTasks']}'>
						<p class='{$noSpaceTitle}'>Up Next: {$currentTaskInfo}</p>
						<img src='img/road.jpg'/>
					</div>
					<br>
				</label>";
		}
		unset($currentTask); # required after foreach loop
	}
?>
		</article>
	</div><!-- .container .main -->
	</body>
	<script src="js/insertChallenge.js"></script>
</html>

<?php 

	function getUser($username, $conn){
		# set up query and post it to database
		$stmt = $conn->prepare("SELECT * FROM userInfo WHERE userName = ?");
		if(!$stmt) die ($conn->error);
		$stmt->bind_param("s", $username); #? replaced with $username
		$stmt->execute();

		# store result
		$stmt->bind_result(
			$result['firstName'],
			$result['lastName'],
			$result['userName'],
			$result['email'],
			$result['password'],
			$result['age'],
			$result['challenges']);
		$stmt->fetch();
		$stmt->close();

		return $result;
	}
?>