<?php
session_start();
$loguser = $_SESSION["logUserId"];

if($loguser == ''){		//check if user is logged in
	header('Location: login.php');
} else {

include('db_connection.php');

$sname = mysqli_real_escape_string($con, $_POST['sname']);
$contactp = mysqli_real_escape_string($con, $_POST['contactp']);
$contact = mysqli_real_escape_string($con, $_POST['contact']);
$address = mysqli_real_escape_string($con, $_POST['address']);
$email = mysqli_real_escape_string($con, $_POST['semail']);
$cid = mysqli_real_escape_string($con, $_POST['cid']);

if($cid == ''){		//new record

$select = mysqli_query($con, "SELECT * FROM supplier WHERE sname = '$sname'");

if(mysqli_num_rows($select) > 0){		//duplicate entry
$_SESSION['error'] = "Supplier name already exists.";
?>
<script>
	setTimeout('location.href = "supplier_register.php"', 0);
</script>
<?php
} else {		//not duplicate

$insert = mysqli_query($con, "INSERT INTO `supplier`
(`sname`, `contactp`, `contact`, `address`, `email`) VALUES 
('$sname', '$contactp', '$contact', '$address', '$email')");

$_SESSION['success'] = "Supplier created successfully.";
?>
<script>
	setTimeout('location.href = "supplier_register.php"', 0);
</script>
<?php 
}		//end - duplicate check
} else {		//edit record
	
$select = mysqli_query($con, "SELECT * FROM supplier WHERE sname = '$sname' AND id != '$cid'");

if(mysqli_num_rows($select) > 0){		//duplicate entry
$_SESSION['error'] = "Supplier name already exists.";
?>
<script>
	setTimeout('location.href = "supplier_register.php"', 0);
</script>
<?php
} else {		//not duplicate

$insert = mysqli_query($con, "UPDATE `supplier` SET
`sname` = '$sname', `contactp` = '$contactp', `contact` = '$contact', `address` = '$address', `email` = '$email' WHERE id = '$cid'");

$_SESSION['success'] = "Supplier updated successfully.";
?>
<script>
	setTimeout('location.href = "supplier_register.php"', 0);
</script>
<?php
}		//end - duplicate check
}
} 
?>