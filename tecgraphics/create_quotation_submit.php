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

$select_max = mysqli_query($con, "SELECT q_no FROM `quotation` ORDER BY id DESC");

if(mysqli_num_rows($select_max) > 0){
	$result_max = mysqli_fetch_array($select_max);
		$temp = substr($result_max['q_no'], 2);
		$max = $temp+1;
		$q_no = 'QT'.$max;

} else {
	$q_no = 'QT10001';
}

$quot_date = mysqli_real_escape_string($con, $_POST['quot_date']);
$cust_id = mysqli_real_escape_string($con, $_POST['cust_id']);
$req_id = mysqli_real_escape_string($con, $_POST['req_id']);
$sales_ex = mysqli_real_escape_string($con, $_POST['sales_ex']);
$subtotal = mysqli_real_escape_string($con, $_POST['subtotal']);
$disc_per = mysqli_real_escape_string($con, $_POST['disc_per']);
$discount = mysqli_real_escape_string($con, $_POST['discount']);
$total = mysqli_real_escape_string($con, $_POST['total']);
$num_rows = mysqli_real_escape_string($con, $_POST['num_rows']);


	$insert = mysqli_query($con, "INSERT INTO quotation 
	(`q_no`, `q_date`, `req_id`, `cus_id`, `sales_ex`, `subtotal`, `dis_per`, `discount`, `total`, `log_user`, `log_datetime`) VALUES 
	('$q_no', '$quot_date', '$req_id', '$cust_id', '$sales_ex', '$subtotal', '$disc_per', '$discount', '$total', '$loguser', '$datetime')");
	$qid = mysqli_insert_id($con);

	for($i=1; $i<=$num_rows; $i++){
		
		$row_id = mysqli_real_escape_string($con, $_POST['row_id'.$i]);
		$prod_id = mysqli_real_escape_string($con, $_POST['prod_id'.$i]);
		$pro_price = mysqli_real_escape_string($con, $_POST['pro_price'.$i]);
		$finish = mysqli_real_escape_string($con, $_POST['finish'.$i]);
		$specone = mysqli_real_escape_string($con, $_POST['specone'.$i]);
		$spectwo = mysqli_real_escape_string($con, $_POST['spectwo'.$i]);
		$qty = mysqli_real_escape_string($con, $_POST['qty'.$i]);
		$uprice = mysqli_real_escape_string($con, $_POST['uprice'.$i]);
		$amount = mysqli_real_escape_string($con, $_POST['amount'.$i]);

		if(isset($_POST['artwork'.$i])){
			$artwork = 'yes';
			$aw_price = mysqli_real_escape_string($con, $_POST['aw_price'.$i]);
		} else {
			$artwork = 'no';
			$aw_price = '0.00';
		}
		
		if(isset($_POST['service'.$i])){
			$service = 'yes';
			$sv_price = mysqli_real_escape_string($con, $_POST['sv_price'.$i]);
		} else {
			$service = 'no';
			$sv_price = '0.00';
		}

		$insert2 = mysqli_query($con, "INSERT INTO `quotation_details`
		(`quot_id`, `prod_id`, `item_price`, `finishing`, `spec1`, `spec2`, `uprice`, `qty`, `amount`, `artwork_status`, `artwork`, `service_status`, `service`, `req_item_id`) VALUES 
		('$qid', '$prod_id', '$pro_price', '$finish', '$specone', '$spectwo', '$uprice', '$qty', '$amount', '$artwork', '$aw_price', '$service', '$sv_price', '$row_id')");
		
	}

	$update = mysqli_query($con, "UPDATE quotation_requests SET status = 'quotation' WHERE id = '$req_id'");



$_SESSION['success'] = "Quotation created successfully. Your quotation number is ".$q_no;
?>
<script>
	setTimeout('location.href = "pending_requests.php"', 0);
</script>
<?php } ?>