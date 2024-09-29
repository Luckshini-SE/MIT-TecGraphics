<?php
session_start();
include('db_connection.php');

$errors = [];
$data = [];

//Set time zone
$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
$tadetime = $createToday->format('Y-m-d H:i:s');

$username = mysqli_real_escape_string($con,$_POST['email']);
$password = mysqli_real_escape_string($con,$_POST['passw']);

$new_password = md5($password);

if($_POST['stype'] == 'formTab1'){
    
    $select_user = mysqli_query($con, "SELECT * FROM customer WHERE email = '$username' AND password = '$new_password' AND active = 'yes'");
    $result_user = mysqli_fetch_array($select_user);

    if(mysqli_num_rows($select_user) <= 0){			//if there are no matching records
        $data['success'] = false;
        $data['errors'] = 'Invalid credentials.';
    } else {
        
        $_SESSION["customerId"]	= $result_user['id'];
        $_SESSION["customerName"] = $result_user['name'];
        
        $data['success'] = true;
        $data['message'] = 'Success!';
    }
} else {
    
    $select_user = mysqli_query($con, "SELECT * FROM customer WHERE email = '$username' AND active = 'yes'");
    $result_user = mysqli_fetch_array($select_user);

    if(mysqli_num_rows($select_user) > 0){			//if there are matching records
        $data['success'] = false;
        $data['errors'] = 'Login already exist.';
    } else {

        if($_POST['ctype'] == 'ind'){
            $ctype = 'i';
        } else {
            $ctype = 'c';
        }
        
        $insert_user = mysqli_query($con, "INSERT INTO customer (ctype, title, email, password, reg_date) VALUES ('$ctype','6','$username','$new_password','$tadetime')");
        $cid = mysqli_insert_id($con);

        $_SESSION["customerId"]	= $cid;
        //$_SESSION["customerName"] = $fname;

        $data['success'] = true;
        $data['message'] = 'Success!';

    }
}

echo json_encode($data);