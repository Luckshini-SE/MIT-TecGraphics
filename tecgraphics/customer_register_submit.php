<?php
session_start();
$loguser = $_SESSION["logUserId"];

if($loguser == ''){		//check if user is logged in
	header('Location: login.php');
} else {

include('db_connection.php');

//Set time zone
$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
$tadetime = $createToday->format('Y-m-d H:i:s');

$ctype = mysqli_real_escape_string($con, $_POST['ctype']);

if($ctype == 'i'){		//query for individual customer

$ctitle = mysqli_real_escape_string($con, $_POST['ctitle']);
$fname = mysqli_real_escape_string($con, $_POST['fname']);
$lname = mysqli_real_escape_string($con, $_POST['lname']);
$mobile = mysqli_real_escape_string($con, $_POST['mobile']);
$phone = mysqli_real_escape_string($con, $_POST['phone']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$address1 = mysqli_real_escape_string($con, $_POST['address1']);
$address2 = mysqli_real_escape_string($con, $_POST['address2']);
$address3 = mysqli_real_escape_string($con, $_POST['address3']);

$select_check = mysqli_query($con, "SELECT * FROM customer WHERE mobile = '$mobile' OR phone = '$mobile'");

if(mysqli_num_rows($select_check) > 0){		//mobile number already exist 
	
$_SESSION['error'] = "Mobile number already exists.";
?>
<script>
	setTimeout('location.href = "customer_register.php"', 0);
</script>
<?php

} else {		//mobile number does not exist

	$insert = mysqli_query($con, "INSERT INTO customer 
	(`ctype`, `title`, `name`, `last_name`, `mobile`, `phone`, `email`, `address1`, `address2`, `address3`, `reg_mode`, `reg_date`) VALUES 
	('$ctype', '$ctitle', '$fname', '$lname', '$mobile', '$phone', '$email', '$address1', '$address2', '$address3', 'offline', '$tadetime')");

$_SESSION['success'] = "Customer registered successfully.";
?>
<script>
	setTimeout('location.href = "customer_register.php"', 0);
</script>
<?php
}


} else {		//query for company customer

$cname = mysqli_real_escape_string($con, $_POST['cname']);
$phone = mysqli_real_escape_string($con, $_POST['phone']);
$fax = mysqli_real_escape_string($con, $_POST['fax']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$web = mysqli_real_escape_string($con, $_POST['web']);
$address1 = mysqli_real_escape_string($con, $_POST['address1']);
$address2 = mysqli_real_escape_string($con, $_POST['address2']);
$address3 = mysqli_real_escape_string($con, $_POST['address3']);

$select_check = mysqli_query($con, "SELECT * FROM customer WHERE mobile = '$phone' OR phone = '$phone'");

if(mysqli_num_rows($select_check) > 0){		//mobile number already exist 
	
$_SESSION['error'] = "Mobile number already exists.";
?>
<script>
	setTimeout('location.href = "customer_register.php"', 0);
</script>
<?php

} else {		//mobile number does not exist
	
	$insert = mysqli_query($con, "INSERT INTO customer 
	(`ctype`, `title`, `name`, `phone`, `fax`, `email`, `web`, `address1`, `address2`, `address3`, `reg_mode`, `reg_date`) VALUES 
	('$ctype', '6', '$cname', '$phone', '$fax', '$email', '$web', '$address1', '$address2', '$address3', 'offline', '$tadetime')");
	$cus_id = mysqli_insert_id($con);

	$rows = mysqli_real_escape_string($con, $_POST['num_rows']);

	for($i=1; $i<=$rows; $i++){

		$contitle = mysqli_real_escape_string($con, $_POST['contitle'.$i]);
		$confname = mysqli_real_escape_string($con, $_POST['confname'.$i]);
		$conlname = mysqli_real_escape_string($con, $_POST['conlname'.$i]);
		$conmobile = mysqli_real_escape_string($con, $_POST['conmobile'.$i]);
		$conemail = mysqli_real_escape_string($con, $_POST['conemail'.$i]);

		$insert2 = mysqli_query($con, "INSERT INTO `contact_person`
		(`customer`, `ctitle`, `cfname`, `clname`, `cphone`, `cemail`) VALUES 
		('$cus_id', '$contitle', '$confname', '$conlname', '$conmobile', '$conemail')");
	}

$_SESSION['success'] = "Customer registered successfully.";
?>
<script>
	setTimeout('location.href = "customer_register.php"', 0);
</script>
<?php
}


}

}

?>