<?php #learning php,mysql + javascript was heavily used
	require_once 'loginInfo.php'; #getting info to connect to the database

  	#new connection
	$conn = new mysqli($hostAddress, $uname, $pword, $database); 
	if($conn->connect_error) die($conn->connect_error);

	if(isset($_POST['firstName']) &&
	   isset($_POST['lastName']) &&
	   isset($_POST['userName']) &&
	   isset($_POST['email']) &&
	   isset($_POST['password']) &&
	   isset($_POST['age']))
	   {
	   	$firstName = get_post($conn, 'firstName');
	   	$lastName = get_post($conn, 'lastName');
	   	$userName = get_post($conn, 'userName');
	   	$email = get_post($conn, 'email');
	   	$password = get_post($conn, 'password');
	   	$age = get_post($conn, 'age');

	   	#query data base with sql
		$query = "select * FROM userInfo";
		$result = $conn ->query($query);
		if(!$result) die ($conn->error);


		$rows = $result->num_rows;

		#going through all the username's
		for ($i=0; $i < $rows; $i++) { 
		   $result->data_seek($i);
		   if(($result->fetch_assoc()['userName']) == $userName ){
echo <<<_END
<script>
function hello() {
document.getElementById("message").innerHTML = "Sorry that is taken";
}

window.onload = hello;
</script>

_END;
		   	$userNameTaken = ture;
			$result->close();
			$conn->close();

		

		   
		   } 
		   	$result->data_seek($i);
			 
			if($result->fetch_assoc()['email'] == $email){
			$emailTaken = ture;
echo <<<_END
<script>
function hello() {
document.getElementById("message").innerHTML = "Sorry that email is taken";
}

window.onload = hello;
</script>

_END;

			}
		}
		if(!$userNameTaken && !$emailTaken ) {


echo <<<_END
<script>
function hello() {
document.getElementById("message").innerHTML = "Nice you have an account now!";
}
window.onload = hello;
</script>
_END;
	   			$query = "INSERT INTO userInfo values".
	   	 		"('$firstName','$lastName','$userName','$email','$password','$age')";

	   	 		$result = $conn->query($query);
	   	 		if(!$result) 
	   	 		echo "failed!";

		   }


	   
	   
	  }
echo <<<_END
<html>
<head>
	<meta charset="utf-8">
	<title>Sign Up | Challenge Channel</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body id="signup">
	<div class="box">
		<h1>Challenge Channel</h1>
		<h2 class="center">Get started</h2>

		<!-- html form --> 
			<p id='message'> </p>
	   		<form action="adding.php" method="post" <pre>
	   		firstName <input type="text" name="firstName"><br>
	   		lastName <input type="text" name="lastName"><br>
	   		userName <input type="text" name="userName"><br>
	   		email <input type="text" name="email"><br>
	   		password <input type="text" name="password"><br>
	   		age <input type="text" name="age"><br>
	   		<input type="submit" value="ADD RECORD">
	   		</pre></form>
	   		</div>
</body>
</html>
_END;


		function get_post($conn, $var)
		{
			return $conn->real_escape_string($_POST[$var]);
		}
		

			$result->close();
			$conn->close();
?>