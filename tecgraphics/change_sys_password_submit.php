<?php
session_start();
$loguser = $_SESSION["logUserId"];

if($loguser == ''){		//check if user is logged in
	header('Location: login.php');
} else {

include('db_connection.php');

$opass = mysqli_real_escape_string($con, $_POST['opass']);
$npass = mysqli_real_escape_string($con, $_POST['npass']);
$cpass = mysqli_real_escape_string($con, $_POST['cpass']);

$select_usr = mysqli_query($con, "SELECT password FROM users WHERE id = '$loguser'");
$result_usr = mysqli_fetch_array($select_usr);
	$spass = $result_usr['password'];

$ex_password = md5($opass);

if($ex_password != $spass){		//if entered curent password is incorrect
$_SESSION['error'] = "Entered current password is incorrect.";
?>
<script>
	setTimeout('location.href = "change_sys_password.php"', 0);
</script>
<?php
} else {		//if correct
	
$new_password = md5($npass);

$update = mysqli_query($con, "UPDATE users SET `password` = '$new_password' WHERE id = '$loguser'");

$_SESSION['success'] = "Successfully changed password.";
?>
<script>
	setTimeout('location.href = "change_sys_password.php"', 0);
</script>
<?php 
}		//end - current password check

} 
?>