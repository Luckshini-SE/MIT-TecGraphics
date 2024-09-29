<?php
include('db_connection.php');

$rep_date = $_POST['rep_date'];
$customer = $_POST['customer'];

if($customer != ''){
	$cquery = 'AND cus_id = "'.$customer.'"';
} else {
	$cquery = '';
}

$select = mysqli_query($con, "SELECT * FROM invoice WHERE cancel = 'no' AND invoice_date <= '$rep_date' $cquery");

if(mysqli_num_rows($select) > 0){
?>

<div class="row form-group mb-2">
	<div class="col-8">&nbsp;</div>
	<div class="col-4" align="right">
		<input type="button" class="btn btn-primary" value="Print" onclick="get_report_print('Receivable Report as at <?php echo $rep_date; ?>')" >
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
		<th>Net Amount (Rs.)</th>
		<th>Paid (Rs.)</th>
		<th>Balance (Rs.)</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$tot_nsale = $tot_pay = $tot_bal = 0;
	while($result = mysqli_fetch_array($select)){

		$select_pay = mysqli_query($con, "SELECT SUM(d.amount) FROM receipt r, receipt_details d WHERE r.rec_no = d.rec_no AND d.inv_no = '{$result['invoice_no']}' AND r.rec_date <= '$rep_date'");
		$result_pay = mysqli_fetch_array($select_pay);
			
			$invamt = number_format($result['total'],2,'.','');
			$payamt = number_format($result_pay[0],2,'.','');
			$balamt = number_format($invamt-$payamt,2,'.','');
		
		if($balamt > 0){	//display only if there is an outstanding

		$select_cust = mysqli_query($con, "SELECT id, name, last_name FROM customer WHERE id = '{$result['cus_id']}'");
		$result_cust = mysqli_fetch_array($select_cust);
	?>
	<tr>
		<td><?php echo $result['invoice_date']; ?></td>
		<td><?php echo $result['invoice_no']; ?></td>
		<td><?php echo $result_cust['name'].' '.$result_cust['last_name']; ?></td>
		<td align="right"><?php echo number_format($invamt,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($payamt,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($balamt,2,'.',','); ?></td>
	</tr>
	<?php
	$tot_nsale += number_format($invamt,2,'.','');
	$tot_pay += number_format($payamt,2,'.','');
	$tot_bal += number_format($balamt,2,'.','');
		}
	}
	?>
	<tr>
		<td colspan="3" align="right"><b>Total</b></td>
		<td align="right"><b><?php echo number_format($tot_nsale,2,'.',','); ?></b></td>
		<td align="right"><b><?php echo number_format($tot_pay,2,'.',','); ?></b></td>
		<td align="right"><b><?php echo number_format($tot_bal,2,'.',','); ?></b></td>
	</tr>
	</tbody>
</table>
</div>

<?php 
} else {
	echo 'No results.';
}
?>