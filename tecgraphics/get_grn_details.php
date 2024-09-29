<?php
include('db_connection.php');

$supp = $_GET['supp'];

$select_grn = mysqli_query($con, "SELECT * FROM grn_summary WHERE supplier = '$supp' AND pay_status = 'no'");

if(mysqli_num_rows($select_grn) > 0){
?>

<div class="row form-group mb-3">
	<div class="col-1">
		<label class="form-label">&nbsp;</label>
	</div>
	<div class="col-2">
		<label class="form-label"><b>GRN No.</b></label>
	</div>
	<div class="col-2">
		<label class="form-label"><b>GRN Date</b></label>
	</div>
	<div class="col-3">
		<label class="form-label"><b>Invoice No.</b></label>
	</div>
	<div class="col-3">
		<label class="form-label"><b>Amount (Rs.)</b></label>
	</div>
	<div class="col-1">
		<label class="form-label">&nbsp;</label>
	</div>
</div>

<?php
$i = 1;

while($result_grn = mysqli_fetch_array($select_grn)){
	
?>
<div class="row form-group mb-3">
	<div class="col-1 mb-3">
		&nbsp;
	</div>
	<div class="col-2 mb-3">
		<?php echo $result_grn['grn_no']; ?>
		<input type="hidden" class="form-control" name="rowid<?php echo $i; ?>" id="rowid<?php echo $i; ?>" value="<?php echo $result_grn['id']; ?>" readonly >
	</div>
	<div class="col-2 mb-3">
		<?php echo $result_grn['grn_date']; ?>
	</div>
	<div class="col-3 mb-3">
		<?php echo $result_grn['invoice_no']; ?>
	</div>
	<div class="col-3 mb-3">
		<input type="text" class="form-control" name="pay_amt<?php echo $i; ?>" id="pay_amt<?php echo $i; ?>" style="text-align:right" value="<?php echo $result_grn['balance']; ?>" onkeypress="return isNumberKeyn(event)" onchange="check_amt(<?php echo $i; ?>)" disabled >
		<input type="hidden" name="inv_amt<?php echo $i; ?>" id="inv_amt<?php echo $i; ?>" value="<?php echo $result_grn['balance']; ?>" >
	</div>
	<div class="col-1 mb-3">
		<input type="checkbox" name="select<?php echo $i; ?>" id="select<?php echo $i; ?>" onchange="enable_pay(<?php echo $i; ?>)" />
	</div>
</div>
<?php $i++; } ?>

<input type="hidden" name="num_rows" id="num_rows" value="<?php echo $i-1; ?>" >

<div class="row form-group mb-3">
	<div class="col-8 mb-3" style="text-align:right" >
		Total
	</div>
	<div class="col-3 mb-3">
		<?php echo $result_grn['grn_no']; ?>
		<input type="text" class="form-control" name="total" id="total" style="text-align:right" readonly >
	</div>
</div>	

<div class="row form-group mb-3">
	<div class="col-3 mb-3">
		<label class="form-label">Payment Type <span style="color:red">*</span></label>
		<select class="form-select" name="paytype" id="paytype" onchange="enablediv()" >
			<option value="">-Please Select-</option>
			<option value="Cash">Cash</option>
			<option value="Cheque">Cheque</option>
			<option value="Card">Card</option>
			<option value="Bank Deposit">Bank Deposit</option>
		</select>
		<span class="error_msg" id="pty_error" ></span>
	</div>

	<div class="col-3 mb-3" id="cheq_div1" style="display:none">
		<label class="form-label">Cheque No.</label>
		<input type="text" class="form-control" name="cheqno" id="cheqno" />
		<span class="error_msg" id="cno_error" ></span>
	</div>
	<div class="col-3 mb-3" id="cheq_div2" style="display:none">
		<label class="form-label">Cheque Date</label>
		<input type="text" class="form-control flatpickr-minimum flatpickr-input" name="cheqdate" id="cheqdate" />
		<span class="error_msg" id="cda_error" ></span>
	</div>

	<div class="col-3 mb-3" id="depo_div" style="display:none">
		<label class="form-label">Reference</label>
		<input type="text" class="form-control" name="depref" id="depref" />
		<span class="error_msg" id="ref_error" ></span>
	</div>
</div>

<div class="row form-group mb-3">
	<div class="col-9 mb-3">
		<input type="submit" class="btn btn-success" name="submit" id="submit" value="Submit" >
	</div>
</div>

<?php 
} else {
	echo 'No records.';
}
?>