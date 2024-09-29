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

$pid = $_GET['pid'];

$select_po = mysqli_query($con, "SELECT * FROM purchase_order_summary WHERE id = '$pid'");
$result_po = mysqli_fetch_array($select_po);

$select_supp = mysqli_query($con, "SELECT sname, address FROM supplier WHERE id = '{$result_po['supplier']}'");
$result_supp = mysqli_fetch_array($select_supp);
	$supp = $result_supp['sname'];
	$sadd = $result_supp['address'];

$select_user = mysqli_query($con, "SELECT first_name, last_name, contact FROM users WHERE id = '{$result_po['user']}'");
$result_user = mysqli_fetch_array($select_user);
	$user = $result_user['first_name'].' '.$result_user['last_name'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Purchase Order</title>

	<style>

	body {
		font-family:Helvetica; 
		font-size:15px;
	}

	.cell-border {
		border: 1px solid black;
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
			<td colspan="3" style="text-align:center; margin-bottom:7px;"><hr/><span style="margin-top:7px; font-size:28px; font-weight:bold; padding:5px;">PURCHASE ORDER</span></td>
		</tr>
		<tr>
			<td>
				<table cellpadding="5px" style="margin:7px;">
					<tr>
						<td><b>Supplier</b><br/><br/></td>
						<td> : <br/><br/></td>
						<td><?php echo $supp.'<br/>'.$sadd; ?></td>
					</tr>
					<tr>
						<td><b>Deliver to</b></td>
						<td> : </td>
						<td>100, Main Street, Colombo 02.</td>
					</tr>
				</table>
			</td>
			<td width="10%">
				&nbsp;
			</td>
			<td width="35%">
				<table cellpadding="5px" style="margin:7px;">
					<tr>
						<td><b>Order No.</b></td>
						<td> : </td>
						<td><?php echo $result_po['po_no']; ?></td>
					</tr>
					<tr>
						<td><b>Date</b></td>
						<td> : </td>
						<td><?php echo $result_po['po_date']; ?></td>
					</tr>
				</table>
			</td>
		</tr>
		
		<tr>
			<td colspan="3">
				<table width="100%" cellpadding="5px" class="cell-border" >
					<tr>
						<td width="34%" class="cell-border" ><b>Item</b></td>
						<td width="22%" class="cell-border" ><b>Qty</b></td>
						<td width="22%" class="cell-border" ><b>Unit Price (Rs.)</b></td>
						<td width="22%" class="cell-border" ><b>Amount (Rs.)</b></td>
					</tr>
					<?php
					$select_items = mysqli_query($con, "SELECT * FROM purchase_order_detail WHERE po_no = '{$result_po['po_no']}'");
					while($result_items = mysqli_fetch_array($select_items)){
						
						$select_prod = mysqli_query($con, "SELECT name FROM rawmaterial WHERE id = '{$result_items['item_id']}'");
						$result_prod = mysqli_fetch_array($select_prod);

					?>
					<tr>
						<td class="cell-border" ><?php echo $result_prod['name']; ?></td>
						<td class="cell-border" ><?php echo $result_items['po_qty']; ?></td>
						<td class="cell-border"  style="text-align:right;"><?php echo number_format($result_items['uprice'],2,'.',''); ?></td>
						<td class="cell-border"  style="text-align:right;"><?php echo number_format($result_items['amount'],2,'.',''); ?></td>
					</tr>
					<?php } ?>
					<tr>
						<td class="cell-border"  colspan="3" style="text-align:right;">Total (Rs.)</td>
						<td class="cell-border"  style="text-align:right;"><?php echo number_format($result_po['total'],2,'.',''); ?></td>
					</tr>
				</table>
			</td>
		</tr>
		<?php if($result_po['snote'] != ''){ ?>
		<tr>
			<td colspan="3">
			<p><?php echo $result_po['snote']; ?></p>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<td colspan="3">
			<p><br/><br/>........................................<br/><?php echo $user; ?><br/><?php echo $result_user['contact']; ?></p>
			</td>
		</tr>
	</table>

</body>

</html>
<?php } ?>