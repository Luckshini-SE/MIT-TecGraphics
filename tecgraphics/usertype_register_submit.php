<?php
session_start();
$loguser = $_SESSION["logUserId"];

if($loguser == ''){		//check if user is logged in
	header('Location: login.php');
} else {

include('db_connection.php');

$utype = mysqli_real_escape_string($con, $_POST['utype']);
$uid = mysqli_real_escape_string($con, $_POST['utid']);

if($uid == ''){		//new record

$select = mysqli_query($con, "SELECT * FROM user_type WHERE name = '$utype'");

if(mysqli_num_rows($select) > 0){		//duplicate entry
$_SESSION['error'] = "User type already exists.";
?>
<script>
	setTimeout('location.href = "usertype_register.php"', 0);
</script>
<?php
} else {		//not duplicate

$insert = mysqli_query($con, "INSERT INTO `user_type` (`name`) VALUES ('$utype')");

$_SESSION['success'] = "User type created successfully.";
?>
<script>
	setTimeout('location.href = "usertype_register.php"', 0);
</script>
<?php 
}		//end - duplicate check
} else {		//edit record

$select = mysqli_query($con, "SELECT * FROM user_type WHERE name = '$utype' AND id != '$uid'");

if(mysqli_num_rows($select) > 0){		//duplicate entry
$_SESSION['error'] = "User type name already exists.";
?>
<script>
	setTimeout('location.href = "usertype_register.php"', 0);
</script>
<?php
} else {		//not duplicate

$update = mysqli_query($con, "UPDATE `user_type` SET `name` = '$utype' WHERE id = '$uid'");

$_SESSION['success'] = "User type updated successfully.";
?>
<script>
	setTimeout('location.href = "usertype_register.php"', 0);
</script>
<?php
}		//end - duplicate check
}
} 
?>