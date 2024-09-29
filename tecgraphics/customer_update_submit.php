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
$cid = mysqli_real_escape_string($con, $_POST['cid']);

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

$select_check = mysqli_query($con, "SELECT * FROM customer WHERE (mobile = '$mobile' OR phone = '$mobile') AND id != '$cid'");

if(mysqli_num_rows($select_check) > 0){		//mobile number already exist for another customer 
	
$_SESSION['error'] = "Mobile number already exists.";
?>
<script>
	setTimeout('location.href = "customer_list.php"', 0);
</script>
<?php

} else {		//mobile number does not exist

	$insert = mysqli_query($con, "UPDATE customer SET `title` = '$ctitle', `name` = '$fname', `last_name` = '$lname', `mobile` = '$mobile', `phone` = '$phone',
	`email` = '$email', `address1` = '$address1', `address2` = '$address2', `address3` = '$address3' WHERE id = '$cid'");

$_SESSION['success'] = "Customer updated successfully.";
?>
<script>
	setTimeout('location.href = "customer_list.php"', 0);
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

$select_check = mysqli_query($con, "SELECT * FROM customer WHERE (mobile = '$phone' OR phone = '$phone') AND id != '$cid'");

if(mysqli_num_rows($select_check) > 0){		//mobile number already exist for another customer
	
$_SESSION['error'] = "Mobile number already exists.";
?>
<script>
	setTimeout('location.href = "customer_list.php"', 0);
</script>
<?php

} else {		//mobile number does not exist
	
	$insert = mysqli_query($con, "UPDATE customer SET `name` = '$cname', `phone` = '$phone', `fax` = '$fax', `email` = '$email', `web` = '$web',
	`address1` = '$address1', `address2` = '$address2', `address3` = '$address3' WHERE id = '$cid'");
	
	$ex_rows = mysqli_real_escape_string($con, $_POST['ex_num_rows']);

	for($j=1; $j<=$ex_rows; $j++){

		$ex_rowid = mysqli_real_escape_string($con, $_POST['ex_rowid'.$j]);
		$ex_contitle = mysqli_real_escape_string($con, $_POST['ex_contitle'.$j]);
		$ex_confname = mysqli_real_escape_string($con, $_POST['ex_confname'.$j]);
		$ex_conlname = mysqli_real_escape_string($con, $_POST['ex_conlname'.$j]);
		$ex_conmobile = mysqli_real_escape_string($con, $_POST['ex_conmobile'.$j]);
		$ex_conemail = mysqli_real_escape_string($con, $_POST['ex_conemail'.$j]);

		$insert2 = mysqli_query($con, "UPDATE `contact_person` SET `ctitle` = '$ex_contitle', `cfname` = '$ex_confname', `clname` = '$ex_conlname', 
		`cphone` = '$ex_conmobile', `cemail` = '$ex_conemail' WHERE id = '$ex_rowid'");
	}

	$rows = mysqli_real_escape_string($con, $_POST['num_rows']);

	for($i=1; $i<=$rows; $i++){

		$contitle = mysqli_real_escape_string($con, $_POST['contitle'.$i]);
		$confname = mysqli_real_escape_string($con, $_POST['confname'.$i]);
		$conlname = mysqli_real_escape_string($con, $_POST['conlname'.$i]);
		$conmobile = mysqli_real_escape_string($con, $_POST['conmobile'.$i]);
		$conemail = mysqli_real_escape_string($con, $_POST['conemail'.$i]);

		if($confname != ''){		//if new row is filled
		$insert3 = mysqli_query($con, "INSERT INTO `contact_person`
		(`customer`, `ctitle`, `cfname`, `clname`, `cphone`, `cemail`) VALUES 
		('$cid', '$contitle', '$confname', '$conlname', '$conmobile', '$conemail')");
		}
	}

$_SESSION['success'] = "Customer updated successfully.";
?>
<script>
	setTimeout('location.href = "customer_list.php"', 0);
</script>
<?php
}


}

}

?>