<?php
include('db_connection.php');

$pono = $_GET['pono'];

$select_sum = mysqli_query($con, "SELECT * FROM purchase_order_summary WHERE id = '$pono'");
$result_sum = mysqli_fetch_array($select_sum);

	$select_supp = mysqli_query($con, "SELECT sname FROM supplier WHERE id = '{$result_sum['supplier']}'");
	$result_supp = mysqli_fetch_array($select_supp);

?>

<div class="row form-group mb-3">
	<div class="col-2 ">
		<label class="form-label">PO No.</label>
		<input type="text" class="form-control" name="pono" id="pono" value="<?php echo $result_sum['po_no']; ?>" readonly >
	</div>
	<div class="col-3  mb-3">
		<label class="form-label">PO Date</label>
		<input type="text" class="form-control" name="podate" id="podate" value="<?php echo $result_sum['po_date']; ?>" readonly >
	</div>
	<div class="col-4  mb-3">
		<label class="form-label">Supplier</label>
		<input type="text" class="form-control" name="suppname" id="suppname" value="<?php echo $result_supp['sname']; ?>" readonly >
		<input type="hidden" class="form-control" name="supplier" id="supplier" value="<?php echo $result_sum['supplier']; ?>" >
	</div>
	<div class="col-3  mb-3">
		<label class="form-label">Invoice No.</label>
		<input type="text" class="form-control" name="invno" id="invno"  >
	</div>
</div>

<div class="row form-group mb-3">
	<div class="col-5">
		<label class="form-label">Raw Material</label>
	</div>
	<div class="col-2">
		<label class="form-label">Rate (Rs.)</label>
	</div>
	<div class="col-2">
		<label class="form-label">Received Qty</label>
	</div>
	<div class="col-2">
		<label class="form-label">Amount (Rs.)</label>
	</div>
</div>

<?php
$i = 1;
$select_det = mysqli_query($con, "SELECT * FROM purchase_order_detail WHERE po_no = '{$result_sum['po_no']}' AND grn_qty > 0");
while($result_det = mysqli_fetch_array($select_det)){
	
	$select_item = mysqli_query($con, "SELECT name FROM rawmaterial WHERE id = '{$result_det['item_id']}'");
	$result_item = mysqli_fetch_array($select_item);
?>
<div class="row form-group mb-3">
	<div class="col-5 mb-3">
		<input type="text" class="form-control" name="item<?php echo $i; ?>" id="item<?php echo $i; ?>" value="<?php echo $result_item['name']; ?>" readonly >
		<input type="hidden" class="form-control" name="itemid<?php echo $i; ?>" id="itemid<?php echo $i; ?>" value="<?php echo $result_det['item_id']; ?>" >
		<input type="hidden" class="form-control" name="rowid<?php echo $i; ?>" id="rowid<?php echo $i; ?>" value="<?php echo $result_det['id']; ?>" >
	</div>
	<div class="col-2 mb-3">
		<input type="text" class="form-control" name="rate<?php echo $i; ?>" id="rate<?php echo $i; ?>" placeholder="Rate" value="<?php echo $result_det['uprice']; ?>" onkeypress="return isNumberKeyn(event);" onchange="calculateAmount(1)" style="text-align: right;" readonly >
	</div>
	<div class="col-2 mb-3">
		<input type="text" class="form-control" name="qty<?php echo $i; ?>" id="qty<?php echo $i; ?>" placeholder="Qty" value="<?php echo $result_det['grn_qty']; ?>" onkeypress="return isNumberKeyn(event);" onchange="calculateAmount(1)" style="text-align: right;" readonly >
	</div>
	<div class="col-2 mb-3">
		<input type="text" class="form-control" name="amount<?php echo $i; ?>" id="amount<?php echo $i; ?>" placeholder="Amount" value="<?php echo $result_det['amount']; ?>" style="text-align: right;" readonly >
	</div>
	<div class="col-1 mb-3">
		<input type="checkbox" name="select<?php echo $i; ?>" id="select<?php echo $i; ?>" onchange="enablerow(<?php echo $i; ?>)" >
	</div>
</div>
<?php $i++; } ?>

<div class="row form-group mb-3">
	<div class="col-9 mb-3" style="text-align: right">
		Total (Rs.)
		<input type="hidden" class="form-control" name="num_rows" id="num_rows" value="<?php echo $i-1; ?>" >
	</div>
	<div class="col-2 mb-3">
		<input type="text" class="form-control" name="total" id="total" value="<?php echo $result_det['amount']; ?>" style="text-align: right;" readonly >
	</div>
</div>

<div class="row form-group mb-3">
	<div class="col-9 mb-3">
		<input type="submit" class="btn btn-success" name="submit" id="submit" value="Submit" >
	</div>
</div>