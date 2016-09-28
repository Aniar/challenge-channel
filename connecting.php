<?php
	require_once 'loginInfo.php';
	$connection = new mysqli($host, $userName, $password, $database);
	if($connection->connectionect_error) die($connection->connect_error);
?>