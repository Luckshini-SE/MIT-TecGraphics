<?php
session_start();
$loguser = $_SESSION["logUserId"];

if($loguser == ''){		//check if user is logged in
	header('Location: login.php');
} else {

include('db_connection.php');

//Set time zone
$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
$cur_date = $createToday->format('Y-m-d H:i:s');

$select_max = mysqli_query($con, "SELECT rec_no FROM `advance_payment` ORDER BY id DESC");
if(mysqli_num_rows($select_max) > 0){
	$result_max = mysqli_fetch_array($select_max);
		$temp = substr($result_max['rec_no'], 2);
		$max = $temp+1;
		$receipt_no = 'AD'.$max;
} else {
	$receipt_no = 'AD10001';
}

$receipt_date = mysqli_real_escape_string($con, $_POST['receipt_date']);
$customer = mysqli_real_escape_string($con, $_POST['customer']);
$description = mysqli_real_escape_string($con, $_POST['description']);
$amount = mysqli_real_escape_string($con, $_POST['amount']);
$paytype = mysqli_real_escape_string($con, $_POST['paytype']);

if($paytype == 'Cheque'){
	$cheqno = mysqli_real_escape_string($con, $_POST['cheqno']);
	$cheqdate = mysqli_real_escape_string($con, $_POST['cheqdate']);
	$depref = '';
} else if($paytype == 'Bank Deposit'){
	$cheqno = '';
	$cheqdate = '';
	$depref = mysqli_real_escape_string($con, $_POST['depref']);
} else {
	$cheqno = '';
	$cheqdate = '';
	$depref = '';
}

$insert = mysqli_query($con, "INSERT INTO `advance_payment`
(`rec_no`, `rec_date`, `customer`, `description`, `amount`, `pay_type`, `balance`, `user`, `datetime`, `cheq_no`, `cheq_date`, `deposit_ref`) VALUES 
('$receipt_no', '$receipt_date', '$customer', '$description', '$amount', '$paytype', '$amount', '$loguser', '$cur_date', '$cheqno', '$cheqdate', '$depref')");


$_SESSION['success'] = "Advance payment added successfully.";
?>
<script>
	setTimeout('location.href = "advance_payment.php"', 0);
</script>
<?php } ?>