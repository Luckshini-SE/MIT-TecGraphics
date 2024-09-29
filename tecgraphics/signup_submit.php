<?php
session_start();
include('db_connection.php');

//Set time zone
$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
$tadetime = $createToday->format('Y-m-d H:i:s');

$ctype = mysqli_real_escape_string($con,$_POST['ctype']);
$qid = mysqli_real_escape_string($con,$_POST['quot']);

if($ctype == 'ind'){
	$custype = 'i';
	$fname = mysqli_real_escape_string($con,$_POST['fname']);
	$lname = mysqli_real_escape_string($con,$_POST['lname']);
	$title = "6";
	$mobile = mysqli_real_escape_string($con,$_POST['telephone']);
	$phone = '';
} else {
	$custype = 'c';
	$fname = mysqli_real_escape_string($con,$_POST['company']);
	$lname = "";
	$title = "6";
	$phone = mysqli_real_escape_string($con,$_POST['telephone']);	
	$mobile = '';
}

$email = mysqli_real_escape_string($con,$_POST['email']);
$password = mysqli_real_escape_string($con,$_POST['password']);

$new_password = md5($password);

$select_user = mysqli_query($con, "SELECT * FROM customer WHERE email = '$email' AND active = 'yes'");
$result_user = mysqli_fetch_array($select_user);

if(mysqli_num_rows($select_user) > 0){			//if there are matching records

//echo 'Login already exist.';
$_SESSION['error'] = "Login already exist.";
?>
<script>
	setTimeout('location.href = "signup.php?ref=<?php echo $qid; ?>"',0);
</script>
<?php
} else {		//if there are no matching records

$insert_user = mysqli_query($con, "INSERT INTO customer (ctype, title, name, last_name, phone, mobile, email, password, reg_date) VALUES ('$custype','$title','$fname','$lname','$phone','$mobile','$email','$new_password','$tadetime')");
$cid = mysqli_insert_id($con);

$_SESSION["customerId"]	= $cid;
$_SESSION["customerName"]	= $fname;

if($qid != ''){
?>
<script>
	setTimeout('location.href = "confirm_quote.php?ref=<?php echo $qid; ?>"',0);
</script>
<?php
} else {
?>
<script>
	setTimeout('location.href = "index.php"',0);
</script>
<?php
}
}
?>