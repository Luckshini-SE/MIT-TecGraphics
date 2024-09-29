<?php
include('db_connection.php');

$ctype = $_GET['ctype'];

//start - form for individual customer type
if($ctype == 'i'){
?>

<div class="row form-group mb-3">
	<div class="col-3  mb-3">
		<label class="form-label">Title <span style="color:red">*</span></label>
		<select class="form-select" name="ctitle" id="ctitle" >
			<option value="">-Please Select-</option>
			<?php
			$select_title  = mysqli_query($con, "SELECT id, title FROM title");
			while($result_title = mysqli_fetch_array($select_title)){
			?>
			<option value="<?php echo $result_title['id']; ?>"><?php echo $result_title['title']; ?></option>
			<?php } ?>
		</select>
		<span class="error_msg" id="ctitle_error" ></span>
	</div>
	<div class="col-4  mb-3">
		<label class="form-label">First Name <span style="color:red">*</span></label>
		<input type="text" class="form-control" name="fname" id="fname" placeholder="First Name" >
		<span class="error_msg" id="fname_error" ></span>
	</div>
	<div class="col-5  mb-3">
		<label class="form-label">Last Name <span style="color:red">*</span></label>
		<input type="text" class="form-control" name="lname" id="lname" placeholder="Last Name" >
		<span class="error_msg" id="lname_error" ></span>
	</div>
</div>

<div class="row form-group mb-3">
	<div class="col-4 mb-3">
		<label class="form-label">Mobile No. <span style="color:red">*</span></label>
		<input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile No." >
		<span class="error_msg" id="mobile_error" ></span>
	</div>
	<div class="col-4 mb-3">
		<label class="form-label">Phone No.</label>
		<input type="text" class="form-control" name="phone" id="phone" placeholder="Phone No." >
	</div>
	<div class="col-4 mb-3">
		<label class="form-label">Email</label>
		<input type="text" class="form-control" name="email" id="email" placeholder="Email" >
		<span class="error_msg" id="email_error" ></span>
	</div>
</div>

<div class="row form-group mb-3">
	<div class="col-4 mb-3">
		<label class="form-label">Address (Line 1) <span style="color:red">*</span></label>
		<input type="text" class="form-control" name="address1" id="address1" placeholder="Line 1" >
		<span class="error_msg" id="addr_error" ></span>
	</div>
	<div class="col-4 mb-3">
		<label class="form-label">Address (Line 2)</label>
		<input type="text" class="form-control" name="address2" id="address2" placeholder="Line 2" >
	</div>
	<div class="col-4 mb-3">
		<label class="form-label">Address (Line 3)</label>
		<input type="text" class="form-control" name="address3" id="address3" placeholder="Line 3" >
	</div>
</div>

<?php 
//end - form for individual customer type
} else { 
//start - form for company customer type	
?>

<div class="row form-group mb-3">
	<div class="col-8 mb-3">
		<label class="form-label">Company Name <span style="color:red">*</span></label>
		<input type="text" class="form-control" name="cname" id="cname" placeholder="Company Name" >
		<span class="error_msg" id="cname_error" ></span>
	</div>
	<div class="col-4 mb-3">
		<label class="form-label">Phone No. <span style="color:red">*</span></label>
		<input type="text" class="form-control" name="phone" id="phone" placeholder="Phone No." >
		<span class="error_msg" id="phone_error" ></span>
	</div>
</div>

<div class="row form-group mb-3">
	<div class="col-4 mb-3">
		<label class="form-label">Fax No.</label>
		<input type="text" class="form-control" name="fax" id="fax" placeholder="Fax No." >
	</div>
	<div class="col-4 mb-3">
		<label class="form-label">Email</label>
		<input type="text" class="form-control" name="email" id="email" placeholder="Email" >
		<span class="error_msg" id="email_error" ></span>
	</div>
	<div class="col-4 mb-3">
		<label class="form-label">Web</label>
		<input type="text" class="form-control" name="web" id="web" placeholder="Web" >
	</div>
</div>

<div class="row form-group mb-3">
	<div class="col-4 mb-3">
		<label class="form-label">Address (Line 1) <span style="color:red">*</span></label>
		<input type="text" class="form-control" name="address1" id="address1" placeholder="Line 1" >
		<span class="error_msg" id="addr_error" ></span>
	</div>
	<div class="col-4 mb-3">
		<label class="form-label">Address (Line 2)</label>
		<input type="text" class="form-control" name="address2" id="address2" placeholder="Line 2" >
	</div>
	<div class="col-4 mb-3">
		<label class="form-label">Address (Line 3)</label>
		<input type="text" class="form-control" name="address3" id="address3" placeholder="Line 3" >
	</div>
</div>

<h5 class="card-title mb-3">Contact Person</h5>

<div class="row form-group mb-3">
	<div class="col-3">
		<label class="form-label">Title <span style="color:red">*</span></label>
		<select class="form-select" name="contitle1" id="contitle1" >
			<option value="">-Please Select-</option>
			<?php
			$select_title  = mysqli_query($con, "SELECT id, title FROM title");
			while($result_title = mysqli_fetch_array($select_title)){
			?>
			<option value="<?php echo $result_title[0]; ?>"><?php echo $result_title[1]; ?></option>
			<?php } ?>
		</select>
		<span class="error_msg" id="cont_error" ></span>
	</div>
	<div class="col-4">
		<label class="form-label">First Name <span style="color:red">*</span></label>
		<input type="text" class="form-control" name="confname1" id="confname1" placeholder="First Name" >
		<span class="error_msg" id="cfn_error" ></span>
	</div>
	<div class="col-5">
		<label class="form-label">Last Name <span style="color:red">*</span></label>
		<input type="text" class="form-control" name="conlname1" id="conlname1" placeholder="Last Name" >
		<span class="error_msg" id="cln_error" ></span>
	</div>
</div>

<div class="row form-group mb-3">
	<div class="col-4 mb-3">
		<label class="form-label">Mobile No. <span style="color:red">*</span></label>
		<input type="text" class="form-control" name="conmobile1" id="conmobile1" placeholder="Mobile No." >
		<span class="error_msg" id="cmob_error" ></span>
	</div>
	<div class="col-4 mb-3">
		<label class="form-label">Email</label>
		<input type="text" class="form-control" name="conemail1" id="conemail1" placeholder="Email" >
		<span class="error_msg" id="cem_error" ></span>
	</div>
</div>

<div id="con_person_div"></div>

<input type="hidden" name="num_rows" id="num_rows" value="1" >

<div class="mb-3">
	<input type="button" class="btn btn-primary" value="Add More" onclick="add_more()" >
</div>

<?php 
//end - form for company customer type
} 
?>

<div class="mb-3">
	<input type="submit" class="btn btn-success" name="submit" id="submit" value="Submit" >
</div>