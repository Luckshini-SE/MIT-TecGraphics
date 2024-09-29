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

$po_num = mysqli_real_escape_string($con, $_POST['po_num']);

$update = mysqli_query($con, "UPDATE purchase_order_summary SET approval = '$approve', app_user = '$loguser', app_datetime = '$cur_date' WHERE po_no = '$po_num'");

if($approve == 'yes'){
	$_SESSION['success'] = "Purchase order approved.";
} else {
	$_SESSION['error'] = "Purchase order rejected.";
}
?>
<script>
	setTimeout('location.href = "pending_po.php"', 0);
</script>
<?php } ?>