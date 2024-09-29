<?php
include('db_connection.php');

$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
$customer = $_POST['customer'];

if($customer != ''){
	$cquery = 'AND cus_id = "'.$customer.'"';
} else {
	$cquery = '';
}

$select = mysqli_query($con, "SELECT * FROM invoice WHERE cancel = 'no' AND invoice_date BETWEEN '$fromDate' AND '$toDate' $cquery ");

if(mysqli_num_rows($select) > 0){
?>

<div class="row form-group mb-2">
	<div class="col-8">&nbsp;</div>
	<div class="col-4" align="right">
		<input type="button" class="btn btn-primary" value="Print" onclick="get_report_print('Sales Report')" >
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
		<th>Gross Amount (Rs.)</th>
		<th>Discount (Rs.)</th>
		<th>Net Amount (Rs.)</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$tot_gsale = $tot_disc = $tot_nsale = 0;
	while($result = mysqli_fetch_array($select)){

		$select_cust = mysqli_query($con, "SELECT id, name, last_name FROM customer WHERE id = '{$result['cus_id']}'");
		$result_cust = mysqli_fetch_array($select_cust);
	?>
	<tr>
		<td><?php echo $result['invoice_date']; ?></td>
		<td><?php echo $result['invoice_no']; ?></td>
		<td><?php echo $result_cust['name'].' '.$result_cust['last_name']; ?></td>
		<td align="right"><?php echo number_format($result['subtotal'],2,'.',','); ?></td>
		<td align="right"><?php echo number_format($result['discount'],2,'.',','); ?></td>
		<td align="right"><?php echo number_format($result['total'],2,'.',','); ?></td>
	</tr>
	<?php
	$tot_gsale += number_format($result['subtotal'],2,'.','');
	$tot_disc += number_format($result['discount'],2,'.','');
	$tot_nsale += number_format($result['total'],2,'.','');
	}
	?>
	<tr>
		<td colspan="3" align="right"><b>Total</b></td>
		<td align="right"><b><?php echo number_format($tot_gsale,2,'.',','); ?></b></td>
		<td align="right"><b><?php echo number_format($tot_disc,2,'.',','); ?></b></td>
		<td align="right"><b><?php echo number_format($tot_nsale,2,'.',','); ?></b></td>
	</tr>
	</tbody>
</table>
</div>

<?php 
} else {
	echo 'No results.';
}
?>
