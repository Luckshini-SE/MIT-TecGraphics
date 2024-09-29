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

$select_max = mysqli_query($con, "SELECT grn_no FROM `grn_summary` ORDER BY id DESC");
if(mysqli_num_rows($select_max) > 0){
$result_max = mysqli_fetch_array($select_max);
	$temp = substr($result_max['grn_no'], 3);
	$max = $temp+1;
	$grn_no = 'GRN'.$max;
} else {
	$grn_no = 'GRN10001';
}

$grn_date = mysqli_real_escape_string($con, $_POST['grn_date']);
$supplier = mysqli_real_escape_string($con, $_POST['supplier']);
$num_rows = mysqli_real_escape_string($con, $_POST['num_rows']);
$total = mysqli_real_escape_string($con, $_POST['total']);
$invno = mysqli_real_escape_string($con, $_POST['invno']);
$pono = mysqli_real_escape_string($con, $_POST['pono']);

$insert = mysqli_query($con, "INSERT INTO `grn_summary`
(`grn_no`, `grn_date`, `po_no`, `supplier`, `total`, `balance`, `pay_status`, `invoice_no`, `user`, `logdatetime`) VALUES 
('$grn_no', '$grn_date', '$pono', '$supplier', '$total', '$total', 'no', '$invno', '$loguser', '$cur_date')");

for($i=1; $i<=$num_rows; $i++){
	if(isset($_POST['select'.$i])){
	
	$rowid = mysqli_real_escape_string($con, $_POST['rowid'.$i]);
	$itemid = mysqli_real_escape_string($con, $_POST['itemid'.$i]);
	$rate = mysqli_real_escape_string($con, $_POST['rate'.$i]);
	$qty = mysqli_real_escape_string($con, $_POST['qty'.$i]);
	$amount = mysqli_real_escape_string($con, $_POST['amount'.$i]);

	$insert2 = mysqli_query($con, "INSERT INTO `grn_stock`
	(`grn_no`, `item_id`, `uprice`, `grn_qty`, `amount`, `available_qty`) VALUES 
	('$grn_no', '$itemid', '$rate', '$qty', '$amount', '0')");

	//update purchased qty of PO
	$select = mysqli_query($con, "SELECT grn_qty FROM purchase_order_detail WHERE id = '$rowid'");
	$result = mysqli_fetch_array($select);
		$cur_qty = $result['grn_qty'];

		if($cur_qty > $qty){
			$rem_qty = $cur_qty-$qty;
		} else {
			$rem_qty = 0;
		}

		$update = mysqli_query($con, "UPDATE purchase_order_detail SET grn_qty = '$rem_qty' WHERE id = '$rowid'");

	}
}

//update status of purchase order
$select2 = mysqli_query($con, "SELECT * FROM purchase_order_detail WHERE po_no = '$pono' AND grn_qty > 0");

if(mysqli_num_rows($select2) == 0){
	$update2 = mysqli_query($con, "UPDATE purchase_order_summary SET grn = 'yes' WHERE po_no = '$pono'");
}

$_SESSION['success'] = "GRN created successfully.";
?>
<script>
	setTimeout('location.href = "goods_received.php"', 0);
</script>
<?php } ?>