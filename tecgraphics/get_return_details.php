<?php
include('db_connection.php');

$issueno = $_GET['issueno'];

?>

<div class="row form-group mb-3">
	<div class="col-5">
		<label class="form-label">Raw Material</label>
	</div>
	<div class="col-2">
		<label class="form-label">Issued Qty</label>
	</div>
	<div class="col-2">
		<label class="form-label">Remaining Qty</label>
	</div>
	<div class="col-2">
		<label class="form-label">Returned Qty</label>
	</div>
</div>

<?php
$i = 1;
$select_det = mysqli_query($con, "SELECT * FROM issue_details WHERE issue_no = '$issueno'");
while($result_det = mysqli_fetch_array($select_det)){
	
	$select_item = mysqli_query($con, "SELECT name FROM rawmaterial WHERE id = '{$result_det['item_id']}'");
	$result_item = mysqli_fetch_array($select_item);
	
?>
<div class="row form-group mb-3">
	<div class="col-5 mb-3">
		<input type="text" class="form-control" name="itemname<?php echo $i; ?>" id="itemname<?php echo $i; ?>" value="<?php echo $result_item['name']; ?>" readonly >
		<input type="hidden" class="form-control" name="itemid<?php echo $i; ?>" id="itemid<?php echo $i; ?>" value="<?php echo $result_det['item_id']; ?>" readonly >
		<input type="hidden" class="form-control" name="rowid<?php echo $i; ?>" id="rowid<?php echo $i; ?>" value="<?php echo $result_det['id']; ?>" readonly >
	</div>
	<div class="col-2 mb-3">
		<input type="text" class="form-control" name="iss<?php echo $i; ?>" id="iss<?php echo $i; ?>" value="<?php echo $result_det['qty']; ?>" readonly >
	</div>
	<div class="col-2 mb-3">
		<input type="text" class="form-control" name="ava<?php echo $i; ?>" id="ava<?php echo $i; ?>" value="<?php echo $result_det['qty']-$result_det['return_qty']; ?>" readonly >
	</div>
	<div class="col-2 mb-3">
		<input type="text" class="form-control" name="qty<?php echo $i; ?>" id="qty<?php echo $i; ?>" readonly onkeypress="return isNumberKeyn(event);" onchange="chkava('<?php echo $i; ?>')" >
	</div>
	<div class="col-1 mb-3">
		<input type="checkbox" name="select<?php echo $i; ?>" id="select<?php echo $i; ?>" onchange="selectrow('<?php echo $i; ?>')" />
	</div>
</div>
<?php $i++; } ?>
<input type="hidden" class="form-control" name="num_rows" id="num_rows" value="<?php echo $i-1; ?>" >

<div class="row form-group mb-3">
	<div class="col-9 mb-3">
		<input type="submit" class="btn btn-success" name="submit" id="submit" value="Submit" >
	</div>
</div>