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

$select_max = mysqli_query($con, "SELECT rec_no FROM `receipt` ORDER BY id DESC");
if(mysqli_num_rows($select_max) > 0){
	$result_max = mysqli_fetch_array($select_max);
		$temp = substr($result_max['rec_no'], 2);
		$max = $temp+1;
		$receipt_no = 'RN'.$max;
} else {
	$receipt_no = 'RN10001';
}

$receipt_date = mysqli_real_escape_string($con, $_POST['receipt_date']);
$customer = mysqli_real_escape_string($con, $_POST['customer']);
$total_pay = mysqli_real_escape_string($con, $_POST['total_pay']);
$paytype = mysqli_real_escape_string($con, $_POST['paytype']);
$num_rows = mysqli_real_escape_string($con, $_POST['num_rows']);

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

$insert = mysqli_query($con, "INSERT INTO `receipt`
(`rec_no`, `rec_date`, `customer`, `amount`, `pay_type`, `user`, `datetime`, `cheq_no`, `cheq_date`, `deposit_ref`) VALUES 
('$receipt_no', '$receipt_date', '$customer', '$total_pay', '$paytype', '$loguser', '$cur_date', '$cheqno', '$cheqdate', '$depref')");

for($i=1; $i<=$num_rows; $i++){
	if(isset($_POST['select'.$i])){

	$rowid = mysqli_real_escape_string($con, $_POST['inv_id'.$i]);
	$pay_amt = mysqli_real_escape_string($con, $_POST['pay_amt'.$i]);

	//insert detail and update balance
	$select = mysqli_query($con, "SELECT invoice_no, pay_balance FROM invoice WHERE id = '$rowid'");
	while($result = mysqli_fetch_array($select)){
		$inv_no = $result['invoice_no'];
		$balance = $result['pay_balance'];
		$new_balance = number_format($balance - $pay_amt, 2, '.', '');

		if($new_balance > 0){
			$pstatus = 'pending';
		} else {
			$pstatus = 'yes';
		}

			$insert2 = mysqli_query($con, "INSERT INTO `receipt_details` (`rec_no`, `inv_no`, `amount`) VALUES ('$receipt_no', '$inv_no', '$pay_amt')");

			$update = mysqli_query($con, "UPDATE invoice SET pay_balance = '$new_balance', paystatus = '$pstatus' WHERE id = '$rowid'");

	}

	}
}

if($paytype == 'Settlement'){

	$adv_rows = mysqli_real_escape_string($con, $_POST['num_adv_rows']);

	for($j=1; $j<=$adv_rows; $j++){
		if(isset($_POST['select_adv'.$j])){

			$arowid = mysqli_real_escape_string($con, $_POST['adv_id'.$j]);
			$adv_pay = mysqli_real_escape_string($con, $_POST['adv_pay'.$j]);

			//insert detail and update balance
			$aselect = mysqli_query($con, "SELECT rec_no, balance FROM advance_payment WHERE id = '$arowid'");
			while($aresult = mysqli_fetch_array($aselect)){
				$advr_no = $aresult['rec_no'];
				$advbalance = $aresult['balance'];
				$new_abalance = number_format($advbalance - $adv_pay, 2, '.', '');

				if($new_abalance > 0){
					$apstatus = 'pending';
				} else {
					$apstatus = 'yes';
				}

					$insert3 = mysqli_query($con, "INSERT INTO `advance_settlement` (`rec_no`, `advance_pay_no`, `amount`) VALUES ('$receipt_no', '$advr_no', '$adv_pay')");

					$update2 = mysqli_query($con, "UPDATE advance_payment SET balance = '$new_abalance', status = '$apstatus' WHERE id = '$arowid'");

			}

		}
	}

}


$_SESSION['success'] = "Receipt added successfully.";
?>
<script>
	setTimeout('location.href = "receipt.php"', 0);
</script>
<?php } ?>