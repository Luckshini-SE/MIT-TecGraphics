<?php
session_start();
include('db_connection.php');

$username = mysqli_real_escape_string($con,$_POST['email']);
$password = mysqli_real_escape_string($con,$_POST['password']);
$qid = mysqli_real_escape_string($con,$_POST['quot']);

$new_password = md5($password);

$select_user = mysqli_query($con, "SELECT * FROM customer WHERE email = '$username' AND password = '$new_password' AND active = 'yes'");
$result_user = mysqli_fetch_array($select_user);

if(mysqli_num_rows($select_user) <= 0){			//if there are no matching records

//echo 'Invalid login';
$_SESSION['error'] = "Invalid login.";
?>
<script>
	setTimeout('location.href = "signin.php?ref=<?php echo $qid; ?>"',0);
</script>
<?php
} else {		//if there are matching records

$_SESSION["customerId"]	= $result_user['id'];
$_SESSION["customerName"]	= $result_user['name'];

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