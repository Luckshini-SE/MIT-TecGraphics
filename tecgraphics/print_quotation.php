<?php
session_start();

if(!isset($_SESSION["logUserId"])){    //if not signed in
?>
  <script>
    setTimeout('window.location="login.php"',0);
  </script>
<?php 
} else {

include('db_connection.php');

$qid = $_GET['qid'];

$select_quot = mysqli_query($con, "SELECT * FROM quotation WHERE id = '$qid'");
$result_quot = mysqli_fetch_array($select_quot);

$select_cust = mysqli_query($con, "SELECT title, name, last_name FROM customer WHERE id = '{$result_quot['cus_id']}'");
$result_cust = mysqli_fetch_array($select_cust);
	if($result_cust['title']!='6'){
		$select_title = mysqli_query($con, "SELECT title FROM title WHERE id = '{$result_cust['title']}'");
		$result_title = mysqli_fetch_array($select_title);
		$cusname = $result_title['title'].'. '.$result_cust['name'].' '.$result_cust['last_name'];
	} else {
		$cusname = $result_cust['name'].' '.$result_cust['last_name'];
	}

$select_user = mysqli_query($con, "SELECT first_name, last_name, contact FROM users WHERE id = '{$result_quot['log_user']}'");
$result_user = mysqli_fetch_array($select_user);
	$user = $result_user['first_name'].' '.$result_user['last_name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Quotation</title>

	<style>

	body {
		font-family:Helvetica; 
		font-size:15px;
	}

	.cell-border {
		border-top: 1px solid black;
		border-left: 1px solid black;
		border-right: 1px solid black;
		border-collapse: collapse;
	}
	
	.cell-border2 {
		border: 1px solid black;
		border-collapse: collapse;
	}
	
	.cell-border3 {
		border-left: 1px solid black;
		border-right: 1px solid black;
		border-collapse: collapse;
	}

	@page {
		size: A4 portrait;
	}

	</style>
</head>

<body onload="window.print()">

	<table width="100%" >
		<tr>
			<td width="45%">
				<img src="assets/img/logo.png" />
			</td>
			<td colspan="2">
				Address : 100, Main Street, Colombo 02.<br/>
				Tel : +94 112 333 444  |  Email : info@tecgraphics.lk
			</td>
		</tr>
		<tr>
			<td colspan="3" style="text-align:center; margin-bottom:7px;"><hr/><span style="margin-top:7px; font-size:28px; font-weight:bold; padding:5px;">QUOTATION</span></td>
		</tr>
		<tr>
			<td>
				<table cellpadding="5px" style="margin:7px;">
					<tr>
						<td><b>Customer</b></td>
						<td> : </td>
						<td><?php echo $cusname; ?></td>
					</tr>
					<tr>
						<td colspan="3">&nbsp;</td>
					</tr>
				</table>
			</td>
			<td width="20%">
				&nbsp;
			</td>
			<td width="35%">
				<table cellpadding="5px" style="margin:7px;">
					<tr>
						<td><b>Quotation No.</b></td>
						<td> : </td>
						<td><?php echo $result_quot['q_no']; ?></td>
					</tr>
					<tr>
						<td><b>Date</b></td>
						<td> : </td>
						<td><?php echo $result_quot['q_date']; ?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3">
			<p>Dear Sir / Madam,</p>
			<p>We thank you for your interest in our company and have pleasure in submitting our quotation as follows,</p>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<table width="100%" cellpadding="5px" class="cell-border" >
					<tr>
						<td width="48%" class="cell-border" ><b>Product</b></td>
						<td width="17%" class="cell-border" ><b>Qty</b></td>
						<td width="18%" class="cell-border" ><b>Unit Price (Rs.)</b></td>
						<td width="17%" class="cell-border" ><b>Amount (Rs.)</b></td>
					</tr>
					<?php
					$select_detail = mysqli_query($con, "SELECT * FROM quotation_details WHERE quot_id = '{$result_quot['id']}'");
					while($result_detail = mysqli_fetch_array($select_detail)){

					$select_prod = mysqli_query($con, "SELECT name FROM products WHERE id = '{$result_detail['prod_id']}'");
					$result_prod = mysqli_fetch_array($select_prod);

					?>
					<tr>
						<td class="cell-border" ><?php echo $result_prod['name']; ?></td>
						<td class="cell-border" ><?php echo $result_detail['qty']; ?></td>
						<td class="cell-border"  style="text-align:right;"><?php echo number_format($result_detail['uprice'],2,'.',''); ?></td>
						<td class="cell-border"  style="text-align:right;"><?php echo number_format($result_detail['amount'],2,'.',''); ?></td>
					</tr>
					<?php if($result_detail['artwork_status'] == 'yes'){ ?>
					<tr>
						<td class="cell-border3" style="text-align:right;">Artwork</td>
						<td class="cell-border3">&nbsp;</td>
						<td class="cell-border3">&nbsp;</td>
						<td class="cell-border3" style="text-align:right;"><?php echo number_format($result_detail['artwork'],2,'.',''); ?></td>
					</tr>
					<?php } ?>
					<?php if($result_detail['service_status'] == 'yes'){ ?>
					<tr>
						<td class="cell-border3" style="text-align:right;">One day Service</td>
						<td class="cell-border3">&nbsp;</td>
						<td class="cell-border3">&nbsp;</td>
						<td class="cell-border3" style="text-align:right;"><?php echo number_format($result_detail['service'],2,'.',''); ?></td>
					</tr>
					<?php } ?>
					<?php } ?>
					<tr>
						<td class="cell-border"  colspan="3" style="text-align:right;">Subtotal (Rs.)</td>
						<td class="cell-border"  style="text-align:right;"><?php echo number_format($result_quot['subtotal'],2,'.',''); ?></td>
					</tr>
					<?php if($result_quot['discount'] > 0){ ?>
					<tr>
						<td class="cell-border"  colspan="3" style="text-align:right;">Discount (Rs.)</td>
						<td class="cell-border"  style="text-align:right;"><?php echo number_format($result_quot['discount'],2,'.',''); ?></td>
					</tr>
					<?php } ?>
					<tr>
						<td class="cell-border2"  colspan="3" style="text-align:right;">Total (Rs.)</td>
						<td class="cell-border2"  style="text-align:right;"><?php echo number_format($result_quot['total'],2,'.',''); ?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3">
			<p><b>Note</b> : All prices quoted are valid for 30 days from the date stated in the quotation.</p>
			</td>
		</tr>
		<tr>
			<td colspan="3">
			<p>If you have any clarification please do not hesitate to contact undersigned.</p>
			</td>
		</tr>
		<tr>
			<td colspan="3">
			<p><br/><br/>........................................<br/><?php echo $user; ?><br/><?php echo $result_user['contact']; ?></p>
			</td>
		</tr>
	</table>

</body>

</html>
<?php } ?>