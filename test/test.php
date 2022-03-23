<?php
	require_once "session_check.php"; 
	require_once "connect.php";
		  
	$category ='repair';
	$message = 'Tesujemy';	
	$idu ='3';

	mysqli_query($connection, "SET CHARSET utf8");
    mysqli_query($connection, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");

	$sql_sm1 = "INSERT into messages(idu,category,message) VALUES ('$idu','$category','$message')";
       
	if (mysqli_query($connection, $sql_sm1)) 
	{
		echo "wysłano";
	} 
	else 
	{
		echo "Error: " . $sql_sm1 . "<br>" . mysqli_error($connection);
	}   
?>