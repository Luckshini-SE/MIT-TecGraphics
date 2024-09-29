<?php
include('db_connection.php');

$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
$supplier = $_POST['supplier'];
$pmethod = $_POST['pmethod'];

if($supplier != ''){
	$squery = 'AND supplier = "'.$supplier.'"';
} else {
	$squery = '';
}

if($pmethod != ''){
	$mquery = 'AND paytype = "'.$pmethod.'"';
} else {
	$mquery = '';
}

$select = mysqli_query($con, "SELECT * FROM payment_voucher WHERE v_date BETWEEN '$fromDate' AND '$toDate' $squery $mquery");

if(mysqli_num_rows($select) > 0){
?>

<div class="row form-group mb-2">
	<div class="col-8">&nbsp;</div>
	<div class="col-4" align="right">
		<input type="button" class="btn btn-primary" value="Print" onclick="get_report_print('Payments Done Report')" >
		<input type="button" class="btn btn-warning" value="Excel" onclick="get_report_excel()" >
	</div>
</div>

<div id="rep_div">
	
<table width="100%" class="table table-bordered" id="rep_tbl" >
	<thead>
	<tr>
		<th>Date</th>
		<th>No</th>
		<th>Supplier</th>
		<th>GRN No.</th>
		<th>Amount (Rs.)</th>
		<th>Method</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$tot_pay = 0;
	while($result = mysqli_fetch_array($select)){

		$select_supp = mysqli_query($con, "SELECT id, sname FROM supplier WHERE id = '{$result['supplier']}'");
		$result_supp = mysqli_fetch_array($select_supp);

		$grn_no = '';
		$select_grn = mysqli_query($con, "SELECT grn_no FROM payment_voucher_detail WHERE v_no = '{$result['v_no']}'");
		while($result_grn = mysqli_fetch_array($select_grn)){
			$grn_no .= $result_grn['grn_no'].', ';
		}
		$grn_no = substr($grn_no,0,-2);
	?>
	<tr>
		<td><?php echo $result['v_date']; ?></td>
		<td><?php echo $result['v_no']; ?></td>
		<td><?php echo $result_supp['sname']; ?></td>
		<td><?php echo $grn_no; ?></td>
		<td align="right"><?php echo number_format($result['amount'],2,'.',','); ?></td>
		<td><?php echo $result['paytype']; ?></td>
	</tr>
	<?php
	$tot_pay += number_format($result['amount'],2,'.','');
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