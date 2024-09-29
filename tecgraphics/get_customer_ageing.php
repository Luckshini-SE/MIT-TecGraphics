<?php
include('db_connection.php');

$customer = $_POST['customer'];

if($customer != ''){
	$cquery = 'AND cus_id = "'.$customer.'"';
} else {
	$cquery = '';
}

$select = mysqli_query($con, "SELECT * FROM invoice WHERE cancel = 'no' AND pay_balance > 0 $cquery GROUP BY cus_id");

if(mysqli_num_rows($select) > 0){
?>

<div class="row form-group mb-2">
	<div class="col-8">&nbsp;</div>
	<div class="col-4" align="right">
		<input type="button" class="btn btn-primary" value="Print" onclick="get_report_print('Customer Ageing Report')" >
		<input type="button" class="btn btn-warning" value="Excel" onclick="get_report_excel()" >
	</div>
</div>

<div id="rep_div">
	
<table width="100%" class="table table-bordered" id="rep_tbl" >
	<thead>
	<tr>
		<th>Customer</th>
		<th width="13%">Advance (Rs.)</th>
		<th width="13%">0 - 30</th>
		<th width="13%">31 - 60</th>
		<th width="13%">61 - 90</th>
		<th width="13%">Above 91</th>
		<th width="13%">Total (Rs.)</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$tot_adv = $tot_bl1 = $tot_bl2 = $tot_bl3 = $tot_bl4 = $tot_out = 0;
	while($result = mysqli_fetch_array($select)){

		$select_cust = mysqli_query($con, "SELECT id, name, last_name FROM customer WHERE id = '{$result['cus_id']}'");
		$result_cust = mysqli_fetch_array($select_cust);

		$totr_bl1 = $totr_bl2 = $totr_bl3 = $totr_bl4 = $totr_out = 0;

		$sel_adv = mysqli_query($con, "SELECT SUM(balance) FROM advance_payment WHERE customer = '{$result['cus_id']}'");
		$res_adv = mysqli_fetch_array($sel_adv);
			$totr_adv = $res_adv[0];
		
		$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
		$curr_date = $createToday->format('Y-m-d');
		$date1 = strtotime($curr_date);

		$sel_inv = mysqli_query($con, "SELECT * FROM invoice WHERE cancel = 'no' AND pay_balance > 0 AND cus_id = '{$result['cus_id']}'");
		while($res_inv = mysqli_fetch_array($sel_inv)){
			
			$date2 = strtotime($res_inv['invoice_date']);

			$diff = $date1 - $date2;
			$days = floor($diff / (60 * 60 * 24));

			if($days <= 30){
				$totr_bl1 += $res_inv['pay_balance'];
			} else if($days > 30 && $days <= 60){
				$totr_bl2 += $res_inv['pay_balance'];
			} else if($days > 60 && $days <= 90){
				$totr_bl3 += $res_inv['pay_balance'];
			} else {
				$totr_bl4 += $res_inv['pay_balance'];
			}

			$totr_out += $res_inv['pay_balance'];
		}
	?>
	<tr>
		<td><?php echo $result_cust['name'].' '.$result_cust['last_name']; ?></td>
		<td align="right"><?php echo number_format($totr_adv,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totr_bl1,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totr_bl2,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totr_bl3,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totr_bl4,2,'.',','); ?></td>
		<td align="right"><?php echo number_format($totr_out,2,'.',','); ?></td>
	</tr>
	<?php
	$tot_adv += number_format($totr_adv,2,'.','');
	$tot_bl1 += number_format($totr_bl1,2,'.','');
	$tot_bl2 += number_format($totr_bl2,2,'.','');
	$tot_bl3 += number_format($totr_bl3,2,'.','');
	$tot_bl4 += number_format($totr_bl4,2,'.','');
	$tot_out += number_format($totr_out,2,'.','');
	}
	?>
	<tr>
		<td align="right"><b>Total</b></td>
		<td align="right"><b><?php echo number_format($tot_adv,2,'.',','); ?></b></td>
		<td align="right"><b><?php echo number_format($tot_bl1,2,'.',','); ?></b></td>
		<td align="right"><b><?php echo number_format($tot_bl2,2,'.',','); ?></b></td>
		<td align="right"><b><?php echo number_format($tot_bl3,2,'.',','); ?></b></td>
		<td align="right"><b><?php echo number_format($tot_bl4,2,'.',','); ?></b></td>
		<td align="right"><b><?php echo number_format($tot_out,2,'.',','); ?></b></td>
	</tr>
	</tbody>
</table>
</div>

<?php 
} else {
	echo 'No results.';
}
?>