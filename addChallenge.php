<?php
	require_once 'loginInfo.php'; #getting info to connect to the database

  	#new connection
	$conn = new mysqli($hostAddress, $uname, $pword, $database); 
	if($conn->connect_error) die($conn->connect_error);

	#goals 1-10
	$goalOne = $_POST["goalOne"];
	$goalTwo = $_POST["goalTwo"];
	$goalThree = $_POST["goalThree"];
	$goalFour = $_POST["goalFour"];
	$goalFive = $_POST["goalFive"];
	$goalSix = $_POST["goalSix"];
	$goalSeven = $_POST["goalSeven"];
	$goalEight = $_POST["goalEight"];
	$goalNine = $_POST["goalNine"];
	$goalTen = $_POST["goalTen"];

	#non goal stuff

	$numOfItems = $_POST["numOfItems"];
	$title = $_POST["title"];
	$summary = $_POST["summary"];
	$currentTask = 0;

	
	$query = "INSERT INTO challenges values('$goalOne','$goalTwo', '$goalThree', '$goalFour' , '$goalFive', '$goalSix', '$goalSeven', '$goalEight', '$goalNine', '$goalTen', '$numOfItems', '$title' , '$summary', '$currentTask')";
	   	 		
	// $result = $conn->query($query);
	// if(!$result) die ("failed: ".$conn->error);
	echo json_encode($conn->query($query)); //return true/false

?>