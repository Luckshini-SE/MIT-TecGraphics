<?php
session_start();
$loguser = $_SESSION["logUserId"];

if($loguser == ''){		//check if user is logged in
	header('Location: login.php');
} else {

include('db_connection.php');

$utitle = mysqli_real_escape_string($con, $_POST['utitle']);
$fname = mysqli_real_escape_string($con, $_POST['fname']);
$lname = mysqli_real_escape_string($con, $_POST['lname']);
$mobile = mysqli_real_escape_string($con, $_POST['mobile']);
$designation = mysqli_real_escape_string($con, $_POST['designation']);
$utype = mysqli_real_escape_string($con, $_POST['utype']);
$uname = mysqli_real_escape_string($con, $_POST['uname']);
$uid = mysqli_real_escape_string($con, $_POST['uid']);

if($uid == ''){		//new record

$password = mysqli_real_escape_string($con, $_POST['password']);
$new_password = md5($password);

$insert = mysqli_query($con, "INSERT INTO `users`
(`title`, `first_name`, `last_name`, `contact`, `designation`, `user_type`, `username`, `password`, `active`) VALUES 
('$utitle', '$fname', '$lname', '$mobile', '$designation', '$utype', '$uname', '$new_password', 'yes')");
$iId = mysqli_insert_id($con);

//Upload image 
if ($_FILES['profile']['name'] == '') {
} else {	
	$filename1 = $_FILES['profile']['name'];
	$extension1 = end(explode(".", $filename1));		// Find Image Extension
    $newfilename1 = $iId."_profile.".$extension1;			// Rename Image
			
	if (file_exists("img/avatars/".$newfilename1)) {
		echo "";
	} else {
		move_uploaded_file($_FILES["profile"]["tmp_name"],"img/avatars/".$newfilename1);
	}
	$insert2 = mysqli_query($con, "UPDATE `users` SET `profile_pic` = '$newfilename1' WHERE id = '$iId'");
}

$_SESSION['success'] = "User created successfully.";
?>
<script>
	setTimeout('location.href = "user_register.php"', 0);
</script>
<?php 
} else {		//edit record

$ustatus = $_POST['ustatus'];

$update = mysqli_query($con, "UPDATE `users` SET `title`='$utitle', `first_name`='$fname', `last_name`='$lname', `contact`='$mobile', `designation`='$designation', `user_type`='$utype', `username`='$uname', `active`='$ustatus' WHERE id = '$uid'");

//Upload image 
if ($_FILES['profile']['name'] == '') {
} else {	
	$filename1 = $_FILES['profile']['name'];
	$extension1 = end(explode(".", $filename1));		// Find Image Extension
    $newfilename1 = $uid."_profile.".$extension1;			// Rename Image
			
	if (file_exists("img/avatars/".$newfilename1)) {
		unlink("img/avatars/".$newfilename1);
		move_uploaded_file($_FILES["profile"]["tmp_name"],"img/avatars/".$newfilename1);
	} else {
		move_uploaded_file($_FILES["profile"]["tmp_name"],"img/avatars/".$newfilename1);
	}
	$insert2 = mysqli_query($con, "UPDATE `users` SET `profile_pic` = '$newfilename1' WHERE id = '$uid'");
}

$_SESSION['success'] = "User updated successfully.";
?>
<script>
	setTimeout('location.href = "user_list.php"', 0);
</script>
<?php 
}
}
?>