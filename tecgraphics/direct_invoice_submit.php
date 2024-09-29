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
$cust_id = mysqli_real_escape_string($con, $_POST['customer']);
$num_rows = mysqli_real_escape_string($con, $_POST['num_rows']);
$subtotal = mysqli_real_escape_string($con, $_POST['subtotal']);
$disc_per = mysqli_real_escape_string($con, $_POST['disc_per']);
$discount = mysqli_real_escape_string($con, $_POST['discount']);
$total = mysqli_real_escape_string($con, $_POST['total']);


	$insert = mysqli_query($con, "INSERT INTO invoice 
	(`invoice_no`, `invoice_date`, `cus_id`, `subtotal`, `dis_per`, `discount`, `total`, `pay_balance`, `log_user`, `log_datetime`, `inv_type`) VALUES 
	('$inv_no', '$inv_date', '$cust_id', '$subtotal', '$disc_per', '$discount', '$total', '$total', '$loguser', '$datetime', 'direct')");
	$iid = mysqli_insert_id($con);

	for($i=1; $i<=$num_rows; $i++){
		
		$product = mysqli_real_escape_string($con, $_POST['product'.$i]);
		$uprice = mysqli_real_escape_string($con, $_POST['uprice'.$i]);
		$qty = mysqli_real_escape_string($con, $_POST['qty'.$i]);
		$amount = mysqli_real_escape_string($con, $_POST['amount'.$i]);

		$insert2 = mysqli_query($con, "INSERT INTO `invoice_details`
		(`invoice_id`, `description`, `uprice`, `qty`, `amount`) VALUES 
		('$iid', '$product', '$uprice', '$qty', '$amount')");

	}



$_SESSION['success'] = "Invoice created successfully. Your invoice number is ".$inv_no;
?>
<script>
	setTimeout('location.href = "direct_invoice.php"', 0);
</script>
<?php } ?>