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

$select_max = mysqli_query($con, "SELECT issue_no FROM `issue_summary` ORDER BY id DESC");
if(mysqli_num_rows($select_max) > 0){
	$result_max = mysqli_fetch_array($select_max);
		$temp = substr($result_max['issue_no'], 2);
		$max = $temp+1;
		$issue_no = 'MI'.$max;
} else {
	$issue_no = 'MI10001';
}

$issue_date = mysqli_real_escape_string($con, $_POST['issue_date']);
$job_no = mysqli_real_escape_string($con, $_POST['job_no']);
$issue_to = mysqli_real_escape_string($con, $_POST['issue_to']);
$num_rows = mysqli_real_escape_string($con, $_POST['num_rows']);

$insert = mysqli_query($con, "INSERT INTO `issue_summary`
(`issue_no`, `issue_date`, `jobno`, `issued_to`, `user`, `datetime`) VALUES 
('$issue_no', '$issue_date', '$job_no', '$issue_to', '$loguser', '$cur_date')");

for($i=1; $i<=$num_rows; $i++){
	
	$itemid = mysqli_real_escape_string($con, $_POST['itemid'.$i]);
	$qty = mysqli_real_escape_string($con, $_POST['qty'.$i]);

	//insert detail and update stock
	$select = mysqli_query($con, "SELECT id, available_qty FROM grn_stock WHERE item_id = '$itemid' AND available_qty > 0");
	while($result = mysqli_fetch_array($select)){
		$grn_qty = $result['available_qty'];
		$grn_id = $result['id'];

		if($grn_qty >= $qty){

			$new_grn_qty = $grn_qty-$qty;

			$insert2 = mysqli_query($con, "INSERT INTO `issue_details` 
			(`issue_no`, `item_id`, `qty`, `stock_id`) VALUES ('$issue_no', '$itemid', '$qty', '$grn_id')");

			$update = mysqli_query($con, "UPDATE grn_stock SET available_qty = '$new_grn_qty' WHERE id = '$grn_id'");

			break;
		} else if($grn_qty < $qty) {
			if($grn_qty != 0){

				$new_qty = $qty-$grn_qty;
				$new_grn_qty = 0;
				
			$insert2 = mysqli_query($con, "INSERT INTO `issue_details` 
			(`issue_no`, `item_id`, `qty`, `stock_id`) VALUES ('$issue_no', '$itemid', '$grn_qty', '$grn_id')");

			$update = mysqli_query($con, "UPDATE grn_stock SET available_qty = '$new_grn_qty' WHERE id = '$grn_id'");

			$qty = $new_qty;

			}

		}

	}
}

$_SESSION['success'] = "Issue note created successfully.";
?>
<script>
	setTimeout('location.href = "issue_rawmat.php"', 0);
</script>
<?php } ?>