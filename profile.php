<html>
			<?php $user = array('firstName'=>'Steph',
								'lastName'=>'Warsh',
								'userName'=>'swarsh');
				?>
	<head>
		<meta charset="utf-8">
		<title>Profile | Challenge Channel</title>
		<link rel="icon" href="img/checked.png">
		<link href="https://fonts.googleapis.com/css?family=Cabin:400,400i,700" rel="stylesheet">
		
		<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>
	<body id="profile">
		<?php include 'inc/nav.php'; ?>
		<div class="container main">

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
			<ul id="completed">
				<?php

					$challenges = unserialize($user['challenges']);

					if($challenges){
						foreach ($challenges as $title => $currentTask)
							if($currentTask == -1) # if challenge marked as completed
								echo"<li>{$title}</li>";
						unset($currentTask); # required after foreach loop
					}
				?>
			</ul>

			<h3>Start a New Challenge</h3>
			<p><a href="newChallenge.php" rel="Create Challenge"><img src="img/plus.png" rel="plus"> Create your own challenge</a></p>

			<h4> Add Existing Challenge: </h4>
			<form action="bindChallenge.php" method="post" class="bindChallenge">
				<label for="username">Enter Creator's Username and Challenge's Title</label>
				<div class="findChallenge">
					<input type="text" name="creator" placeholder="username" id="username" required>
					<input class="right" type="text" name="title" placeholder="title" required>
				</div>
				<div class="add-button">
					<input type="submit" value="Add Challenge" class="btn btn-default">
				</div>
			</form>

			<h3>Current Challenges</h3>
			<div id="challenges">
				<?php 

					require "getChallenge.php";

					if($challenges){
						foreach ($challenges as $title => $currentTask){
							if($currentTask != -1){ # unfinished challenge
								# get challenge info
								$challengeData = getChallenge($title, $conn);
								$tasks = unserialize($challengeData['tasks']);
								$currentTaskInfo = $tasks[$currentTask+1];
								$tasks = json_encode($tasks,JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP);
								$noSpaceTitle = preg_replace("/ /", "_", $title);
								echo"<div id='${noSpaceTitle}' class='challenge'> $title
										<p class='{$noSpaceTitle}'>Up Next: {$currentTaskInfo}</p>
										<div class='progressBar' data-currentTask='{$currentTask}' data-numTasks='{$challengeData['numTasks']}' data-tasks='{$tasks}'>
											<img src='img/road.jpg'/>
										</div>
										<form action='removeChallenge.php' method='post' class='removeChallenge'>
											<input type='submit' value='Remove' class='btn btn-default'>
										</form>
										<br>
									</div>";
							}
						}
						unset($currentTask); # required after foreach loop
					}
				?>
			</div>
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