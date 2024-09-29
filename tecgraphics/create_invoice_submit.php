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

$select_max = mysqli_query($con, "SELECT invoice_no FROM `invoice` ORDER BY id DESC");

if(mysqli_num_rows($select_max) > 0){
	$result_max = mysqli_fetch_array($select_max);
		$temp = substr($result_max['invoice_no'], 3);
		$max = $temp+1;
		$inv_no = 'INV'.$max;

} else {
	$inv_no = 'INV10001';
}

$inv_date = mysqli_real_escape_string($con, $_POST['inv_date']);
$cust_id = mysqli_real_escape_string($con, $_POST['cust_id']);
$job_id = mysqli_real_escape_string($con, $_POST['job_id']);
$num_rows = mysqli_real_escape_string($con, $_POST['num_rows']);
$subtotal = mysqli_real_escape_string($con, $_POST['subtotal']);
$disc_per = mysqli_real_escape_string($con, $_POST['disc_per']);
$discount = mysqli_real_escape_string($con, $_POST['discount']);
$total = mysqli_real_escape_string($con, $_POST['total']);


	$insert = mysqli_query($con, "INSERT INTO invoice 
	(`invoice_no`, `invoice_date`, `jobcard_id`, `cus_id`, `subtotal`, `dis_per`, `discount`, `total`, `pay_balance`, `log_user`, `log_datetime`) VALUES 
	('$inv_no', '$inv_date', '$job_id', '$cust_id', '$subtotal', '$disc_per', '$discount', '$total', '$total', '$loguser', '$datetime')");
	$iid = mysqli_insert_id($con);

	for($i=1; $i<=$num_rows; $i++){
		
		if(isset($_POST['select'.$i])){	

		$row_id = mysqli_real_escape_string($con, $_POST['row_id'.$i]);
		$prod_id = mysqli_real_escape_string($con, $_POST['prod_id'.$i]);
		$uprice = mysqli_real_escape_string($con, $_POST['uprice'.$i]);
		$qty = mysqli_real_escape_string($con, $_POST['qty'.$i]);
		$amount = mysqli_real_escape_string($con, $_POST['amount'.$i]);
		$aw_price = mysqli_real_escape_string($con, $_POST['aw_price'.$i]);
		$sv_price = mysqli_real_escape_string($con, $_POST['sv_price'.$i]);

		$insert2 = mysqli_query($con, "INSERT INTO `invoice_details`
		(`invoice_id`, `prod_id`, `uprice`, `qty`, `amount`, `artwork`, `service`, `jitm_id`) VALUES 
		('$iid', '$prod_id', '$uprice', '$qty', '$amount', '$aw_price', '$sv_price', '$row_id')");

		if($aw_price>0){
			$update2 = mysqli_query($con, "UPDATE jobcard_details SET artwork_inv = 'yes' WHERE id = '$row_id'");
		}
		
		if($sv_price>0){
			$update3 = mysqli_query($con, "UPDATE jobcard_details SET service_inv = 'yes' WHERE id = '$row_id'");
		}

		$select = mysqli_query($con, "SELECT invoiced_qty FROM jobcard_details WHERE id = '$row_id'");
		$result = mysqli_fetch_array($select);
			$invoiced = $result['invoiced_qty'];
			$inv_qty = $invoiced+$qty;

		$update = mysqli_query($con, "UPDATE jobcard_details SET invoiced_qty = '$inv_qty' WHERE id = '$row_id'");

		}
		
	}



$_SESSION['success'] = "Invoice created successfully. Your invoice number is ".$inv_no;
?>
<script>
	setTimeout('location.href = "pending_jobs.php"', 0);
</script>
<?php } ?>