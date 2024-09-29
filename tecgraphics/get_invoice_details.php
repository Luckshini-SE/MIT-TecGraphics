<?php
include('db_connection.php');

$custid = $_GET['cust'];

$select = mysqli_query($con, "SELECT * FROM invoice WHERE cancel = 'no' AND cus_id = '$custid' AND pay_balance > 0");

if(mysqli_num_rows($select) <= 0){
?>
<div class="row form-group mb-3">
	<div class="col-12 mb-3">
		No outstanding.
	</div>
</div>
<?php
} else {
?>
<div class="row form-group mb-3">
	<div class="col-12 mb-3">
		<table class="table table-striped">
			<thead>
			<tr>
				<th width="17%">Invoice No.</th>
				<th width="17%">Date</th>
				<th width="17%">Quotation No.</th>
				<th width="17%">Outstanding</th>
				<th width="22%">Amount (Rs.)</th>
				<th width="10%"></th>
			</tr>
			</thead>
			<tbody>
			<?php
			$i=1;
			while($result = mysqli_fetch_array($select)){

				$select_quot = mysqli_query($con, "SELECT q.q_no FROM quotation q, jobcard j WHERE q.id = j.quotation_id AND j.id = '{$result['jobcard_id']}'");
				$result_quot = mysqli_fetch_array($select_quot);
			?>
			<tr>
				<td><?php echo $result['invoice_no']; ?><input type="hidden" name="inv_id<?php echo $i; ?>" id="inv_id<?php echo $i; ?>" value="<?php echo $result['id']; ?>" /></td>
				<td><?php echo $result['invoice_date']; ?></td>
				<td><?php echo $result_quot['q_no']; ?></td>
				<td align="right"><?php echo number_format($result['pay_balance'],2,'.',','); ?><input type="hidden" name="inv_amt<?php echo $i; ?>" id="inv_amt<?php echo $i; ?>" value="<?php echo number_format($result['pay_balance'],2,'.',''); ?>" /></td>
				<td><input type="text" class="form-control" name="pay_amt<?php echo $i; ?>" id="pay_amt<?php echo $i; ?>" style="text-align:right" value="<?php echo number_format($result['pay_balance'],2,'.',''); ?>" onkeypress="return isNumberKeyn(event);" onchange="chkamt(<?php echo $i; ?>)" readonly /></td>
				<td><input type="checkbox" name="select<?php echo $i; ?>" id="select<?php echo $i; ?>" onchange="enable_amt(<?php echo $i; ?>)" /></td>
			</tr>
			<?php $i++; } ?>
			</tbody>
		</table>
	</div>
</div>
<div class="row form-group mb-3">
	<div class="col-8 mb-3">
		&nbsp;
	</div>
	<div class="col-3 mb-3">
		<input type="hidden" name="num_rows" id="num_rows" value="<?php echo $i-1; ?>" />
		<input type="text" class="form-control" name="total_pay" id="total_pay" style="text-align:right" readonly />
	</div>
	<div class="col-1 mb-3">
		&nbsp;
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
													<option value="Settlement">Advance Settlement</option>
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

										<div class="row form-group mb-3" id="adv_div" style="display:none">
											<div class="col-12 mb-3">
											<?php
											$select_adv = mysqli_query($con, "SELECT * FROM advance_payment WHERE customer = '$custid' AND balance > 0");

											if(mysqli_num_rows($select_adv) <= 0){
												echo 'No unsettled advance available.';
											} else {
											?>
												<table class="table table-bordered">
													<thead>
													<tr>
														<th width="17%">No</th>
														<th width="17%">Date</th>
														<th width="17%">Quotation No.</th>
														<th width="22%">Balance (Rs.)</th>
														<th width="22%">Amount (Rs.)</th>
														<th width="5%">&nbsp;</th>
													</tr>
													</thead>
													<tbody>
													<?php
													$j=1;
													while($result_adv = mysqli_fetch_array($select_adv)){
													?>
													<tr>
														<td><?php echo $result_adv['rec_no']; ?><input type="hidden" name="adv_id<?php echo $j; ?>" id="adv_id<?php echo $j; ?>" value="<?php echo $result_adv['id']; ?>" /></td>
														<td><?php echo $result_adv['rec_date']; ?></td>
														<td><?php echo $result_adv['quot_no']; ?></td>
														<td align="right"><?php echo number_format($result_adv['balance'],2,'.',','); ?><input type="hidden" class="form-control" name="adv_amt<?php echo $j; ?>" id="adv_amt<?php echo $j; ?>" value="<?php echo number_format($result_adv['balance'],2,'.',''); ?>" /></td>
														<td><input type="text" class="form-control" name="adv_pay<?php echo $j; ?>" id="adv_pay<?php echo $j; ?>" style="text-align:right" value="<?php echo number_format($result_adv['balance'],2,'.',''); ?>" onkeypress="return isNumberKeyn(event);" onchange="chk_advamt(<?php echo $j; ?>)" readonly /></td>
														<td><input type="checkbox" name="select_adv<?php echo $j; ?>" id="select_adv<?php echo $j; ?>" onchange="enable_adv_amt(<?php echo $j; ?>)" /></td>
													</tr>
													<?php $j++;	} ?>
													<tr>
														<td colspan="4" align="right">Total</td>
														<td>
															<input type="hidden" name="num_adv_rows" id="num_adv_rows" value="<?php echo $j-1; ?>" />
															<input type="text" class="form-control" name="total_adv_pay" id="total_adv_pay" style="text-align:right" readonly />
															<span class="error_msg" id="adv_error" ></span>
														</td>
														<td>&nbsp;</td>
													</tr>
													</tbody>
												</table>
											<?php } ?>
											</div>
										</div>

										<div class="row form-group mb-3">
											<div class="col-9 mb-3">
												<input type="submit" class="btn btn-success" name="submit" id="submit" value="Submit" >
											</div>
										</div>
<?php
}
?>