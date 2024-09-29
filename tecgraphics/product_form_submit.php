<?php
session_start();
include('db_connection.php');

$errors = [];
$data = [];

//Set time zone
$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
$tadetime = $createToday->format('Y-m-d H:i:s');

//Form variables
$cus_id = mysqli_real_escape_string($con, $_POST['cus_id']);
$prodid = mysqli_real_escape_string($con, $_POST['product']);

$select_prod = mysqli_query($con, "SELECT * FROM products WHERE id = '$prodid'");
$result_prod = mysqli_fetch_array($select_prod);

if($result_prod['material'] == 1){
	$material = mysqli_real_escape_string($con, $_POST['material']);
} else {
	$material = '';
}

if($result_prod['pricing'] == 1){ 
if($result_prod['size'] == 1){
	$size = mysqli_real_escape_string($con, $_POST['size']);
	$width = '';
	$height = '';
} else {
	$size = '';
	$width = '';
	$height = '';
}
} else {
	$size = '';
	$width = mysqli_real_escape_string($con, $_POST['width']);
	$height = mysqli_real_escape_string($con, $_POST['height']);
}

if($result_prod['finishing'] == 1){
	$finishing = mysqli_real_escape_string($con, $_POST['finishing']);
} else {
	$finishing = '';
}

if($result_prod['color'] == 1){
	$color = mysqli_real_escape_string($con, $_POST['color']);
} else {
	$color = '';
}

if($result_prod['spec1'] == 1){
	$spec1 = mysqli_real_escape_string($con, $_POST['spec1']);
} else {
	$spec1 = '';
}

if($result_prod['spec2'] == 1){
	$spec2 = mysqli_real_escape_string($con, $_POST['spec2']);
} else {
	$spec2 = '';
}

$quantity = mysqli_real_escape_string($con, $_POST['quantity']);
$artwork = mysqli_real_escape_string($con, $_POST['artwork']);
$service = mysqli_real_escape_string($con, $_POST['service']);
$spnote = mysqli_real_escape_string($con, $_POST['spnote']);

//Insert to database
$insert1 = mysqli_query($con, "INSERT INTO `requests`
	(`cust_id`, `prod_id`, `material`, `size`, `width`, `height`, `finishing`, `color`, `spec1`, `spec2`, `qty`, `artwork`, `service`, `datetime`, `spe_note`) VALUES 
	('$cus_id', '$prodid', '$material', '$size', '$width', '$height', '$finishing', '$color', '$spec1', '$spec2', '$quantity', '$artwork', '$service', '$tadetime', '$spnote')");
$iId = mysqli_insert_id($con);

//Upload image 1
if(isset($_FILES['upload1']) && $_FILES['upload1']['error'] !== UPLOAD_ERR_NO_FILE) {
 	
	$filename1 = $_FILES['upload1']['name'];
	$extension1 = end(explode(".", $filename1));		// Find Image Extension
    $newfilename1 = $iId."upd1.".$extension1;			// Rename Image
			
	if (file_exists("img/quot_uploads/".$newfilename1)) {
		echo "";
	} else {
		move_uploaded_file($_FILES["upload1"]["tmp_name"],"img/quot_uploads/".$newfilename1);
	}
	$insert2 = mysqli_query($con, "UPDATE `requests` SET `image1` = '$newfilename1' WHERE id = '$iId'");
} else {
    //echo "No file 1 uploaded.";
}

//Upload image 2
if(isset($_FILES['upload2']) && $_FILES['upload2']['error'] !== UPLOAD_ERR_NO_FILE) {
	$filename2 = $_FILES['upload2']['name'];
	$extension2 = end(explode(".", $filename2));		// Find Image Extension
    $newfilename2 = $iId."upd2.".$extension2;			// Rename Image
			
	if (file_exists("img/quot_uploads/".$newfilename2)) {
		echo "";
	} else {
		move_uploaded_file($_FILES["upload2"]["tmp_name"],"img/quot_uploads/".$newfilename2);
	}
	$insert3 = mysqli_query($con, "UPDATE `requests` SET `image2` = '$newfilename2' WHERE id = '$iId'");
} else {
    //echo "No file 2 uploaded.";
}

echo json_encode($data);

?>