<!DOCTYPE html>
<html lang="en">

<head>
  <?php include('web_header.php'); ?>
</head>
<?php
include('db_connection.php');

$order_id = $_GET['order_id'];

//Set time zone
$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
$cur_date = $createToday->format('Y-m-d H:i:s');
$receipt_date = $createToday->format('Y-m-d');

$select_dup = mysqli_query($con, "SELECT * FROM advance_payment WHERE quot_no = '$order_id'");

if(mysqli_num_rows($select_dup) <= 0){      //stop duplicate

$select_max = mysqli_query($con, "SELECT rec_no FROM `advance_payment` ORDER BY id DESC");
if(mysqli_num_rows($select_max) > 0){
	$result_max = mysqli_fetch_array($select_max);
		$temp = substr($result_max['rec_no'], 2);
		$max = $temp+1;
		$receipt_no = 'AD'.$max;
} else {
	$receipt_no = 'AD10001';
}

$select_quote = mysqli_query($con, "SELECT * FROM quotation WHERE q_no = '$order_id'");
$result_quote = mysqli_fetch_array($select_quote);

$customer = $result_quote['cus_id'];
$description = '';
$amount = $result_quote['total'];
$paytype = 'Online';
$cheqno = '';
$cheqdate = '';
$depref = '';

$insert = mysqli_query($con, "INSERT INTO `advance_payment`
(`rec_no`, `rec_date`, `customer`, `description`, `amount`, `pay_type`, `balance`, `user`, `datetime`, `cheq_no`, `cheq_date`, `deposit_ref`, `quot_no`) VALUES 
('$receipt_no', '$receipt_date', '$customer', '$description', '$amount', '$paytype', '$amount', '', '$cur_date', '$cheqno', '$cheqdate', '$depref', '$order_id')");

$update = mysqli_query($con, "UPDATE quotation SET confirm = 'yes', conf_datetime = '$cur_date' WHERE q_no = '$order_id'");

}
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
                You have paid successfully and confirmed the quotation.<br/><br/>
                <a href="index.php"><button type="button" class="btn btn-warning" style="background-color:#eb5d1e;border-color:#eb5d1e;color:#fff;width:120px;">Continue</button></a>
            </div>
        </div>
        </div>

      </div>
    </section>
 
        
  <!-- ======= Footer ======= -->
  <?php include('web_footer.php'); ?>
  
</body>
</html>