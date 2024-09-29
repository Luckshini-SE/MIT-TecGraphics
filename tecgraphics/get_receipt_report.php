<?php
include('db_connection.php');

$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
$customer = $_POST['customer'];
$pmethod = $_POST['pmethod'];

if($customer != ''){
	$cquery = 'AND customer = "'.$customer.'"';
} else {
	$cquery = '';
}

if($pmethod != ''){
	$mquery = 'AND pay_type = "'.$pmethod.'"';
} else {
	$mquery = 'AND pay_type != "Settlement"';
}

$select = mysqli_query($con, "SELECT * FROM advance_payment WHERE rec_date BETWEEN '$fromDate' AND '$toDate' $cquery $mquery");

$select2 = mysqli_query($con, "SELECT * FROM receipt WHERE rec_date BETWEEN '$fromDate' AND '$toDate' $cquery $mquery");

if(mysqli_num_rows($select) > 0 || mysqli_num_rows($select2) > 0){
?>

<div class="row form-group mb-2">
	<div class="col-8">&nbsp;</div>
	<div class="col-4" align="right">
		<input type="button" class="btn btn-primary" value="Print" onclick="get_report_print('Payments Received Report')" >
		<input type="button" class="btn btn-warning" value="Excel" onclick="get_report_excel()" >
	</div>
</div>

<div id="rep_div">
	
<table width="100%" class="table table-bordered" id="rep_tbl" >
	<thead>
	<tr>
		<th>Date</th>
		<th>No</th>
		<th>Customer</th>
		<th>Invoice No.</th>
		<th>Amount (Rs.)</th>
		<th>Method</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$tot_pay = 0;
	while($result = mysqli_fetch_array($select)){

		$select_cust = mysqli_query($con, "SELECT id, name, last_name FROM customer WHERE id = '{$result['customer']}'");
		$result_cust = mysqli_fetch_array($select_cust);

		$invoice_no = '';
		$select_inv = mysqli_query($con, "SELECT r.inv_no FROM advance_settlement a, receipt_details r WHERE a.rec_no = r.rec_no AND a.advance_pay_no = '{$result['rec_no']}'");
		while($result_inv = mysqli_fetch_array($select_inv)){
			$invoice_no .= $result_inv['inv_no'].', ';
		}
		$invoice_no = substr($invoice_no,0,-2);

		if($invoice_no == ''){
			$invoice_no = '<span style="color:#c3c5c7">Advance not settled</span>';
		}
	?>
	<tr>
		<td><?php echo $result['rec_date']; ?></td>
		<td><?php echo $result['rec_no']; ?></td>
		<td><?php echo $result_cust['name'].' '.$result_cust['last_name']; ?></td>
		<td><?php echo $invoice_no; ?></td>
		<td align="right"><?php echo number_format($result['amount'],2,'.',','); ?></td>
		<td><?php echo $result['pay_type']; ?></td>
	</tr>
	<?php
	$tot_pay += number_format($result['amount'],2,'.','');
	}

	while($result2 = mysqli_fetch_array($select2)){

		$select_cust2 = mysqli_query($con, "SELECT id, name, last_name FROM customer WHERE id = '{$result2['customer']}'");
		$result_cust2 = mysqli_fetch_array($select_cust2);

		$invoice_no = '';
		$select_inv = mysqli_query($con, "SELECT inv_no FROM receipt_details WHERE rec_no = '{$result2['rec_no']}' ");
		while($result_inv = mysqli_fetch_array($select_inv)){
			$invoice_no .= $result_inv['inv_no'].', ';
		}
		$invoice_no = substr($invoice_no,0,-2);
	?>
	<tr>
		<td><?php echo $result2['rec_date']; ?></td>
		<td><?php echo $result2['rec_no']; ?></td>
		<td><?php echo $result_cust2['name'].' '.$result_cust2['last_name']; ?></td>
		<td><?php echo $invoice_no; ?></td>
		<td align="right"><?php echo number_format($result2['amount'],2,'.',','); ?></td>
		<td><?php echo $result2['pay_type']; ?></td>
	</tr>
	<?php
	$tot_pay += number_format($result2['amount'],2,'.','');
	}
	?>
	<tr>
		<td colspan="4" align="right"><b>Total</b></td>
		<td align="right"><b><?php echo number_format($tot_pay,2,'.',','); ?></b></td>
		<td>&nbsp;</td>
	</tr>
	</tbody>
</table>
</div>

<?php 
} else {
	echo 'No results.';
}
?>