<?php
session_start();
$loguser = $_SESSION["logUserId"];

if($loguser == ''){		//check if user is logged in
	header('Location: login.php');
} else {

include('db_connection.php');

//Set time zone
$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
$datetime = $createToday->format('Y-m-d H:i:s');

$select_max = mysqli_query($con, "SELECT del_no FROM `delivery` ORDER BY id DESC");

if(mysqli_num_rows($select_max) > 0){
	$result_max = mysqli_fetch_array($select_max);
		$temp = substr($result_max['del_no'], 2);
		$max = $temp+1;
		$del_no = 'DN'.$max;

} else {
	$del_no = 'DN10001';
}

$del_date = mysqli_real_escape_string($con, $_POST['del_date']);
$cust_id = mysqli_real_escape_string($con, $_POST['cust_id']);
$inv_id = mysqli_real_escape_string($con, $_POST['inv_id']);
$num_rows = mysqli_real_escape_string($con, $_POST['num_rows']);


	$insert = mysqli_query($con, "INSERT INTO delivery 
	(`del_no`, `del_date`, `invoice_id`, `cus_id`, `log_user`, `log_datetime`) VALUES 
	('$del_no', '$del_date', '$inv_id', '$cust_id', '$loguser', '$datetime')");
	$jid = mysqli_insert_id($con);

	for($i=1; $i<=$num_rows; $i++){
		
		$row_id = mysqli_real_escape_string($con, $_POST['row_id'.$i]);
		$prod_id = mysqli_real_escape_string($con, $_POST['prod_id'.$i]);
		$qty = mysqli_real_escape_string($con, $_POST['qty'.$i]);
		$packing = mysqli_real_escape_string($con, $_POST['packing'.$i]);

		$insert2 = mysqli_query($con, "INSERT INTO `delivery_details`
		(`delivery_id`, `prod_id`, `qty`, `packing`, `invitm_id`) VALUES 
		('$jid', '$prod_id', '$qty', '$packing', '$row_id')");
		
	}

	$update = mysqli_query($con, "UPDATE invoice SET delivery = 'yes' WHERE id = '$inv_id'");



$_SESSION['success'] = "Delivery note created successfully. Your delivery note number is ".$del_no;
?>
<script>
	setTimeout('location.href = "pending_invoices.php"', 0);
</script>
<?php } ?>