<?php
session_start();

include('db_connection.php');

if($_SESSION["req"] == ''){

//Set time zone
$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
$tadetime = $createToday->format('Y-m-d H:i:s');
$yearmon = $createToday->format('ym');
$year = $createToday->format('Y');

$select_max = mysqli_query($con, "SELECT req_no FROM `quotation_requests` WHERE r_datetime LIKE '$year%' ORDER BY id DESC");

if(mysqli_num_rows($select_max) > 0){
	$result_max = mysqli_fetch_array($select_max);
		$temp = explode("/", $result_max['req_no']);
		$max = $temp[2];
		$temp2 = str_pad($max+1,5,"0",STR_PAD_LEFT);
		$req_no = 'R/'.$yearmon.'/'.$temp2;

} else {
	$req_no = 'R/'.$yearmon.'/00001';
}

$_SESSION["req"] = $req_no;

//Form variables
$ctype = mysqli_real_escape_string($con, $_POST['ctype']);
$cus_id = mysqli_real_escape_string($con, $_POST['cusid']);
$fname = mysqli_real_escape_string($con, $_POST['fname']);
if($ctype == 'i'){
	$title = mysqli_real_escape_string($con, $_POST['title']);
	$lname = mysqli_real_escape_string($con, $_POST['lname']);
	$mobile = mysqli_real_escape_string($con, $_POST['phone']);
} else {
	$phone = mysqli_real_escape_string($con, $_POST['phone']);
}
$email = mysqli_real_escape_string($con, $_POST['email']);

//Update customer details
if($ctype == 'i'){
$update1 = mysqli_query($con, "UPDATE customer SET title = '$title', name = '$fname', last_name = '$lname', mobile = '$mobile' WHERE id = '$cus_id'");
} else {
$update1 = mysqli_query($con, "UPDATE customer SET name = '$fname', phone = '$phone' WHERE id = '$cus_id'");
}
//Insert to database
$insert1 = mysqli_query($con, "INSERT INTO `quotation_requests`
	(`req_no`, `r_datetime`, `cus_id`) VALUES  ('$req_no', '$tadetime', '$cus_id')");
$iId = mysqli_insert_id($con);

//update request
$update2 = mysqli_query($con, "UPDATE requests SET status = 'quote', req_id = '$iId' WHERE cust_id = '$cus_id' AND status = 'open'");

if($insert1){		//success
?>
<script>
	setTimeout('window.location="get_quotation.php?res=y&ref=<?php echo $iId; ?>"',0);
</script>
<?php
} else {			//fail
?>
<script>
	setTimeout('window.location="get_quotation.php?res=n"',0);
</script>
<?php
}

} else {			//duplicate
?>
<script>
	setTimeout('window.location="get_quotation.php"',0);
</script>
<?php } ?>