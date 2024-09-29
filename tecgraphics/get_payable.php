<?php
include('db_connection.php');

$rep_date = $_POST['rep_date'];
$supplier = $_POST['supplier'];

if($supplier != ''){
	$squery = 'AND supplier = "'.$supplier.'"';
} else {
	$squery = '';
}

$select = mysqli_query($con, "SELECT * FROM grn_summary WHERE grn_date <= '$rep_date' $squery");

if(mysqli_num_rows($select) > 0){
?>

<div class="row form-group mb-2">
	<div class="col-8">&nbsp;</div>
	<div class="col-4" align="right">
		<input type="button" class="btn btn-primary" value="Print" onclick="get_report_print('Payable Report as at <?php echo $rep_date; ?>')" >
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
		<th>Amount (Rs.)</th>
		<th>Paid (Rs.)</th>
		<th>Balance (Rs.)</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$tot_grn = $tot_pay = $tot_bal = 0;
	while($result = mysqli_fetch_array($select)){

		$select_pay = mysqli_query($con, "SELECT SUM(d.amount) FROM payment_voucher v, payment_voucher_detail d WHERE v.v_no = d.v_no AND d.grn_no = '{$result['grn_no']}' AND v.v_date <= '$rep_date'");
		$result_pay = mysqli_fetch_array($select_pay);

			$grnamt = number_format($result['total'],2,'.','');
			$payamt = number_format($result_pay[0],2,'.','');
			$balamt = number_format($grnamt-$payamt,2,'.','');
			
		if($balamt > 0){	//display only if there is an outstanding

		$select_supp = mysqli_query($con, "SELECT id, sname FROM supplier WHERE id = '{$result['supplier']}'");
		$result_supp = mysqli_fetch_array($select_supp);
	?>
	<tr>
		<td><?php echo $result['grn_date']; ?></td>
		<td><?php echo $result['grn_no']; ?></td>
		<td><?php echo $result_supp['sname']; ?></td>
		<td align="right"><?php echo number_format($grnamt,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($payamt,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($balamt,2,'.',','); ?></td>
	</tr>
	<?php
	$tot_grn += number_format($grnamt,2,'.','');
	$tot_pay += number_format($payamt,2,'.','');
	$tot_bal += number_format($balamt,2,'.','');
		}
	}

	?>
	<tr>
		<td colspan="3" align="right"><b>Total</b></td>
		<td align="right"><b><?php echo number_format($tot_grn,2,'.',','); ?></b></td>
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