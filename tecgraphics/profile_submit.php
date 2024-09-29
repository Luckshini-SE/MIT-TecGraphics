<?php
session_start();

include('db_connection.php');

$ctype = mysqli_real_escape_string($con, $_POST['ctype']);
$cus_id = mysqli_real_escape_string($con, $_POST['cus_id']);

$fname = mysqli_real_escape_string($con, $_POST['fname']);
$phone = mysqli_real_escape_string($con, $_POST['phone']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$address1 = mysqli_real_escape_string($con, $_POST['address1']);
$address2 = mysqli_real_escape_string($con, $_POST['address2']);
$address3 = mysqli_real_escape_string($con, $_POST['address3']);

if($ctype == 'i'){		//query for individual customer

	$ctitle = mysqli_real_escape_string($con, $_POST['title']);
	$lname = mysqli_real_escape_string($con, $_POST['lname']);
	$mobile = mysqli_real_escape_string($con, $_POST['mobile']);

} else {		//mobile number does not exist

	$ctitle = '6';
	$lname = '';
	$mobile = '';

}

$update = mysqli_query($con, "UPDATE customer SET `ctype` = '$ctype', `title` = '$ctitle', `name` = '$fname', `last_name` = '$lname', `mobile` = '$mobile', 
`phone` = '$phone', `email` = '$email', `address1` = '$address1', `address2` = '$address2', `address3` = '$address3' WHERE id = '$cus_id'");

?>
<script>
	setTimeout('location.href = "profile.php"', 0);
</script>