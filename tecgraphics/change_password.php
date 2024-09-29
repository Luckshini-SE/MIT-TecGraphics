<?php
session_start();

include('db_connection.php');

$opass = mysqli_real_escape_string($con, $_POST['opass']);
$npass = mysqli_real_escape_string($con, $_POST['npass']);
$cpass = mysqli_real_escape_string($con, $_POST['cpass']);
$cus_id = mysqli_real_escape_string($con, $_POST['cus_id']);

$select_cus = mysqli_query($con, "SELECT password FROM customer WHERE id = '$cus_id'");
$result_cus = mysqli_fetch_array($select_cus);
	$spass = $result_cus['password'];

$ex_password = md5($opass);

if($ex_password != $spass){
$_SESSION['p_error'] = "Entered current password is incorrect.";
?>
<script>
	setTimeout('location.href = "profile.php"', 0);
</script>

<?php
} else {

$new_password = md5($npass);

$update = mysqli_query($con, "UPDATE customer SET `password` = '$new_password' WHERE id = '$cus_id'");

$_SESSION['p_success'] = "Successfully changed password.";
?>
<script>
	setTimeout('location.href = "profile.php"', 0);
</script>
<?php
}
?>