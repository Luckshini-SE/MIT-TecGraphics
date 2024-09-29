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
$yearmon = $createToday->format('ym');
$year = $createToday->format('Y');

$select_max = mysqli_query($con, "SELECT req_no FROM `quotation_requests` WHERE r_datetime LIKE '$year%' ORDER BY id DESC");

if(mysqli_num_rows($select_max) > 0){
	$result_max = mysqli_fetch_array($select_max);
		$temp = explode("/", $result_max['req_no']);
		$max = $temp[2];
		$temp2 = str_pad($max+1,5,"0",STR_PAD_LEFT);
		$req_no = 'R/'.$yearmon.'/'.$temp2;

} else {
	$req_no = 'R/'.$yearmon.'/00001';
}

$cus_id = mysqli_real_escape_string($con, $_POST['customer']);

//Insert to database
$insert1 = mysqli_query($con, "INSERT INTO `quotation_requests` (`req_no`, `r_datetime`, `cus_id`, `mode`) VALUES  ('$req_no', '$tadetime', '$cus_id', 'walkin')");
$iId = mysqli_insert_id($con);

//update request
$update2 = mysqli_query($con, "UPDATE requests SET status = 'quote', req_id = '$iId' WHERE cust_id = '$cus_id' AND status = 'open'");

$_SESSION['success'] = "Successfully saved. Reference number is ".$req_no;
?>
<script>
	setTimeout('location.href = "customer_request.php"', 0);
</script>
<?php 

} 
?>