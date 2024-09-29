<?php
include('db_connection.php');

$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
$rawmat = $_POST['rawmat'];

/*get opening stock*/
//grn
$select_grn = mysqli_query($con, "SELECT SUM(m.grn_qty) FROM grn_summary s, grn_stock m WHERE s.grn_no = m.grn_no AND s.grn_date < '$fromDate' AND m.item_id = '$rawmat'");
$result_grn = mysqli_fetch_array($select_grn);
	$opening_grn = $result_grn[0];

//issue
$select_iss = mysqli_query($con, "SELECT SUM(m.qty) FROM issue_summary s, issue_details m WHERE s.issue_no = m.issue_no AND s.issue_date < '$fromDate' AND m.item_id = '$rawmat'");
$result_iss = mysqli_fetch_array($select_iss);
	$opening_iss = $result_iss[0];
	
//return
$select_ret = mysqli_query($con, "SELECT SUM(m.qty) FROM return_summary s, return_details m WHERE s.return_no = m.return_no AND s.return_date < '$fromDate' AND m.item_id = '$rawmat'");
$result_ret = mysqli_fetch_array($select_ret);
	$opening_ret = $result_ret[0];

$openinst_stock = $opening_grn-$opening_iss+$opening_ret;

/*get transactions*/
//grn
$select_grn2 = mysqli_query($con, "SELECT s.grn_no, s.grn_date, m.grn_qty FROM grn_summary s, grn_stock m WHERE s.grn_no = m.grn_no AND s.grn_date BETWEEN '$fromDate' AND '$toDate' AND m.item_id = '$rawmat'");
while($result_grn2 = mysqli_fetch_array($select_grn2)){

	mysqli_query($con, "INSERT INTO temp_stock_move (refdate, refnum, type, inqty, outqty) VALUES ('{$result_grn2[1]}', '{$result_grn2[0]}', 'GRN', '{$result_grn2[2]}', '0')");
}

//issue
$select_iss2 = mysqli_query($con, "SELECT s.issue_no, s.issue_date, m.qty FROM issue_summary s, issue_details m WHERE s.issue_no = m.issue_no AND s.issue_date BETWEEN '$fromDate' AND '$toDate' AND m.item_id = '$rawmat'");
while($result_iss2 = mysqli_fetch_array($select_iss2)){

	mysqli_query($con, "INSERT INTO temp_stock_move (refdate, refnum, type, inqty, outqty) VALUES ('{$result_iss2[1]}', '{$result_iss2[0]}', 'Item Issue', '0', '{$result_iss2[2]}')");
}
	
//return
$select_ret2 = mysqli_query($con, "SELECT s.return_no, s.return_date, m.qty FROM return_summary s, return_details m WHERE s.return_no = m.return_no AND s.return_date BETWEEN '$fromDate' AND '$toDate' AND m.item_id = '$rawmat'");
while($result_ret2 = mysqli_fetch_array($select_ret2)){

	mysqli_query($con, "INSERT INTO temp_stock_move (refdate, refnum, type, inqty, outqty) VALUES ('{$result_ret2[1]}', '{$result_ret2[0]}', 'Issue Return', '{$result_ret2[2]}', '0')");
}
?>

<div class="row form-group mb-2">
	<div class="col-8">&nbsp;</div>
	<div class="col-4" align="right">
		<input type="button" class="btn btn-primary" value="Print" onclick="get_report_print('Stock Movement Report')" >
		<input type="button" class="btn btn-warning" value="Excel" onclick="get_report_excel()" >
	</div>
</div>

<div id="rep_div">
	
<table width="100%" class="table table-bordered" id="rep_tbl" >
	<thead>
	<tr>
		<th>Date</th>
		<th>Type</th>
		<th>Ref No.</th>
		<th>In</th>
		<th>Out</th>
		<th>&nbsp;</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td colspan="5">Opening stock</td>
		<td align="right"><?php echo $openinst_stock; ?></td>
	</tr>
	<?php
	$net_qty = $openinst_stock;

	$select = mysqli_query($con, "SELECT * FROM temp_stock_move ORDER BY refdate, id");
	while($result = mysqli_fetch_array($select)){

	$net_qty = $net_qty+$result['inqty']-$result['outqty'];
	?>
	<tr>
		<td><?php echo $result['refdate']; ?></td>
		<td><?php echo $result['type']; ?></td>
		<td><?php echo $result['refnum']; ?></td>
		<td align="right"><?php echo $result['inqty']; ?></td>
		<td align="right"><?php echo $result['outqty']; ?></td>
		<td align="right"><?php echo $net_qty; ?></td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td colspan="5">Closing stock</td>
		<td align="right"><?php echo $net_qty; ?></td>
	</tr>
	</tbody>
</table>
</div>

<?php 
mysqli_query($con, "TRUNCATE TABLE temp_stock_move");
?>
