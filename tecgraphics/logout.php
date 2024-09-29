<?php
	session_start();
	

	unset($_SESSION["logUserId"]);
	unset($_SESSION["logUserName"]);
	
	session_destroy();
	header("Location:login.php");
?>