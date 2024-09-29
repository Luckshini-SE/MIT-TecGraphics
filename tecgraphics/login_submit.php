<?php
session_start();
include('db_connection.php');

$username = mysqli_real_escape_string($con,$_POST['email']);
$password = mysqli_real_escape_string($con,$_POST['password']);

$new_password = md5($password);

$select_user = mysqli_query($con, "SELECT * FROM users WHERE username = '$username' AND password = '$new_password' AND active = 'yes'");
$result_user = mysqli_fetch_array($select_user);

if(mysqli_num_rows($select_user) <= 0){			//if there are no matching records

$_SESSION['error'] = "Invalid login.";
?>
<script>
	setTimeout('location.href = "login.php"',0);
</script>
<?php
} else {		//if there are matching records

$_SESSION["logUserId"]	= $result_user['id'];
$_SESSION["logUserName"]	= $result_user['first_name'];
$_SESSION["logUserType"]	= $result_user['user_type'];

?>
<script>
	setTimeout('location.href = "dashboard.php"',0);
</script>
<?php
}
?>