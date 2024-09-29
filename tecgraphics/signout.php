<?php
	session_start();
	

	unset($_SESSION["customerId"]);
	unset($_SESSION["customerName"]);
	
	session_destroy();
	header("Location:index.php");
?>