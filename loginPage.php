<?php  #learning php,mysql + javascript was heavily used
	require_once 'loginInfo.php'; #getting info to connect to the database

  #new connection
	$conn = new mysqli($hostAddress, $uname, $pword, $database); 
	if($conn->connect_error) die($conn->connect_error);

  #query data base with sql
  $query = "select * FROM userInfo";
  $result = $conn ->query($query);
  if(!$result) die ($conn->error);


  $rows = $result->num_rows;

  $usernameInput = $_POST["username"];
  $passwordInput = $_POST["password"];


  #going through all the username's
  
  for ($i=0; $i < $rows; $i++) { 
    $result->data_seek($i);
      
       $temp = ($result->fetch_assoc()['userName']);
    if($temp == $usernameInput){
      $result->data_seek($i);
  
      $tempThree = $result->fetch_assoc()['password'];
        if($tempThree == $passwordInput){
            echo "<script> window.location = 'http://wilfredwallis.com/profile.php' </script>";
            #YOU ARE LOGGED IN
        } else {
          echo "you have not got in";
        }
    }

  }
   echo "HELLO";

  $result->close();
  $conn->close();



?> 