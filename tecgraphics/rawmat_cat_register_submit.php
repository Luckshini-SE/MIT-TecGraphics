<?php
session_start();
$loguser = $_SESSION["logUserId"];

if($loguser == ''){		//check if user is logged in
	header('Location: login.php');
} else {

include('db_connection.php');

$cname = mysqli_real_escape_string($con, $_POST['cname']);
$cid = mysqli_real_escape_string($con, $_POST['cid']);

if($cid == ''){		//new record

$select = mysqli_query($con, "SELECT * FROM rawmaterial_category WHERE name = '$cname'");

if(mysqli_num_rows($select) > 0){		//duplicate entry
$_SESSION['error'] = "Category name already exists.";
?>
<script>
	setTimeout('location.href = "rawmat_cat_register.php"', 0);
</script>
<?php
} else {		//not duplicate

$insert = mysqli_query($con, "INSERT INTO `rawmaterial_category` (`name`) VALUES ('$cname')");

$_SESSION['success'] = "Category created successfully.";
?>
<script>
	setTimeout('location.href = "rawmat_cat_register.php"', 0);
</script>
<?php 
}		//end - duplicate check
} else {		//edit record

$select = mysqli_query($con, "SELECT * FROM rawmaterial_category WHERE name = '$cname' AND id != '$cid'");

if(mysqli_num_rows($select) > 0){		//duplicate entry
$_SESSION['error'] = "Category name already exists.";
?>
<script>
	setTimeout('location.href = "rawmat_cat_register.php"', 0);
</script>
<?php
} else {		//not duplicate

$update = mysqli_query($con, "UPDATE `rawmaterial_category` SET `name` = '$cname' WHERE id = '$cid'");

$_SESSION['success'] = "Category updated successfully.";
?>
<script>
	setTimeout('location.href = "rawmat_cat_register.php"', 0);
</script>
<?php
}		//end - duplicate check
}
} 
?>