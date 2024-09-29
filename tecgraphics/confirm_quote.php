<!DOCTYPE html>
<html lang="en">

<head>
  <?php include('web_header.php'); ?>
</head>
<?php 
$qid = $_GET['ref'];
if(!isset($_SESSION["customerId"])){    //if not signed in

?>
  <script>
    setTimeout('window.location="signin.php?ref=<?php echo $qid; ?>"',0);
  </script>
<?php 
} else {      //if signed in

$cus = $_SESSION["customerId"];

include('db_connection.php');
?>
<body>

  <!-- ======= Header ======= -->

  <!-- End Header -->
    <?php include('web_navbar.php'); ?>

    <section id="" class="contact section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>&nbsp;</h2>
        </div>

        <div class="col-lg-12 mt-5 mt-lg-0 d-flex align-items-stretch">
        <div class="info">
            <div class="row">

<?php
$select_quot = mysqli_query($con, "SELECT * FROM quotation WHERE id = '$qid' AND cus_id = '$cus' AND approval = 'yes'");

//check whether the quotation is for logged customerId
if(mysqli_num_rows($select_quot) <= 0){
    echo 'No pending quotations that need your attention.';
} else {
    $result_quot = mysqli_fetch_array($select_quot);

    //check 30 days validity
    $quotdate = $result_quot['q_date'];
    $qconfirm = $result_quot['confirm'];

    //current date
    $createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
    $cur_date = $createToday->format('Y-m-d');

    $diff = (strtotime($cur_date) - strtotime($quotdate))/60/60/24;

    if($qconfirm == 'yes'){
        echo 'Oops! It seems like you&#39;re attempting to confirm an order that has already been confirmed / processed. <br/><br/>If you have any questions or concerns, please contact us. Thank you for choosing our services!';
    } else if($diff > 30){
        echo 'Quotation Validity Expired! <br/><br/>We regret to inform you that the validity period for your quotation has lapsed. Please take prompt action to request a new quote to ensure accurate pricing and availability for your desired services or products. Thank you for your understanding and cooperation.';
    } else {
        echo 'You have chosen to confirm the quotation. <br/><br/>Thank you for selecting our services. Please click the button below to proceed with payment and finalize the quotation.<br/><br/>';
    
$merchant_id     = '1225721';
$order_id        = $result_quot['q_no'];
$amount          = $result_quot['total'];
$currency        = 'LKR';
$merchant_secret = 'MjM3ODAxMDc3NjI1NDMyMTk0OTYyNzU1MjgwNTA4MjIxNjczMzM1Nw=='; 

$hash = strtoupper(
    md5(
        $merchant_id . 
        $order_id . 
        number_format($amount, 2, '.', '') . 
        $currency .  
        strtoupper(md5($merchant_secret)) 
    ) 
);
?>

<form method="post" action="https://sandbox.payhere.lk/pay/checkout">   
    <input type="hidden" name="merchant_id" value="<?php echo $merchant_id; ?>">    <!-- Replace your Merchant ID -->
    <input type="hidden" name="return_url" value="http://localhost/tecgraphics/pay_confirm.php">
    <input type="hidden" name="cancel_url" value="http://localhost/tecgraphics/confirm_quote.php?ref=<?php echo $qid; ?>">
    <input type="hidden" name="notify_url" value="http://localhost/tecgraphics/pay_notify.php">  
    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
    <input type="hidden" name="items" value="Confirm order">
    <input type="hidden" name="currency" value="<?php echo $currency; ?>">
    <input type="hidden" name="amount" value="<?php echo $amount; ?>">  
    <input type="hidden" name="first_name" value="">
    <input type="hidden" name="last_name" value="">
    <input type="hidden" name="email" value="">
    <input type="hidden" name="phone" value="">
    <input type="hidden" name="address" value="">
    <input type="hidden" name="city" value="">
    <input type="hidden" name="country" value="Sri Lanka">
    <input type="hidden" name="hash" value="<?php echo $hash; ?>">    <!-- Replace with generated hash -->
    <input type="submit" class="btn btn-warning" style="background-color:#eb5d1e;border-color:#eb5d1e;color:#fff;width:120px;" value="Proceed">   
</form> 

<?php
    }

}

?>

            </div>
        </div>
        </div>

      </div>
    </section>
 
        
  <!-- ======= Footer ======= -->
  <?php include('web_footer.php'); ?>
  
</body>
<?php } ?>
</html>