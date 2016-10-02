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

  #going through all the username's
  for ($i=0; $i < $rows; $i++) { 
    $result->data_seek($i);
    echo 'firstName: '.$result->fetch_assoc()['firstName'].'<br>';
    $result->data_seek($i);
    echo 'lastName: '.$result->fetch_assoc()['lastName'].'<br>';
    $result->data_seek($i);
    echo 'userName: '.$result->fetch_assoc()['userName'].'<br>';
    $result->data_seek($i);
    echo 'email: '.$result->fetch_assoc()['email'].'<br>';
    $result->data_seek($i);
    echo 'password: '.$result->fetch_assoc()['password'].'<br>';
    $result->data_seek($i);
    echo 'age: '.$result->fetch_assoc()['age'].'<br>';
    echo '----------------------------------------------------<br><br>';
  }

  $result->close();
  $conn->close();



?>