<?php 

require_once "connect.php";
		  
		$opcja = $_POST['opcja'];
		
		


   $sql = "UPDATE pokaz SET  poka= '$opcja' WHERE idpo=1";
       
   
		if (mysqli_query($connection, $sql)) 
		{
			echo "wysłano";
		} 
		else 
		{
			echo "Error: " . $sql . "<br>" . mysqli_error($connection);
		}
	   




	echo "<script>window.location.href='zalogowany.php?id=opcje';</script>";
?>