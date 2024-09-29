<?php
session_start();
$loguser = $_SESSION["logUserId"];

if($loguser == ''){		//check if user is logged in
	header('Location: login.php');
} else {

include('db_connection.php');

if(isset($_POST['approve'])){
	$approve = 'yes';
} else {
	$approve = 'no';
}

//Set time zone
$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
$cur_date = $createToday->format('Y-m-d H:i:s');

$grn_num = mysqli_real_escape_string($con, $_POST['grn_num']);

$update = mysqli_query($con, "UPDATE grn_summary SET approval = '$approve', app_user = '$loguser', app_datetime = '$cur_date' WHERE grn_no = '$grn_num'");

if($approve == 'yes'){
	$update2 = mysqli_query($con, "UPDATE grn_stock SET available_qty = grn_qty WHERE grn_no = '$grn_num'");

	$_SESSION['success'] = "GRN approved.";
} else {
	$_SESSION['error'] = "GRN rejected.";
}

?>
<script>
	setTimeout('location.href = "pending_grn.php"', 0);
</script>
<?php } ?>