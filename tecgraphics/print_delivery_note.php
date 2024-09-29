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

$did = $_GET['did'];

$select_del = mysqli_query($con, "SELECT * FROM delivery WHERE id = '$did'");
$result_del = mysqli_fetch_array($select_del);

$select_cust = mysqli_query($con, "SELECT title, name, last_name FROM customer WHERE id = '{$result_del['cus_id']}'");
$result_cust = mysqli_fetch_array($select_cust);
	if($result_cust['title']!='6'){
		$select_title = mysqli_query($con, "SELECT title FROM title WHERE id = '{$result_cust['title']}'");
		$result_title = mysqli_fetch_array($select_title);
		$cusname = $result_title['title'].'. '.$result_cust['name'].' '.$result_cust['last_name'];
	} else {
		$cusname = $result_cust['name'].' '.$result_cust['last_name'];
	}

$select_inv = mysqli_query($con, "SELECT invoice_no FROM invoice WHERE id = '{$result_del['invoice_id']}'");
$result_inv = mysqli_fetch_array($select_inv);

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Delivery Note</title>

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
			<td colspan="3" style="text-align:center; margin-bottom:7px;"><hr/><span style="margin-top:7px; font-size:28px; font-weight:bold; padding:5px;">DELIVERY NOTE</span></td>
		</tr>
		<tr>
			<td>
				<table cellpadding="5px" style="margin:7px;">
					<tr>
						<td><b>Delivery Note No.</b></td>
						<td> : </td>
						<td><?php echo $result_del['del_no']; ?></td>
					</tr>
					<tr>
						<td><b>Customer</b></td>
						<td> : </td>
						<td><?php echo $cusname; ?></td>
					</tr>
				</table>
			</td>
			<td width="20%">
				&nbsp;
			</td>
			<td width="35%">
				<table cellpadding="5px" style="margin:7px;">
					<tr>
						<td><b>Date</b></td>
						<td> : </td>
						<td><?php echo $result_del['del_date']; ?></td>
					</tr>
					<tr>
						<td><b>Invoice No.</b></td>
						<td> : </td>
						<td><?php echo $result_inv['invoice_no']; ?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<table width="100%" cellpadding="5px" class="cell-border" >
					<tr>
						<td width="48%" class="cell-border" ><b>Product</b></td>
						<td width="17%" class="cell-border" ><b>Qty</b></td>
						<td width="35%" class="cell-border" ><b>Packing</b></td>
					</tr>
					<?php
					$select_detail = mysqli_query($con, "SELECT * FROM delivery_details WHERE delivery_id = '{$result_del['id']}'");
					while($result_detail = mysqli_fetch_array($select_detail)){

					
										$select_invitm = mysqli_query($con, "SELECT * FROM invoice_details WHERE id = '{$result_detail['invitm_id']}'");
										$result_invitm = mysqli_fetch_array($select_invitm);
					
										$select_jobitm = mysqli_query($con, "SELECT * FROM jobcard_details WHERE id = '{$result_invitm['jitm_id']}'");
										$result_jobitm = mysqli_fetch_array($select_jobitm);
										
										$select_quotitm = mysqli_query($con, "SELECT * FROM quotation_details WHERE id = '{$result_jobitm['qitm_id']}'");
										$result_quotitm = mysqli_fetch_array($select_quotitm);

										$select_reqitm = mysqli_query($con, "SELECT * FROM requests WHERE id = '{$result_quotitm['req_item_id']}'");
										$result_reqitm = mysqli_fetch_array($select_reqitm);
										
										$select_product = mysqli_query($con, "SELECT name, pricing, uprice FROM products WHERE id = '{$result_reqitm['prod_id']}'");
										$result_product = mysqli_fetch_array($select_product);
										
										if($result_product['pricing'] == 1){
											$measure = '';
										} else {
											$select_meas = mysqli_query($con, "SELECT measure FROM pricing WHERE id = '{$result_product['pricing']}'");
											$result_meas = mysqli_fetch_array($select_meas);	
											$measure = $result_meas['measure'];
										}

										$description = '';

										if($result_reqitm['material'] != ''){
											$select_mat = mysqli_query($con, "SELECT name FROM pro_material WHERE id = '{$result_reqitm['material']}'");
											$result_mat = mysqli_fetch_array($select_mat);

											$description .= $result_mat['name'];
										}
                        
										if($result_reqitm['size'] != ''){
											$select_siz = mysqli_query($con, "SELECT name FROM pro_size WHERE id = '{$result_reqitm['size']}'");
											$result_siz = mysqli_fetch_array($select_siz);

											$description .= ' | '.$result_siz['name'];
										}
                        
										if($result_reqitm['width'] != ''){
											$description .= ' | '.$result_reqitm['width'].' x '.$result_reqitm['height'].' '.$measure;
										}
                        
										if($result_reqitm['color'] != ''){
											$select_col = mysqli_query($con, "SELECT name FROM pro_color WHERE id = '{$result_reqitm['color']}'");
											$result_col = mysqli_fetch_array($select_col);

											$description .= ' | '.$result_col['name'];
										}
										
										if($result_reqitm['spe_note'] != ''){
											$description .= ' | '.$result_reqitm['spe_note'];
										}
                        
					?>
					<tr>
						<td class="cell-border2" ><?php echo $result_product['name'].'<br/>'.$description; ?></td>
						<td class="cell-border2" ><?php echo $result_detail['qty']; ?></td>
						<td class="cell-border2" ><?php echo $result_detail['packing']; ?></td>
					</tr>
					<?php } ?>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3">
			<p><b>Note</b> : Please check all items carefully when accepting.</p>
			</td>
		</tr>
		<tr>
			<td colspan="3" align="center">
			<table width="100%">
				<tr>
					<td colspan="5">Accepted by:</td>
				</tr>
				<tr>
					<td colspan="5">&nbsp;</td>
				</tr>
				<tr>
					<td width="10%">&nbsp;</td>
					<td width="30%" style="border-bottom:1px dotted black;" >&nbsp;</td>
					<td width="20%">&nbsp;</td>
					<td width="30%" style="border-bottom:1px dotted black;" >&nbsp;</td>
					<td width="10%">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="center">Customer Signature</td>
					<td>&nbsp;</td>
					<td align="center">Date</td>
					<td>&nbsp;</td>
				</tr>
			</table>
			</td>
		</tr>
	</table>

</body>

</html>
<?php } ?>