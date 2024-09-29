<?php
session_start();
$loguser = $_SESSION["logUserId"];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

if($loguser == ''){		//check if user is logged in
	header('Location: login.php');
} else {

include('db_connection.php');

//Set time zone
$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
$datetime = $createToday->format('Y-m-d H:i:s');

$q_no = mysqli_real_escape_string($con, $_POST['quot_no']);
$quot_id = mysqli_real_escape_string($con, $_POST['quot_id']);
$quot_date = mysqli_real_escape_string($con, $_POST['quot_date']);
$cust_id = mysqli_real_escape_string($con, $_POST['cust_id']);
$customer = mysqli_real_escape_string($con, $_POST['customer']);
$sales_ex = mysqli_real_escape_string($con, $_POST['sales_ex']);
$subtotal = mysqli_real_escape_string($con, $_POST['subtotal']);
$disc_per = mysqli_real_escape_string($con, $_POST['disc_per']);
$discount = mysqli_real_escape_string($con, $_POST['discount']);
$total = mysqli_real_escape_string($con, $_POST['total']);
$num_rows = mysqli_real_escape_string($con, $_POST['num_rows']);

	$update = mysqli_query($con, "UPDATE quotation SET `subtotal` = '$subtotal', `dis_per` = '$disc_per', `discount` = '$discount', `total` = '$total', 
    `approval` = 'yes', `appr_user` = '$loguser', `appr_datetime` = '$datetime' WHERE id='$quot_id'");

    for($i=1; $i<=$num_rows; $i++){
		
		$row_id = mysqli_real_escape_string($con, $_POST['row_id'.$i]);

		if(isset($_POST['artwork'.$i])){
			$artwork = 'yes';
			$aw_price = mysqli_real_escape_string($con, $_POST['aw_price'.$i]);
		} else {
			$artwork = 'no';
			$aw_price = '0.00';
		}
		
		if(isset($_POST['service'.$i])){
			$service = 'yes';
			$sv_price = mysqli_real_escape_string($con, $_POST['sv_price'.$i]);
		} else {
			$service = 'no';
			$sv_price = '0.00';
		}

		$update2 = mysqli_query($con, "UPDATE `quotation_details` SET `artwork_status` = '$artwork', `artwork` = '$aw_price', `service_status` = '$service', 
        `service` = '$sv_price' WHERE id = '$row_id'");
		
	}

//email quotation to customer - start
$select_quote = mysqli_query($con, "SELECT * FROM quotation WHERE id = '$quot_id'");
$result_quote = mysqli_fetch_array($select_quote);

$select_rec = mysqli_query($con, "SELECT email FROM customer WHERE id = '$cust_id'");
$result_rec = mysqli_fetch_array($select_rec);
    $receiver = $result_rec['email'];

$select_user = mysqli_query($con, "SELECT first_name, last_name, contact FROM users WHERE id = '{$result_quote['log_user']}'");
$result_user = mysqli_fetch_array($select_user);
	$user = $result_user['first_name'].' '.$result_user['last_name'];

$select_req = mysqli_query($con, "SELECT req_no FROM quotation_requests WHERE id = '{$result_quote['req_id']}'");
$result_req = mysqli_fetch_array($select_req);

$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debugging
    $mail->isSMTP();
    $mail->Host = 'smtp.mail.yahoo.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'luckshinif@yahoo.com';
    $mail->Password = 'yufibnqakaabznrx';
    $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587; // TCP port to connect to

    //Recipient
    $mail->setFrom('luckshinif@yahoo.com', 'TecGraphics');
    $mail->addAddress($receiver);

    //Attach image
    //$image_path = 'assets/img/logo.png';
    //$cid = $mail->addEmbeddedImage($image_path, 'image_cid');  // Content ID for the image

    //email
    $mailbody = '<html><body style="font-family:Helvetica; font-size:15px;">';
    $mailbody .= '<table width="90%" >';
    $mailbody .= '<tr>';
    //$mailbody .= '<td width="45%"><img src="cid:'.$cid.'"></td>';
    $mailbody .= '<td width="45%"><span style="font-size: 30px; color: #eb5d1e;"><b>TecGraphics</b></span>';
    $mailbody .= '<td colspan="2">Address : 100, Main Street, Colombo 02.<br/>Tel : +94 112 333 444  |  Email : info@tecgraphics.lk</td>';
    $mailbody .= '</tr>';
    $mailbody .= '<tr>';
    $mailbody .= '<td colspan="3" style="text-align:center; margin-bottom:7px;"><hr/><span style="margin-top:7px; font-size:28px; font-weight:bold; padding:5px;">QUOTATION</span></td>';
    $mailbody .= '</tr>';
    $mailbody .= '<tr>';
    $mailbody .= '<td>';
    $mailbody .= '<table cellpadding="5px" style="margin:7px;">';
    $mailbody .= '<tr><td><b>Customer</b></td><td> : </td><td>'.$customer.'</td></tr>';
    $mailbody .= '<tr><td><b>Request No.</b></td><td> : </td><td>'.$result_req['req_no'].'</td></tr>';
    $mailbody .= '</table>';
    $mailbody .= '</td>';
    $mailbody .= '<td width="20%">&nbsp;</td>';
    $mailbody .= '<td width="35%">';
    $mailbody .= '<table cellpadding="5px" style="margin:7px;">';
    $mailbody .= '<tr><td><b>Quotation No.</b></td><td> : </td><td>'.$q_no.'</td></tr>';
    $mailbody .= '<tr><td><b>Date</b></td><td> : </td><td>'.$quot_date.'</td></tr>';
    $mailbody .= '</table>';
    $mailbody .= '</td>';
    $mailbody .= '</tr>';
    $mailbody .= '<tr><td colspan="3"><p>Dear Sir / Madam,</p><p>We thank you for your interest in our company and have pleasure in submitting our quotation as follows,</p></td></tr>';
    $mailbody .= '<tr><td colspan="3">';
    $mailbody .= '<table width="100%" cellpadding="5px" cellspacing="0" border="1px" >';
    $mailbody .= '<tr>';
    $mailbody .= '<td width="25%"><b>Product</b></td><td width="20%"><b>Unit Price (Rs.)</b></td>';
    $mailbody .= '<td width="17%"><b>Qty</b></td><td width="20%"><b>Amount (Rs.)</b></td>';
    $mailbody .= '</tr>';
    $select_quotitm = mysqli_query($con, "SELECT * FROM quotation_details WHERE quot_id = '$quot_id'");
	while($result_quotitm = mysqli_fetch_array($select_quotitm)){
        
    $select_prod = mysqli_query($con, "SELECT name FROM products WHERE id = '{$result_quotitm['prod_id']}'");
    $result_prod = mysqli_fetch_array($select_prod);

    $mailbody .= '<tr>';
    $mailbody .= '<td>'.$result_prod['name'].'</td><td style="text-align:right;">'.number_format($result_quotitm['uprice'],2,'.',',').'</td>';
    $mailbody .= '<td>'.$result_quotitm['qty'].'</td><td style="text-align:right;">'.number_format($result_quotitm['amount'],2,'.',',').'</td>';
    $mailbody .= '</tr>';
    if($result_quotitm['artwork_status'] == 'yes'){
    $mailbody .= '<tr><td colspan="3" style="text-align:right;">Artwork</td><td style="text-align:right;">'.number_format($result_quotitm['artwork'],2,'.',',').'</td></tr>';
    }
    if($result_quotitm['service_status'] == 'yes'){
    $mailbody .= '<tr><td colspan="3" style="text-align:right;">One day Service</td><td style="text-align:right;">'.number_format($result_quotitm['service'],2,'.',',').'</td></tr>';
    }
    }
    if($disc_per != '' && $disc_per != 0){
    $mailbody .= '<tr><td colspan="3" style="text-align:right;">Subtotal (Rs.)</td><td style="text-align:right;">'.number_format($subtotal,2,'.',',').'</td></tr>';
    $mailbody .= '<tr><td colspan="3" style="text-align:right;">Discount '.$disc_per.'% (Rs.)</td><td style="text-align:right;">'.number_format($discount,2,'.',',').'</td></tr>';
    }
    $mailbody .= '<tr><td colspan="3" style="text-align:right;">Total (Rs.)</td><td style="text-align:right;">'.number_format($total,2,'.',',').'</td></tr>';
    $mailbody .= '</table>';
    $mailbody .= '</td>';
    $mailbody .= '</tr>';
    $mailbody .= '<tr><td colspan="3"><p><b>Note</b> : All prices quoted are valid for 30 days from the date stated in the quotation.</p></td></tr>';
    $mailbody .= '<tr><td colspan="3"><p>If you wish to proceed, kindly confirm your order by clicking the button below. Please do not hesitate to contact undersigned for any clarification.</p></td></tr>';
    $mailbody .= '<tr><td colspan="3"><a href="http://localhost/tecgraphics/confirm_quote.php?ref='.$quot_id.'" target="_blank"><button class="btn" style="padding: 7px; background-color: #eb5d1e; border-color: #eb5d1e; border-radius: 5px; color: white;">Confirm</button></a></td></tr>';
    $mailbody .= '<tr><td colspan="3"><p>Thanking You,<br/>'.$user.'<br/>'.$result_user['contact'].'</p></td></tr>';
    $mailbody .= '</table>';
    $mailbody .= '</body></html>';


    //Content
    $mail->isHTML(true);
    $mail->ContentType = 'text/html';
    $mail->Subject = 'Quotation';
    $mail->Body = $mailbody;    //'Test email body.';

    $mail->send();
    echo 'Email sent successfully';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

//email quotation to customer - end

$_SESSION['success'] = "Quotation Approved.";
?>
<script>
	setTimeout('location.href = "pending_approve_quotations.php"', 0);
</script>
<?php } ?>