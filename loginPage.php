<?php  #learning php,mysql + javascript was heavily used

	function authenticate($username, $password){

	 	#getting info to connect to the database
		require'loginInfo.php';

		#new connection using login stored in "loginInfo.php"
		$conn = new mysqli($hostAddress, $uname, $pword, $database);
		if($conn->connect_error) die($conn->connect_error);

		#set up query and post it to database
		$stmt = $conn->prepare("SELECT * FROM userInfo WHERE userName = ?");
		$stmt->bind_param("s", $username); #? replaced with $username
		$stmt->execute();
		if(!$stmt) die ($conn->error);

		#store result
		$result = $stmt->get_result();
		$stmt->fetch();

		#user not found or multiple identical usernames
		if($result->num_rows != 1) return false;

		$verified = false;

		#verify password
		if(password_verify($password, $result->fetch_assoc()['password'])){
			#set cookie to remember login for 1 month on entire domain
			setcookie("loggedIn", $username, strtotime("+1 month"), "/");
			
			$verified = true;
		}

		#cleanup
		$stmt->close();
		$conn->close();

		return $verified;
	}

	if($_COOKIE["loggedIn"]){
		#Redirect browser
		header("Location: http://wilfredwallis.com/csc210/profile.php"); 
		exit();
	}
	else{
		#check user in database
		if(authenticate($_POST["username"], $_POST["password"])){
			#Redirect browser
			header("Location: http://wilfredwallis.com/csc210/profile.php"); 
			exit();
		}
		else{
			echo "Not logged in";
		}
	}
?>