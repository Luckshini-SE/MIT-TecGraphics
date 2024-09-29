<?php
session_start();
$loguser = $_SESSION["logUserId"];

if($loguser == ''){		//check if user is logged in
	header('Location: login.php');
} else {

include('db_connection.php');

$num_pro = $_POST['num_pro'];

for($i=1; $i<=$num_pro; $i++){
	$proid = $_POST['proid_'.$i];
	$uprice = mysqli_real_escape_string($con, $_POST['uprice_'.$i]);
	
	$insert1 = mysqli_query($con, "UPDATE products SET uprice = '$uprice' WHERE id = '$proid'");

	$num_finish = mysqli_real_escape_string($con, $_POST['num_finish_'.$i]);

	for($j=1; $j<=$num_finish; $j++){
		$finish = mysqli_real_escape_string($con, $_POST['finish_'.$i.'_'.$j]);
		$finishid = mysqli_real_escape_string($con, $_POST['finishid_'.$i.'_'.$j]);

		$insert2 = mysqli_query($con, "UPDATE pro_finishing SET uprice = '$finish' WHERE id = '$finishid'");
	}

	$num_speco = mysqli_real_escape_string($con, $_POST['num_speco_'.$i]);

	for($k=1; $k<=$num_speco; $k++){
		$speco = mysqli_real_escape_string($con, $_POST['speco_'.$i.'_'.$k]);
		$specoid = mysqli_real_escape_string($con, $_POST['specoid_'.$i.'_'.$k]);

		$insert3 = mysqli_query($con, "UPDATE pro_spec1 SET uprice = '$speco' WHERE id = '$specoid'");
	}

	$num_spect = mysqli_real_escape_string($con, $_POST['num_spect_'.$i]);

	for($m=1; $m<=$num_spect; $m++){
		$spect = mysqli_real_escape_string($con, $_POST['spect_'.$i.'_'.$m]);
		$spectid = mysqli_real_escape_string($con, $_POST['spectid_'.$i.'_'.$m]);

		$insert4 = mysqli_query($con, "UPDATE pro_spec2 SET uprice = '$spect' WHERE id = '$spectid'");
	}
}

$_SESSION['success'] = "Price updated successfully.";
?>
<script>
	setTimeout('location.href = "price_management.php"', 0);
</script>
<?php
}

?>