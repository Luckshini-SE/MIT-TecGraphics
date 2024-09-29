<?php
session_start();
$loguser = $_SESSION["logUserId"];

if($loguser == ''){		//check if user is logged in
	header('Location: login.php');
} else {

include('db_connection.php');

$inv_id = mysqli_real_escape_string($con, $_POST['inv_id']);

$select = mysqli_query($con, "SELECT total, pay_balance FROM invoice WHERE id = '$inv_id'");
$result = mysqli_fetch_array($select);

if($result['total'] != $result['pay_balance']){		//if payment received
$_SESSION['error'] = "Cannot cancel invoice as peyments received.";
?>
<script>
	setTimeout('location.href = "direct_invoice_list.php"', 0);
</script>
<?php
} else {		//if there are no payments

$update = mysqli_query($con, "UPDATE `invoice` SET cancel = 'yes' WHERE id = '$inv_id'");

$_SESSION['success'] = "Invoice cancelled successfully.";
?>
<script>
	setTimeout('location.href = "direct_invoice_list.php"', 0);
</script>
<?php 
}		//end - duplicate check

} 
?>