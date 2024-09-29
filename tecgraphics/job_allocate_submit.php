<?php
session_start();
include('db_connection.php');

$errors = [];
$data = [];

//Set time zone
$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
$tadetime = $createToday->format('Y-m-d H:i:s');

$row_id = mysqli_real_escape_string($con,$_POST['row_id']);
$coordi = mysqli_real_escape_string($con,$_POST['coordi']);

     $update_quot = mysqli_query($con, "UPDATE quotation SET job_alloc = 'yes', job_user = '$coordi', joball_datetime = '$tadetime' WHERE id = '$row_id'");
        
echo json_encode($data);

?>