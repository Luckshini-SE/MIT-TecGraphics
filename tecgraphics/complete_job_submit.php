<?php
session_start();
$loguser = $_SESSION["logUserId"];

if($loguser == ''){		//check if user is logged in
	header('Location: login.php');
} else {

include('db_connection.php');

$num_rows = mysqli_real_escape_string($con, $_POST['num_rows']);

	for($i=1; $i<=$num_rows; $i++){
		if(isset($_POST['select'.$i])){
			$job_id = mysqli_real_escape_string($con, $_POST['job_id'.$i]);
			$com_qty = mysqli_real_escape_string($con, $_POST['com_qty'.$i]);

			$select_qty = mysqli_query($con, "SELECT completed_qty FROM jobcard_details WHERE id = '$job_id'");
			$result_qty = mysqli_fetch_array($select_qty);
				$curr_qty = $result_qty['completed_qty'];

			$new_qty = $curr_qty+$com_qty;

			$insert = mysqli_query($con, "UPDATE jobcard_details SET completed_qty = '$new_qty' WHERE id = '$job_id'");
		}
	}
	
$_SESSION['success'] = "Complete quantity updated.";
?>
<script>
	setTimeout('location.href = "complete_job.php"', 0);
</script>
<?php
}

?>