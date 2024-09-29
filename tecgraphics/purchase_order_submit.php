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

$select_max = mysqli_query($con, "SELECT po_no FROM `purchase_order_summary` ORDER BY id DESC");
if(mysqli_num_rows($select_max) > 0){
$result_max = mysqli_fetch_array($select_max);
	$temp = substr($result_max['po_no'], 2);
	$max = $temp+1;
	$po_no = 'PO'.$max;
} else {
	$po_no = 'PO10001';
}

$po_date = mysqli_real_escape_string($con, $_POST['po_date']);
$supplier = mysqli_real_escape_string($con, $_POST['supplier']);
$num_rows = mysqli_real_escape_string($con, $_POST['num_rows']);
$total = mysqli_real_escape_string($con, $_POST['total']);
$notes = mysqli_real_escape_string($con, $_POST['notes']);

$insert = mysqli_query($con, "INSERT INTO `purchase_order_summary`
(`po_no`, `po_date`, `supplier`, `total`, `user`, `datetime`, `snote`) VALUES 
('$po_no', '$po_date', '$supplier', '$total', '$loguser', '$cur_date', '$notes')");

for($i=1; $i<=$num_rows; $i++){
	$itemid = mysqli_real_escape_string($con, $_POST['itemid'.$i]);
	$rate = mysqli_real_escape_string($con, $_POST['rate'.$i]);
	$qty = mysqli_real_escape_string($con, $_POST['qty'.$i]);
	$amount = mysqli_real_escape_string($con, $_POST['amount'.$i]);

	$insert2 = mysqli_query($con, "INSERT INTO `purchase_order_detail`
	(`po_no`, `item_id`, `uprice`, `po_qty`, `amount`, `grn_qty`) VALUES 
	('$po_no', '$itemid', '$rate', '$qty', '$amount', '$qty')");
}

$_SESSION['success'] = "Purchase order created successfully.";
?>
<script>
	setTimeout('location.href = "purchase_order.php"', 0);
</script>
<?php } ?>