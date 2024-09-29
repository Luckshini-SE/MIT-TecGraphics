<?php
session_start();
$loguser = $_SESSION["logUserId"];

if($loguser == ''){		//check if user is logged in
	header('Location: login.php');
} else {

include('db_connection.php');

$mname = mysqli_real_escape_string($con, $_POST['mname']);
$mid = mysqli_real_escape_string($con, $_POST['mid']);

if($mid == ''){		//new record

$select = mysqli_query($con, "SELECT * FROM machine WHERE name = '$mname'");

if(mysqli_num_rows($select) > 0){		//duplicate entry
$_SESSION['error'] = "Machine name already exists.";
?>
<script>
	setTimeout('location.href = "machine_register.php"', 0);
</script>
<?php
} else {		//not duplicate

$insert = mysqli_query($con, "INSERT INTO `machine` (`name`) VALUES ('$mname')");

$_SESSION['success'] = "Machine created successfully.";
?>
<script>
	setTimeout('location.href = "machine_register.php"', 0);
</script>
<?php 
}		//end - duplicate check
} else {		//edit record

$select = mysqli_query($con, "SELECT * FROM machine WHERE name = '$mname' AND id != '$mid'");

if(mysqli_num_rows($select) > 0){		//duplicate entry
$_SESSION['error'] = "Machine name already exists.";
?>
<script>
	setTimeout('location.href = "machine_register.php"', 0);
</script>
<?php
} else {		//not duplicate

$update = mysqli_query($con, "UPDATE `machine` SET `name` = '$mname' WHERE id = '$mid'");

$_SESSION['success'] = "Machine updated successfully.";
?>
<script>
	setTimeout('location.href = "machine_register.php"', 0);
</script>
<?php
}		//end - duplicate check
}
} 
?>