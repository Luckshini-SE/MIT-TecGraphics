<?php
session_start();
$loguser = $_SESSION["logUserId"];

if($loguser == ''){		//check if user is logged in
	header('Location: login.php');
} else {

include('db_connection.php');

$pname = mysqli_real_escape_string($con, $_POST['pname']);
$price = mysqli_real_escape_string($con, $_POST['pricing']);
$pid = mysqli_real_escape_string($con, $_POST['pid']);

if(isset($_POST['mat_check'])){
	$mat_check = 1;
} else {
	$mat_check = 0;
}

if(isset($_POST['siz_check'])){
	$siz_check = 1;
} else {
	$siz_check = 0;
}

if(isset($_POST['fin_check'])){
	$fin_check = 1;
} else {
	$fin_check = 0;
}

if(isset($_POST['col_check'])){
	$col_check = 1;
} else {
	$col_check = 0;
}

if(isset($_POST['spo_check'])){
	$spo_check = 1;
} else {
	$spo_check = 0;
}

if(isset($_POST['spt_check'])){
	$spt_check = 1;
} else {
	$spt_check = 0;
}

if($pid == ''){		//new record

$select = mysqli_query($con, "SELECT * FROM products WHERE name = '$pname'");

if(mysqli_num_rows($select) > 0){		//duplicate entry
$_SESSION['error'] = "Product name already exists.";
?>
<script>
	setTimeout('location.href = "product_register.php"', 0);
</script>
<?php
} else {		//not duplicate

$insert = mysqli_query($con, "INSERT INTO `products` (`name`, `material`, `size`, `finishing`, `color`, `spec1`, `spec2`, `pricing`) VALUES 
('$pname', '$mat_check', '$siz_check', '$fin_check', '$col_check', '$spo_check', '$spt_check', '$price')");
$prid = mysqli_insert_id($con);

$valid_formats = array("jpg", "jpeg", "png", "gif", "zip", "bmp", "JPG", "JPEG", "PNG");

//Upload image 1
if ($_FILES['pimg1']['name'] == '') {
} else {	
	$filename1 = $_FILES['pimg1']['name'];
	$extension1 = end(explode(".", $filename1));		// Find Image Extension
    $newfilename1 = $prid."upd1.".$extension1;			// Rename Image

	if(in_array($extension1, $valid_formats) ){			// Check if uploaded is an image
		if (file_exists("assets/img/portfolio/".$newfilename1)) {
			echo "";
		} else {
			move_uploaded_file($_FILES["pimg1"]["tmp_name"],"assets/img/portfolio/".$newfilename1);
			$insert2 = mysqli_query($con, "UPDATE `products` SET `image1` = '$newfilename1' WHERE id = '$prid'");
		}
	}
}

//Upload image 2
if ($_FILES['pimg2']['name'] == '') {
} else {	
	$filename2 = $_FILES['pimg2']['name'];
	$extension2 = end(explode(".", $filename2));		// Find Image Extension
    $newfilename2 = $prid."upd2.".$extension2;			// Rename Image
	
	if(in_array($extension2, $valid_formats) ){			// Check if uploaded is an image
		if (file_exists("assets/img/portfolio/".$newfilename2)) {
			echo "";
		} else {
			move_uploaded_file($_FILES["pimg2"]["tmp_name"],"assets/img/portfolio/".$newfilename2);
			$insert3 = mysqli_query($con, "UPDATE `products` SET `image2` = '$newfilename2' WHERE id = '$prid'");
		}
	}
}

//Upload image 3
if ($_FILES['pimg3']['name'] == '') {
} else {	
	$filename3 = $_FILES['pimg3']['name'];
	$extension3 = end(explode(".", $filename3));		// Find Image Extension
    $newfilename3 = $prid."upd3.".$extension3;			// Rename Image
			
	if(in_array($extension3, $valid_formats) ){			// Check if uploaded is an image
		if (file_exists("assets/img/portfolio/".$newfilename3)) {
			echo "";
		} else {
			move_uploaded_file($_FILES["pimg3"]["tmp_name"],"assets/img/portfolio/".$newfilename3);
			$insert4 = mysqli_query($con, "UPDATE `products` SET `image3` = '$newfilename3' WHERE id = '$prid'");
		}
	}
}

if($mat_check == 1){
	$mat_num_rows = mysqli_real_escape_string($con, $_POST['mat_num_rows']);

	for($i=1; $i<=$mat_num_rows; $i++){
		$mat_name = mysqli_real_escape_string($con, $_POST['mat_name'.$i]);

		$insert_mat = mysqli_query($con, "INSERT INTO `pro_material` (`prod_id`, `name`) VALUES ('$prid', '$mat_name')");
	}
}

if($siz_check == 1){
	$siz_num_rows = mysqli_real_escape_string($con, $_POST['siz_num_rows']);

	for($i=1; $i<=$siz_num_rows; $i++){
		$siz_name = htmlentities(mysqli_real_escape_string($con, $_POST['siz_name'.$i]));

		$insert_siz = mysqli_query($con, "INSERT INTO `pro_size` (`prod_id`, `name`) VALUES ('$prid', '$siz_name')");
	}
}

if($fin_check == 1){
	$fin_num_rows = mysqli_real_escape_string($con, $_POST['fin_num_rows']);

	for($i=1; $i<=$fin_num_rows; $i++){
		$fin_name = mysqli_real_escape_string($con, $_POST['fin_name'.$i]);

		$insert_fin = mysqli_query($con, "INSERT INTO `pro_finishing` (`prod_id`, `name`) VALUES ('$prid', '$fin_name')");
	}
}

if($col_check == 1){
	$col_num_rows = mysqli_real_escape_string($con, $_POST['col_num_rows']);

	for($i=1; $i<=$col_num_rows; $i++){
		$col_name = mysqli_real_escape_string($con, $_POST['col_name'.$i]);

		$insert_col = mysqli_query($con, "INSERT INTO `pro_color` (`prod_id`, `name`) VALUES ('$prid', '$col_name')");
	}
}

if($spo_check == 1){
	$spo_num_rows = mysqli_real_escape_string($con, $_POST['spo_num_rows']);

	for($i=1; $i<=$spo_num_rows; $i++){
		$spo_name = mysqli_real_escape_string($con, $_POST['spo_name'.$i]);

		$insert_spo = mysqli_query($con, "INSERT INTO `pro_spec1` (`prod_id`, `name`) VALUES ('$prid', '$spo_name')");
	}
}

if($spt_check == 1){
	$spt_num_rows = mysqli_real_escape_string($con, $_POST['spt_num_rows']);

	for($i=1; $i<=$spt_num_rows; $i++){
		$spt_name = mysqli_real_escape_string($con, $_POST['spt_name'.$i]);

		$insert_spt = mysqli_query($con, "INSERT INTO `pro_spec2` (`prod_id`, `name`) VALUES ('$prid', '$spt_name')");
	}
}

$_SESSION['success'] = "Product created successfully.";
?>
<script>
	setTimeout('location.href = "product_register.php"', 0);
</script>
<?php 
}		//end - duplicate check
} else {		//edit record

$select = mysqli_query($con, "SELECT * FROM products WHERE name = '$pname' AND id != '$pid'");

if(mysqli_num_rows($select) > 0){		//duplicate entry
$_SESSION['error'] = "Product name already exists.";
?>
<script>
	setTimeout('location.href = "product_register.php"', 0);
</script>
<?php
} else {		//not duplicate

$update = mysqli_query($con, "UPDATE `products` SET `name` = '$pname', `material` = '$mat_check', `size` = '$siz_check', `finishing` = '$fin_check', `color` = '$col_check', `spec1` = '$spo_check', `spec2` = '$spt_check', `pricing` = '$price' WHERE id = '$pid'");

$valid_formats = array("jpg", "jpeg", "png", "gif", "zip", "bmp", "JPG", "JPEG", "PNG");

//Upload image 1
if ($_FILES['pimg1']['name'] == '') {
} else {	
	$filename1 = $_FILES['pimg1']['name'];
	$extension1 = end(explode(".", $filename1));		// Find Image Extension
    $newfilename1 = $pid."upd1.".$extension1;			// Rename Image
	
	if(in_array($extension1, $valid_formats) ){			// Check if uploaded is an image
		if (file_exists("assets/img/portfolio/".$newfilename1)) {	
			unlink("assets/img/portfolio/".$newfilename1);
			move_uploaded_file($_FILES["pimg1"]["tmp_name"],"assets/img/portfolio/".$newfilename1);
		} else {	
			move_uploaded_file($_FILES["pimg1"]["tmp_name"],"assets/img/portfolio/".$newfilename1);
		}
		$insert2 = mysqli_query($con, "UPDATE `products` SET `image1` = '$newfilename1' WHERE id = '$pid'");
	}
}

//Upload image 2
if ($_FILES['pimg2']['name'] == '') {
} else {	
	$filename2 = $_FILES['pimg2']['name'];
	$extension2 = end(explode(".", $filename2));		// Find Image Extension
    $newfilename2 = $pid."upd2.".$extension2;			// Rename Image
		
	if(in_array($extension2, $valid_formats) ){			// Check if uploaded is an image
		if (file_exists("assets/img/portfolio/".$newfilename2)) {
			unlink("assets/img/portfolio/".$newfilename2);
			move_uploaded_file($_FILES["pimg1"]["tmp_name"],"assets/img/portfolio/".$newfilename2);
		} else {
			move_uploaded_file($_FILES["pimg2"]["tmp_name"],"assets/img/portfolio/".$newfilename2);
		}
		$insert3 = mysqli_query($con, "UPDATE `products` SET `image2` = '$newfilename2' WHERE id = '$pid'");
	}
}

//Upload image 3
if ($_FILES['pimg3']['name'] == '') {
} else {	
	$filename3 = $_FILES['pimg3']['name'];
	$extension3 = end(explode(".", $filename3));		// Find Image Extension
    $newfilename3 = $pid."upd3.".$extension3;			// Rename Image
		
	if(in_array($extension3, $valid_formats) ){			// Check if uploaded is an image
		if (file_exists("assets/img/portfolio/".$newfilename3)) {
			unlink("assets/img/portfolio/".$newfilename3);
			move_uploaded_file($_FILES["pimg1"]["tmp_name"],"assets/img/portfolio/".$newfilename3);
		} else {
			move_uploaded_file($_FILES["pimg3"]["tmp_name"],"assets/img/portfolio/".$newfilename3);
		}
		$insert4 = mysqli_query($con, "UPDATE `products` SET `image3` = '$newfilename3' WHERE id = '$pid'");
	}
}

if($mat_check == 1){

	$ex_mat_num_rows = mysqli_real_escape_string($con, $_POST['ex_mat_num_rows']);

	for($h=1; $h<=$ex_mat_num_rows; $h++){
		$ex_mat_name = mysqli_real_escape_string($con, $_POST['ex_mat_name'.$h]);
		$ex_mat_id = mysqli_real_escape_string($con, $_POST['ex_mat_id'.$h]);

		if(isset($_POST['ex_mat_rem'.$h])){
			$delete_mat = mysqli_query($con, "DELETE FROM `pro_material` WHERE id = '$ex_mat_id'");
		} else {
			$update_mat = mysqli_query($con, "UPDATE `pro_material` SET `name` = '$ex_mat_name' WHERE id = '$ex_mat_id'");
		}
	}

	$mat_num_rows = mysqli_real_escape_string($con, $_POST['mat_num_rows']);

	for($i=1; $i<=$mat_num_rows; $i++){
		$mat_name = mysqli_real_escape_string($con, $_POST['mat_name'.$i]);

		if($mat_name != ''){
			$insert_mat = mysqli_query($con, "INSERT INTO `pro_material` (`prod_id`, `name`) VALUES ('$pid', '$mat_name')");
		}
	}
}

if($siz_check == 1){
	
	$ex_siz_num_rows = mysqli_real_escape_string($con, $_POST['ex_siz_num_rows']);

	for($h=1; $h<=$ex_siz_num_rows; $h++){
		$ex_siz_name = htmlentities(mysqli_real_escape_string($con, $_POST['ex_siz_name'.$h]));
		$ex_siz_id = mysqli_real_escape_string($con, $_POST['ex_siz_id'.$h]);

		if(isset($_POST['ex_siz_rem'.$h])){
			$delete_siz = mysqli_query($con, "DELETE FROM `pro_size` WHERE id = '$ex_siz_id'");
		} else {
			$update_siz = mysqli_query($con, "UPDATE `pro_size` SET `name` = '$ex_siz_name' WHERE id = '$ex_siz_id'");
		}
	}

	$siz_num_rows = mysqli_real_escape_string($con, $_POST['siz_num_rows']);

	for($i=1; $i<=$siz_num_rows; $i++){
		$siz_name = mysqli_real_escape_string($con, $_POST['siz_name'.$i]);

		if($siz_name != ''){
			$insert_siz = mysqli_query($con, "INSERT INTO `pro_size` (`prod_id`, `name`) VALUES ('$pid', '$siz_name')");
		}
	}
}

if($fin_check == 1){
	
	$ex_fin_num_rows = mysqli_real_escape_string($con, $_POST['ex_fin_num_rows']);

	for($h=1; $h<=$ex_fin_num_rows; $h++){
		$ex_fin_name = mysqli_real_escape_string($con, $_POST['ex_fin_name'.$h]);
		$ex_fin_id = mysqli_real_escape_string($con, $_POST['ex_fin_id'.$h]);

		if(isset($_POST['ex_fin_rem'.$h])){
			$delete_fin = mysqli_query($con, "DELETE FROM `pro_finishing` WHERE id = '$ex_fin_id'");
		} else {
			$update_fin = mysqli_query($con, "UPDATE `pro_finishing` SET `name` = '$ex_fin_name' WHERE id = '$ex_fin_id'");
		}
	}

	$fin_num_rows = mysqli_real_escape_string($con, $_POST['fin_num_rows']);

	for($i=1; $i<=$fin_num_rows; $i++){
		$fin_name = mysqli_real_escape_string($con, $_POST['fin_name'.$i]);

		if($fin_name != ''){
			$insert_fin = mysqli_query($con, "INSERT INTO `pro_finishing` (`prod_id`, `name`) VALUES ('$pid', '$fin_name')");
		}
	}
}

if($col_check == 1){
	
	$ex_col_num_rows = mysqli_real_escape_string($con, $_POST['ex_col_num_rows']);

	for($h=1; $h<=$ex_col_num_rows; $h++){
		$ex_col_name = mysqli_real_escape_string($con, $_POST['ex_col_name'.$h]);
		$ex_col_id = mysqli_real_escape_string($con, $_POST['ex_col_id'.$h]);

		if(isset($_POST['ex_col_rem'.$h])){
			$delete_col = mysqli_query($con, "DELETE FROM `pro_color` WHERE id = '$ex_col_id'");
		} else {
			$update_col = mysqli_query($con, "UPDATE `pro_color` SET `name` = '$ex_col_name' WHERE id = '$ex_col_id'");
		}
	}

	$col_num_rows = mysqli_real_escape_string($con, $_POST['col_num_rows']);

	for($i=1; $i<=$col_num_rows; $i++){
		$col_name = mysqli_real_escape_string($con, $_POST['col_name'.$i]);

		if($col_name != ''){
			$insert_col = mysqli_query($con, "INSERT INTO `pro_color` (`prod_id`, `name`) VALUES ('$pid', '$col_name')");
		}
	}
}

if($spo_check == 1){
	
	$ex_spo_num_rows = mysqli_real_escape_string($con, $_POST['ex_spo_num_rows']);

	for($h=1; $h<=$ex_spo_num_rows; $h++){
		$ex_spo_name = mysqli_real_escape_string($con, $_POST['ex_spo_name'.$h]);
		$ex_spo_id = mysqli_real_escape_string($con, $_POST['ex_spo_id'.$h]);

		if(isset($_POST['ex_spo_rem'.$h])){
			$delete_spo = mysqli_query($con, "DELETE FROM `pro_spec1` WHERE id = '$ex_spo_id'");
		} else {
			$update_spo = mysqli_query($con, "UPDATE `pro_spec1` SET `name` = '$ex_spo_name' WHERE id = '$ex_spo_id'");
		}
	}

	$spo_num_rows = mysqli_real_escape_string($con, $_POST['spo_num_rows']);

	for($i=1; $i<=$spo_num_rows; $i++){
		$spo_name = mysqli_real_escape_string($con, $_POST['spo_name'.$i]);

		if($spo_name != ''){
			$insert_spo = mysqli_query($con, "INSERT INTO `pro_spec1` (`prod_id`, `name`) VALUES ('$pid', '$spo_name')");
		}
	}
}

if($spt_check == 1){
	
	$ex_spt_num_rows = mysqli_real_escape_string($con, $_POST['ex_spt_num_rows']);

	for($h=1; $h<=$ex_spt_num_rows; $h++){
		$ex_spt_name = mysqli_real_escape_string($con, $_POST['ex_spt_name'.$h]);
		$ex_spt_id = mysqli_real_escape_string($con, $_POST['ex_spt_id'.$h]);

		if(isset($_POST['ex_spt_rem'.$h])){
			$delete_spt = mysqli_query($con, "DELETE FROM `pro_spec2` WHERE id = '$ex_spt_id'");
		} else {
			$update_spt = mysqli_query($con, "UPDATE `pro_spec2` SET `name` = '$ex_spt_name' WHERE id = '$ex_spt_id'");
		}
	}

	$spt_num_rows = mysqli_real_escape_string($con, $_POST['spt_num_rows']);

	for($i=1; $i<=$spt_num_rows; $i++){
		$spt_name = mysqli_real_escape_string($con, $_POST['spt_name'.$i]);

		if($spt_name != ''){
			$insert_spt = mysqli_query($con, "INSERT INTO `pro_spec2` (`prod_id`, `name`) VALUES ('$pid', '$spt_name')");
		}
	}
}

$_SESSION['success'] = "Product updated successfully.";
?>
<script>
	setTimeout('location.href = "product_register.php"', 0);
</script>
<?php
}		//end - duplicate check
}
} 
?>