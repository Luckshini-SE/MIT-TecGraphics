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

$select_max = mysqli_query($con, "SELECT return_no FROM `return_summary` ORDER BY id DESC");
if(mysqli_num_rows($select_max) > 0){
	$result_max = mysqli_fetch_array($select_max);
		$temp = substr($result_max['return_no'], 2);
		$max = $temp+1;
		$return_no = 'MR'.$max;
} else {
	$return_no = 'MR10001';
}

$return_date = mysqli_real_escape_string($con, $_POST['return_date']);
$issue_no = mysqli_real_escape_string($con, $_POST['issue_no']);
$num_rows = mysqli_real_escape_string($con, $_POST['num_rows']);

$insert = mysqli_query($con, "INSERT INTO `return_summary`
(`return_no`, `return_date`, `issue_no`, `user`, `datetime`) VALUES 
('$return_no', '$return_date', '$issue_no', '$loguser', '$cur_date')");

for($i=1; $i<=$num_rows; $i++){
	if(isset($_POST['select'.$i])){

	$itemid = mysqli_real_escape_string($con, $_POST['itemid'.$i]);
	$rowid = mysqli_real_escape_string($con, $_POST['rowid'.$i]);
	$qty = mysqli_real_escape_string($con, $_POST['qty'.$i]);

	//insert detail and update stock
	$select = mysqli_query($con, "SELECT return_qty, stock_id FROM issue_details WHERE id = '$rowid'");
	while($result = mysqli_fetch_array($select)){
		$return_qty = $result['return_qty'];
		$stock_id = $result['stock_id'];
		$new_ret_qty = $return_qty+$qty;

		$select2 = mysqli_query($con, "SELECT available_qty FROM grn_stock WHERE id = '$stock_id'");
		$result2 = mysqli_fetch_array($select2);
			$ava_qty = $result2['available_qty'];
			$new_ava_qty = $ava_qty+$qty;

			$insert2 = mysqli_query($con, "INSERT INTO `return_details` (`return_no`, `item_id`, `qty`) VALUES ('$return_no', '$itemid', '$qty')");

			$update = mysqli_query($con, "UPDATE issue_details SET return_qty = '$new_ret_qty' WHERE id = '$rowid'");

			$update2 = mysqli_query($con, "UPDATE grn_stock SET available_qty = '$new_ava_qty' WHERE id = '$stock_id'");

	}

	}
}

$_SESSION['success'] = "Return note created successfully.";
?>
<script>
	setTimeout('location.href = "return_rawmat.php"', 0);
</script>
<?php } ?>