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

$jid = $_GET['jid'];

$select_job = mysqli_query($con, "SELECT * FROM jobcard WHERE id = '$jid'");
$result_job = mysqli_fetch_array($select_job);

$select_cust = mysqli_query($con, "SELECT title, name, last_name FROM customer WHERE id = '{$result_job['cus_id']}'");
$result_cust = mysqli_fetch_array($select_cust);
	if($result_cust['title']!='6'){
		$select_title = mysqli_query($con, "SELECT title FROM title WHERE id = '{$result_cust['title']}'");
		$result_title = mysqli_fetch_array($select_title);
		$cusname = $result_title['title'].'. '.$result_cust['name'].' '.$result_cust['last_name'];
	} else {
		$cusname = $result_cust['name'].' '.$result_cust['last_name'];
	}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Job Card</title>

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
			<td colspan="3" style="text-align:center; margin-bottom:7px;"><hr/><span style="margin-top:7px; font-size:28px; font-weight:bold; padding:5px;">JOB CARD</span></td>
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
						<td><b>Job No.</b></td>
						<td> : </td>
						<td><?php echo $result_job['jobno']; ?></td>
					</tr>
					<tr>
						<td><b>Date</b></td>
						<td> : </td>
						<td><?php echo $result_job['job_date']; ?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<table width="100%" cellpadding="5px" class="cell-border" >
					<tr>
						<td width="50%" class="cell-border" ><b>Product</b></td>
						<td width="16%" class="cell-border" ><b>Qty</b></td>
						<td width="17%" class="cell-border" ><b>Artwork</b></td>
						<td width="17%" class="cell-border" ><b>One day Service</b></td>
					</tr>
					<?php
					$select_jdetail = mysqli_query($con, "SELECT * FROM jobcard_details WHERE jobcard_id = '{$result_job['id']}'");
					while($result_jdetail = mysqli_fetch_array($select_jdetail)){
					
					$select_detail = mysqli_query($con, "SELECT * FROM quotation_details WHERE id = '{$result_jdetail['qitm_id']}'");
					$result_detail = mysqli_fetch_array($select_detail);

					$select_reqitm = mysqli_query($con, "SELECT * FROM requests WHERE id = '{$result_detail['req_item_id']}'");
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
						<td class="cell-border2"><?php echo $result_product['name'].' - '.$description; ?></td>
						<td class="cell-border2"><?php echo $result_jdetail['qty']; ?></td>
						<td class="cell-border2"><?php if($result_detail['artwork_status'] == 'yes'){ echo 'Yes'; } else { echo 'No'; } ?></td>
						<td class="cell-border2"><?php if($result_detail['service_status'] == 'yes'){ echo 'Yes'; } else { echo 'No'; } ?></td>
					</tr>
					<?php } ?>
					
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="3">
				<table width="100%" cellpadding="5px" class="cell-border" >
				<?php
				$select_machine = mysqli_query($con, "SELECT name FROM machine WHERE id = '{$result_job['machine']}'");
				$result_machine = mysqli_fetch_array($select_machine);
				?>
				<tr>
						<td width="50%" class="cell-border2" ><b>Machine: </b><?php echo $result_machine['name']; ?></td>
						<td width="50%" class="cell-border2" ><b>Date: </b></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="3">
				<table width="100%" cellpadding="5px" class="cell-border" >
					<tr>
						<td width="50%" class="cell-border2" ><b>Name of designer</b></td>
						<td width="25%" class="cell-border2" ><b>Start Date </b></td>
						<td width="25%" class="cell-border2" ><b>Finish Date </b></td>
					</tr>
					<tr>
						<td class="cell-border2" >&nbsp;</td>
						<td class="cell-border2" >&nbsp;</td>
						<td class="cell-border2" >&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="3">
				<table width="100%" cellpadding="5px" class="cell-border" >
					<tr>
						<td width="50%" class="cell-border2" ><b>Raw Material</b></td>
						<td width="25%" class="cell-border2" ><b>Qty</b></td>
						<td width="25%" class="cell-border2" ><b>Unit of measure</b></td>
					</tr>
					<?php
					$select_material = mysqli_query($con, "SELECT * FROM jobcard_material WHERE jobcard_id = '{$result_job['id']}'");
					while($result_material = mysqli_fetch_array($select_material)){

					$select_rmat = mysqli_query($con, "SELECT r.name, u.name FROM rawmaterial r, unit_of_measure u WHERE r.uom = u.id AND r.id = '{$result_material['item_id']}'");
					$result_rmat = mysqli_fetch_array($select_rmat);

					?>
					<tr>
						<td class="cell-border2"><?php echo $result_rmat[0]; ?></td>
						<td class="cell-border2"><?php echo $result_material['qty']; ?></td>
						<td class="cell-border2"><?php echo $result_rmat[1]; ?></td>
					</tr>
					<?php } ?>
					
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3">
			<p><b>Special Instructions</b> : <?php echo $result_job['instructions']; ?></p>
			</td>
		</tr>
	</table>

</body>

</html>
<?php } ?>