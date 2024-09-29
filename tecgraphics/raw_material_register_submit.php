<?php
session_start();
$loguser = $_SESSION["logUserId"];

if($loguser == ''){		//check if user is logged in
	header('Location: login.php');
} else {

include('db_connection.php');

$rmcode = mysqli_real_escape_string($con, $_POST['rmcode']);
$rmname = mysqli_real_escape_string($con, $_POST['rmname']);
$uom = mysqli_real_escape_string($con, $_POST['uom']);
$category = mysqli_real_escape_string($con, $_POST['category']);
$rlevel = mysqli_real_escape_string($con, $_POST['rlevel']);
$rqty = mysqli_real_escape_string($con, $_POST['rqty']);
$cid = mysqli_real_escape_string($con, $_POST['cid']);

if($cid == ''){		//new record

$select_duplicate = mysqli_query($con, "SELECT id FROM rawmaterial WHERE code = '$rmcode'");	//check if code already exist

if(mysqli_num_rows($select_duplicate) > 0){							//if item code already exist	
$_SESSION['error'] = "Raw material code already exist.";			//pass error message
} else {																//if item code does not exist

$insert = mysqli_query($con, "INSERT INTO `rawmaterial`
(`code`, `name`, `uom`, `category`, `ro_level`, `ro_qty`) VALUES 
('$rmcode', '$rmname', '$uom', '$category', '$rlevel', '$rqty')");		//insert to table

$_SESSION['success'] = "Raw material registered successfully.";			//pass success message
}
} else {		//edit record

$select_duplicate = mysqli_query($con, "SELECT id FROM rawmaterial WHERE code = '$rmcode' AND id != '$cid'");	//check if code already exist

if(mysqli_num_rows($select_duplicate) > 0){
$_SESSION['error'] = "Raw material code already exist.";
} else {

$update = mysqli_query($con, "UPDATE `rawmaterial` SET
`code` = '$rmcode', `name` = '$rmname', `uom` = '$uom', `category` = '$category', `ro_level` = '$rlevel', `ro_qty` = '$rqty' WHERE id = '$cid'");

$_SESSION['success'] = "Raw material updated successfully.";
}
}
?>
<script>
	setTimeout('location.href = "raw_material_register.php"', 0);
</script>
<?php } ?>