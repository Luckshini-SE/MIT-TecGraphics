<?php
session_start();
$loguser = $_SESSION["logUserId"];

if($loguser == ''){		//check if user is logged in
	header('Location: login.php');
} else {

include('db_connection.php');

$usertype = mysqli_real_escape_string($con, $_POST['usertype']);
$num = mysqli_real_escape_string($con, $_POST['num']);

for($i=1; $i <= $num; $i++){

	$pageid = mysqli_real_escape_string($con, $_POST['pageid'.$i]);

	$select_row = mysqli_query($con, "SELECT * FROM user_privilege WHERE user_type = '$usertype' AND page = '$pageid'");

	if(isset($_POST['enable'.$i])){		//if checked

		if(mysqli_num_rows($select_row) > 0){	//if recored already exist

		} else {
			mysqli_query($con, "INSERT INTO user_privilege (user_type, page) VALUES ('$usertype', '$pageid')");
		}
	} else {							//if unchecked
			
		if(mysqli_num_rows($select_row) > 0){	//if recored already exist
			mysqli_query($con, "DELETE FROM user_privilege WHERE user_type = '$usertype' AND page = '$pageid'");
		} else {
			
		}
	}

}

$_SESSION['success'] = "Privileges added successfully.";
?>
<script>
	setTimeout('location.href = "user_privileges.php"', 0);
</script>
<?php } ?>