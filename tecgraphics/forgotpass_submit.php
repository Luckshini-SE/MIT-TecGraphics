<?php
session_start();
include('db_connection.php');

$email = mysqli_real_escape_string($con,$_POST['email']);

$select_user = mysqli_query($con, "SELECT * FROM customer WHERE email = '$email' AND active = 'yes'");
$result_user = mysqli_fetch_array($select_user);

if(mysqli_num_rows($select_user) <= 0){			//if there are no matching records

$_SESSION['error'] = "Invalid email address.";
?>
<script>
	setTimeout('location.href = "forgotpass.php"',0);
</script>
<?php
} else {		//if there are matching records

//create temporary pasword
function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

$new_password = randomPassword();

$update = mysqli_query($con, "UPDATE customer SET password = '$new_password' WHERE id = '{$result_user['id']}'");

$to = $email;
$subject = "Tecgraphics - Reset password";

$message = "
<html>
<head>
<title>Reset password</title>
</head>
<body>
<p>Your Tecgraphics account password has been reset according to your request. Your new password is,</p>
<p>".$new_password."</p>
<p>Please change your password once you login with above password.</p>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: info@tecgraphics.lk' . "\r\n";

mail($to,$subject,$message,$headers);

$_SESSION['success'] = "New password has been sent to your email.";
?>
<script>
	setTimeout('location.href = "forgotpass.php"',0);
</script>
<?php
}
?>