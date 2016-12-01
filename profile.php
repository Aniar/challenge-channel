<html>
	<?php
		# Redirect to login page if not logged in
		if(!$_COOKIE["loggedIn"]){
			# Redirect browser
			header("Location: login.php"); 
			exit();
		}

		# getting info to connect to the database
		require'loginInfo.php';

		# new connection using login stored in "loginInfo.php"
		$conn = new mysqli($hostAddress, $uname, $pword, $database);
		if($conn->connect_error) die($conn->connect_error);

		# get user info based on username
		$user = getUser($_COOKIE["loggedIn"], $conn);

		$conn->close(); #close here for now


	?>
	<head>
		<meta charset="utf-8">
		<title>Profile | Challenge Channel</title>
		<link rel="icon" href="img/checked.png">
		<link href="https://fonts.googleapis.com/css?family=Cabin:400,400i,700" rel="stylesheet">
		
		<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
		<script src="js/progressbar.js"></script>
		<script src="js/insertChallenge.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.4.1/css/bootstrap-slider.min.css" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.4.1/bootstrap-slider.min.js"></script>
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/progressBarStyles.css">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>
	<body>
		<div class="container main">

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

			<h1>Challenge Channel</h1>
			<aside>
			<h2><?php echo "{$user['firstName']}"?>'s Profile</h2>
		
			<div class="user-info">
				<!-- fill with list of user info and social network friends -->
				<?php echo "{$user['firstName']} {$user['lastName']}"?><br/>
				<?php echo "{$user['userName']}"?><br/>
				<!--# of friends<br /> -->
				

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
			<form action="getChallenge.php" action="post" class="getChallenge">
				<label>Enter Challenge Identifier: (format is creator:title)<br>
					<input type="text" name="title" required><br>
				</label>
				<input type="submit" value="Add Challenge" class="btn btn-default">
			</form>

			<h3>Current Challenges</h3>
		
		<div id="challenges">
			
			<!-- nicer looking progress bar -->
			<div class="barImage"><img src="http://placekitten.com/400/400"/></div>
			
			<input id="exbar" type="text"
	          data-provide="slider"
	          data-slider-ticks="[1, 2, 3, 4, 5, 6, 7, 8, 9, 10]"
	          data-slider-ticks-labels='["1", "2", "3", "4", "5", "6", "7", "8", "9", "10"]'
	          data-slider-min="1"
	          data-slider-max="10"
	          data-slider-step="1"
	          data-slider-value="1"
	          data-slider-tooltip="hide" />
	    </div>
	    <script src="js/tileprogressbar.js"></script>
	     <script type="text/javascript">
	    	$('.goalOne').css('display', 'none');
			$('.goalTwo').css('display', 'none');
			$('.goalThree').css('display', 'none');
			$('.goalFour').css('display', 'none');
			$('.goalFive').css('display', 'none');
			$('.goalSix').css('display', 'none');
			$('.goalSeven').css('display', 'none');
			$('.goalEight').css('display', 'none');
			$('.goalNine').css('display', 'none');
			$('.goalTen').css('display', 'none');
	window.onload = function(){
		var temp;
		setInterval(function(){
			//checking every .25 seconds for the value and updating what part of the challege is
			//showing
			temp = $('#exbar').val().toString()
			$('.goalOne').css('display', 'none');
			$('.goalTwo').css('display', 'none');
			$('.goalThree').css('display', 'none');
			$('.goalFour').css('display', 'none');
			$('.goalFive').css('display', 'none');
			$('.goalSix').css('display', 'none');
			$('.goalSeven').css('display', 'none');
			$('.goalEight').css('display', 'none');
			$('.goalNine').css('display', 'none');
			$('.goalTen').css('display', 'none');

			switch(temp) {
			    case '1':
			       	console.log("1");
			       	
			       	$('.goalOne').css('display', 'inline');
			        break;
			    case '2':
			        $('.goalTwo').css('display', 'inline');
			        break;
			    case '3':
			        $('.goalThree').css('display', 'inline');
			        break;
			    case '4':
			        $('.goalFour').css('display', 'inline');
			        break;
			    case '5':
			        $('.goalFive').css('display', 'inline');
			        break;
			    case '6':
			        $('.goalSix').css('display', 'inline');
			        break;
			    case '7':
			        $('.goalSeven').css('display', 'inline');
			        break;
			    case '8':
			        $('.goalEight').css('display', 'inline');
			        break;
			    case '9':
			        $('.goalNine').css('display', 'inline');
			        break;
			    case '10':
			        $('.goalTen').css('display', 'inline');
			        break;
			    default:
			         console.log("1!");
				} 			

		}, 250);
		
	}
	
		

	</script>
<?php 

	require_once('loginInfo.php');

	$conn = new mysqli($hostAddress, $uname, $pword, $database); 
  	if($conn->connect_error) die($conn->connect_error);

  	$query = "SELECT * FROM challengeswwallisabc";
    $result = $conn->query($query);
    if(!$result){
      die($conn->error);
    }

   

    $rows = $result->num_rows;

    $result->data_seek($i);
    $goalOne = $result->fetch_assoc()["goalOne"];

    $result->data_seek($i);
    $goalTwo = $result->fetch_assoc()["goalTwo"];

    $result->data_seek($i);
    $goalThree = $result->fetch_assoc()["goalThree"];

    $result->data_seek($i);
    $goalFour = $result->fetch_assoc()["goalFour"];

    $result->data_seek($i);
    $goalFive = $result->fetch_assoc()["goalFive"];

    $result->data_seek($i);
    $goalSix = $result->fetch_assoc()["goalSix"];

    $result->data_seek($i);
    $goalSeven = $result->fetch_assoc()["goalSeven"];

    $result->data_seek($i);
    $goalEight = $result->fetch_assoc()["goalEight"];

    $result->data_seek($i);
    $goalNine = $result->fetch_assoc()["goalNine"];

    $result->data_seek($i);
    $goalTen = $result->fetch_assoc()["goalTen"];

    echo "<div class='goalOne'><p>".$goalOne."</p></div>";
    echo "<div class='goalTwo'><p>".$goalTwo."</p></div>";
    echo "<div class='goalThree'><p>".$goalThree."</p></div>";
    echo "<div class='goalFour'><p>".$goalFour."</p></div>";
    echo "<div class='goalFive'><p>".$goalFive."</p></div>";
    echo "<div class='goalSix'><p>".$goalSix."</p></div>";
    echo "<div class='goalSeven'><p>".$goalSeven."</p></div>";
    echo "<div class='goalEight'><p>".$goalEight."</p></div>";
    echo "<div class='goalNine'><p>".$goalNine."</p></div>";
    echo "<div class='goalTen'><p>".$goalTen."</p></div>";


?>
	    </article>
	</div><!-- .container .main -->
	</body>
</html>

<?php 

	function getUser($username, $conn){
		# set up query and post it to database
		$stmt = $conn->prepare("SELECT * FROM userInfo WHERE userName = ?");
		$stmt->bind_param("s", $username); #? replaced with $username
		$stmt->execute();
		if(!$stmt) die ($conn->error);

		# store result
		$result = $stmt->get_result();
		$stmt->fetch();

		$stmt->close();

		return $result->fetch_assoc();
	}
?>