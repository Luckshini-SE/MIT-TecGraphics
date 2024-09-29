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

$select_max = mysqli_query($con, "SELECT v_no FROM `payment_voucher` ORDER BY id DESC");
if(mysqli_num_rows($select_max) > 0){
	$result_max = mysqli_fetch_array($select_max);
		$temp = substr($result_max['v_no'], 2);
		$max = $temp+1;
		$payv_num = 'PV'.$max;
} else {
	$payv_num = 'PV10001';
}

$payv_date = mysqli_real_escape_string($con, $_POST['payv_date']);
$supplier = mysqli_real_escape_string($con, $_POST['supplier']);
$num_rows = mysqli_real_escape_string($con, $_POST['num_rows']);
$total = mysqli_real_escape_string($con, $_POST['total']);
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

$insert = mysqli_query($con, "INSERT INTO `payment_voucher`
(`v_no`, `v_date`, `supplier`, `amount`, `paytype`, `cheq_no`, `cheq_date`, `deposit_ref`, `user`, `datetime`) VALUES 
('$payv_num', '$payv_date', '$supplier', '$total', '$paytype', '$cheqno', '$cheqdate', '$depref', '$loguser', '$cur_date')");

for($i=1; $i<=$num_rows; $i++){
	if(isset($_POST['select'.$i])){

	$rowid = mysqli_real_escape_string($con, $_POST['rowid'.$i]);
	$pay_amt = mysqli_real_escape_string($con, $_POST['pay_amt'.$i]);

	//insert detail and update balance
	$select = mysqli_query($con, "SELECT grn_no, balance FROM grn_summary WHERE id = '$rowid'");
	while($result = mysqli_fetch_array($select)){
		$grn_no = $result['grn_no'];
		$balance = $result['balance'];
		$new_balance = number_format($balance - $pay_amt, 2, '.', '');

		if($new_balance > 0){
			$pstatus = 'no';
		} else {
			$pstatus = 'yes';
		}

			$insert2 = mysqli_query($con, "INSERT INTO `payment_voucher_detail` (`v_no`, `grn_no`, `amount`) VALUES ('$payv_num', '$grn_no', '$pay_amt')");

			$update = mysqli_query($con, "UPDATE grn_summary SET balance = '$new_balance', pay_status = '$pstatus' WHERE id = '$rowid'");

	}

	}
}

$_SESSION['success'] = "Payment voucher created successfully.";
?>
<script>
	setTimeout('location.href = "pay_voucher.php"', 0);
</script>
<?php } ?>