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

$select_max = mysqli_query($con, "SELECT jobno FROM `jobcard` ORDER BY id DESC");

if(mysqli_num_rows($select_max) > 0){
	$result_max = mysqli_fetch_array($select_max);
		$temp = substr($result_max['jobno'], 2);
		$max = $temp+1;
		$job_no = 'JO'.$max;

} else {
	$job_no = 'JO10001';
}

$job_date = mysqli_real_escape_string($con, $_POST['job_date']);
$cust_id = mysqli_real_escape_string($con, $_POST['cust_id']);
$quot_id = mysqli_real_escape_string($con, $_POST['quot_id']);
$num_rows = mysqli_real_escape_string($con, $_POST['num_rows']);
$mat_num_rows = mysqli_real_escape_string($con, $_POST['mat_num_rows']);
$machine = mysqli_real_escape_string($con, $_POST['machine']);
$instr = mysqli_real_escape_string($con, $_POST['instr']);


	$insert = mysqli_query($con, "INSERT INTO jobcard 
	(`jobno`, `job_date`, `quotation_id`, `cus_id`, `machine`, `instructions`, `log_user`, `log_datetime`) VALUES 
	('$job_no', '$job_date', '$quot_id', '$cust_id', '$machine', '$instr', '$loguser', '$datetime')");
	$jid = mysqli_insert_id($con);

	for($i=1; $i<=$num_rows; $i++){
		
		$row_id = mysqli_real_escape_string($con, $_POST['row_id'.$i]);
		$prod_id = mysqli_real_escape_string($con, $_POST['prod_id'.$i]);
		$qty = mysqli_real_escape_string($con, $_POST['qty'.$i]);

		$insert2 = mysqli_query($con, "INSERT INTO `jobcard_details`
		(`jobcard_id`, `prod_id`, `qty`, `qitm_id`) VALUES 
		('$jid', '$prod_id', '$qty', '$row_id')");
		
	}
	
	for($j=1; $j<=$mat_num_rows; $j++){
		
		$item = mysqli_real_escape_string($con, $_POST['item'.$j]);
		$itemid = mysqli_real_escape_string($con, $_POST['itemid'.$j]);
		$iqty = mysqli_real_escape_string($con, $_POST['iqty'.$j]);

		$insert3 = mysqli_query($con, "INSERT INTO `jobcard_material`
		(`jobcard_id`, `item_id`, `qty`) VALUES 
		('$jid', '$itemid', '$iqty')");
		
	}

	$update = mysqli_query($con, "UPDATE quotation SET jobcard = 'yes' WHERE id = '$quot_id'");



$_SESSION['success'] = "Jobcard created successfully. Your job number is ".$job_no;
?>
<script>
	setTimeout('location.href = "job_plan.php"', 0);
</script>
<?php } ?>