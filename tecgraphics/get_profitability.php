<?php
include('db_connection.php');

$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
$job_no = $_POST['job_no'];

if($job_no != ''){
	$cquery = 'AND jobno = "'.$job_no.'"';
} else {
	$cquery = '';
}

$select = mysqli_query($con, "SELECT * FROM jobcard WHERE job_date BETWEEN '$fromDate' AND '$toDate' $cquery ");

if(mysqli_num_rows($select) > 0){
?>

<div class="row form-group mb-2">
	<div class="col-8">&nbsp;</div>
	<div class="col-4" align="right">
		<input type="button" class="btn btn-primary" value="Print" onclick="get_report_print('Gross Profitability Report')" >
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
		<th>Material Cost (Rs.)</th>
		<th>Sale (Rs.)</th>
		<th>Gross Profit (Rs.)</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$tot_cost = $tot_sale = $tot_prof = 0;
	while($result = mysqli_fetch_array($select)){

		$select_cust = mysqli_query($con, "SELECT id, name, last_name FROM customer WHERE id = '{$result['cus_id']}'");
		$result_cust = mysqli_fetch_array($select_cust);

		$select_cost = mysqli_query($con, "SELECT SUM((d.qty - d.return_qty) * g.uprice ) FROM issue_summary s, issue_details d, grn_stock g WHERE s.issue_no = d.issue_no AND d.stock_id = g.id AND s.jobno = '{$result['jobno']}'");
		$result_cost = mysqli_fetch_array($select_cost);

		$select_sale = mysqli_query($con, "SELECT SUM(total) FROM invoice WHERE jobcard_id = '{$result['id']}'");
		$result_sale = mysqli_fetch_array($select_sale);
	?>
	<tr>
		<td><?php echo $result['job_date']; ?></td>
		<td><?php echo $result['jobno']; ?></td>
		<td><?php echo $result_cust['name'].' '.$result_cust['last_name']; ?></td>
		<td align="right"><?php echo number_format($result_cost[0],2,'.',','); ?></td>
		<td align="right"><?php echo number_format($result_sale[0],2,'.',','); ?></td>
		<td align="right"><?php echo number_format($result_sale[0]-$result_cost[0],2,'.',','); ?></td>
	</tr>
	<?php
	$tot_cost += number_format($result_cost[0],2,'.','');
	$tot_sale += number_format($result_sale[0],2,'.','');
	$tot_prof += number_format($result_sale[0]-$result_cost[0],2,'.','');
	}
	?>
	<tr>
		<td colspan="3" align="right"><b>Total</b></td>
		<td align="right"><b><?php echo number_format($tot_cost,2,'.',','); ?></b></td>
		<td align="right"><b><?php echo number_format($tot_sale,2,'.',','); ?></b></td>
		<td align="right"><b><?php echo number_format($tot_prof,2,'.',','); ?></b></td>
	</tr>
	</tbody>
</table>
</div>

<?php 
} else {
	echo 'No results.';
}
?>
