<?php

	require_once('loginInfo.php');

	$conn = new mysqli($hostAddress, $uname, $pword, $database); 
  	if($conn->connect_error) die($conn->connect_error);

  	$query = "INSERT INTO challengeswwallisabc Values('1 push ups','2 push ups','3 push ups','4 push ups','5 push ups','6 push ups','7 push ups','8 push ups','9 push ups','10 push ups','10','Push Up Challege','Build up to 10 push ups','0')";
    $result = $conn->query($query);
    if(!$result){
      die($conn->error);
    }

?>