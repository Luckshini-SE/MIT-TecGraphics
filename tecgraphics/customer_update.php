<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('header.php'); ?>
	<?php include('db_connection.php'); ?>
	
	<style>
	
	.error_msg {
		color: rgba(255,0,0,.80);
	}

	.error {
		box-shadow:0 0 0 .2rem rgba(255,0,0,.45);
	}

	</style>
</head>

<?php
$cid = $_GET['cid'];

$select_cust = mysqli_query($con, "SELECT * FROM customer WHERE id = '$cid'");
$result_cust = mysqli_fetch_array($select_cust);
?>

<body>
	<div class="wrapper">

	<?php include('sidebar.php'); ?>

		<div class="main">
			
		<?php include('topbar.php'); ?>

			<main class="content">
				<div class="container-fluid p-0">

					<div class="row">
					<h1 class="h3 mb-3 col-10">Register Customer</h1>
					<div class="col-2" align="right"><a href="customer_list.php"><button class="btn btn-warning">View List</button></a></div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">

									<form method="post" name="cust_form" action="customer_update_submit.php" onsubmit="return validateForm()" >
										<div class="row mb-3" id="alert_div">
											<?php
											if(isset($_SESSION['success']) && $_SESSION['success'] != ''){
												echo '<div class="alert alert-success" role="alert"><div class="alert-message">'.$_SESSION['success'].'</div></div>';
												$_SESSION['success'] = '';
											}
											if(isset($_SESSION['error']) && $_SESSION['error'] != ''){
												echo '<div class="alert alert-danger" role="alert"><div class="alert-message">'.$_SESSION['error'].'</div></div>';
												$_SESSION['error'] = '';
											}
											?>
										</div>	
										<script>
											setTimeout(function(){
											  document.getElementById('alert_div').innerHTML = '';
											}, 3000);
										</script>
										
										<input type="hidden" name="ctype" id="ctype" value="<?php echo $result_cust['ctype']; ?>" >
										<input type="hidden" name="cid" id="cid" value="<?php echo $cid; ?>" >
										<?php
										//start - form for individual customer type
										if($result_cust['ctype'] == 'i'){
										?>

										<div class="row form-group mb-3">
											<div class="col-3  mb-3">
												<label class="form-label">Title <span style="color:red">*</span></label>
												<select class="form-select" name="ctitle" id="ctitle" >
													<?php
													$select_title  = mysqli_query($con, "SELECT id, title FROM title");
													while($result_title = mysqli_fetch_array($select_title)){
													?>
													<option value="<?php echo $result_title['id']; ?>" <?php if($result_title['id'] == $result_cust['title']){ echo 'selected'; } ?> ><?php echo $result_title['title']; ?></option>
													<?php } ?>
												</select>
												<span class="error_msg" id="ctitle_error" ></span>
											</div>
											<div class="col-4  mb-3">
												<label class="form-label">First Name <span style="color:red">*</span></label>
												<input type="text" class="form-control" name="fname" id="fname" placeholder="First Name" value="<?php echo $result_cust['name']; ?>" >
												<span class="error_msg" id="fname_error" ></span>
											</div>
											<div class="col-5  mb-3">
												<label class="form-label">Last Name <span style="color:red">*</span></label>
												<input type="text" class="form-control" name="lname" id="lname" placeholder="Last Name" value="<?php echo $result_cust['last_name']; ?>" >
												<span class="error_msg" id="lname_error" ></span>
											</div>
										</div>

										<div class="row form-group mb-3">
											<div class="col-4 mb-3">
												<label class="form-label">Mobile No. <span style="color:red">*</span></label>
												<input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile No." value="<?php echo $result_cust['mobile']; ?>" >
												<span class="error_msg" id="mobile_error" ></span>
											</div>
											<div class="col-4 mb-3">
												<label class="form-label">Phone No.</label>
												<input type="text" class="form-control" name="phone" id="phone" placeholder="Phone No." value="<?php echo $result_cust['phone']; ?>" >
											</div>
											<div class="col-4 mb-3">
												<label class="form-label">Email</label>
												<input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $result_cust['email']; ?>" >
												<span class="error_msg" id="email_error" ></span>
											</div>
										</div>

										<div class="row form-group mb-3">
											<div class="col-4 mb-3">
												<label class="form-label">Address (Line 1) <span style="color:red">*</span></label>
												<input type="text" class="form-control" name="address1" id="address1" placeholder="Line 1" value="<?php echo $result_cust['address1']; ?>" >
												<span class="error_msg" id="addr_error" ></span>
											</div>
											<div class="col-4 mb-3">
												<label class="form-label">Address (Line 2)</label>
												<input type="text" class="form-control" name="address2" id="address2" placeholder="Line 2" value="<?php echo $result_cust['address2']; ?>" >
											</div>
											<div class="col-4 mb-3">
												<label class="form-label">Address (Line 3)</label>
												<input type="text" class="form-control" name="address3" id="address3" placeholder="Line 3" value="<?php echo $result_cust['address3']; ?>" >
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
												<input type="text" class="form-control" name="cname" id="cname" placeholder="Company Name" value="<?php echo $result_cust['name']; ?>" >
												<span class="error_msg" id="cname_error" ></span>
											</div>
											<div class="col-4 mb-3">
												<label class="form-label">Phone No. <span style="color:red">*</span></label>
												<input type="text" class="form-control" name="phone" id="phone" placeholder="Phone No." value="<?php echo $result_cust['phone']; ?>" >
												<span class="error_msg" id="phone_error" ></span>
											</div>
										</div>

										<div class="row form-group mb-3">
											<div class="col-4 mb-3">
												<label class="form-label">Fax No.</label>
												<input type="text" class="form-control" name="fax" id="fax" placeholder="Fax No." value="<?php echo $result_cust['fax']; ?>" >
											</div>
											<div class="col-4 mb-3">
												<label class="form-label">Email</label>
												<input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $result_cust['email']; ?>" >
												<span class="error_msg" id="email_error" ></span>
											</div>
											<div class="col-4 mb-3">
												<label class="form-label">Web</label>
												<input type="text" class="form-control" name="web" id="web" placeholder="Web" value="<?php echo $result_cust['web']; ?>" >
											</div>
										</div>

										<div class="row form-group mb-3">
											<div class="col-4 mb-3">
												<label class="form-label">Address (Line 1) <span style="color:red">*</span></label>
												<input type="text" class="form-control" name="address1" id="address1" placeholder="Line 1" value="<?php echo $result_cust['address1']; ?>" >
												<span class="error_msg" id="addr_error" ></span>
											</div>
											<div class="col-4 mb-3">
												<label class="form-label">Address (Line 2)</label>
												<input type="text" class="form-control" name="address2" id="address2" placeholder="Line 2" value="<?php echo $result_cust['address2']; ?>" >
											</div>
											<div class="col-4 mb-3">
												<label class="form-label">Address (Line 3)</label>
												<input type="text" class="form-control" name="address3" id="address3" placeholder="Line 3" value="<?php echo $result_cust['address3']; ?>" >
											</div>
										</div>

										<h5 class="card-title mb-3">Contact Person</h5>

										<?php
										$c=1;
										$sel_conper = mysqli_query($con, "SELECT * FROM contact_person WHERE customer = '{$result_cust['id']}'");
										while($res_conper = mysqli_fetch_array($sel_conper)){
										?>
										<div class="row form-group mb-3">
											<div class="col-3">
												<?php if($c == 1){ ?><label class="form-label">Title <span style="color:red">*</span></label><?php } ?>
												<select class="form-select" name="ex_contitle<?php echo $c; ?>" id="ex_contitle<?php echo $c; ?>" >
													<?php
													$select_title  = mysqli_query($con, "SELECT id, title FROM title");
													while($result_title = mysqli_fetch_array($select_title)){
													?>
													<option value="<?php echo $result_title[0]; ?>" <?php if($result_title[0] == $res_conper['ctitle']){ echo 'selected'; } ?> ><?php echo $result_title[1]; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-4">
												<?php if($c == 1){ ?><label class="form-label">First Name <span style="color:red">*</span></label><?php } ?>
												<input type="text" class="form-control" name="ex_confname<?php echo $c; ?>" id="ex_confname<?php echo $c; ?>" placeholder="First Name" value="<?php echo $res_conper['cfname']; ?>" >
												<input type="hidden" name="ex_rowid<?php echo $c; ?>" id="ex_rowid<?php echo $c; ?>" value="<?php echo $res_conper['id']; ?>" >
												<span class="error_msg" id="ex_cfn_error<?php echo $c; ?>" ></span>
											</div>
											<div class="col-5">
												<?php if($c == 1){ ?><label class="form-label">Last Name <span style="color:red">*</span></label><?php } ?>
												<input type="text" class="form-control" name="ex_conlname<?php echo $c; ?>" id="ex_conlname<?php echo $c; ?>" placeholder="Last Name" value="<?php echo $res_conper['clname']; ?>" >
											</div>
										</div>

										<div class="row form-group mb-3">
											<div class="col-4 mb-3">
												<?php if($c == 1){ ?><label class="form-label">Mobile No. <span style="color:red">*</span></label><?php } ?>
												<input type="text" class="form-control" name="ex_conmobile<?php echo $c; ?>" id="ex_conmobile<?php echo $c; ?>" placeholder="Mobile No." value="<?php echo $res_conper['cphone']; ?>" >
												<span class="error_msg" id="ex_cmob_error<?php echo $c; ?>" ></span>
											</div>
											<div class="col-4 mb-3">
												<?php if($c == 1){ ?><label class="form-label">Email</label><?php } ?>
												<input type="text" class="form-control" name="ex_conemail<?php echo $c; ?>" id="ex_conemail<?php echo $c; ?>" placeholder="Email" value="<?php echo $res_conper['cemail']; ?>" >
												<span class="error_msg" id="ex_cem_error<?php echo $c; ?>" ></span>
											</div>
										</div>
										
										<?php $c++; } ?>
										<input type="hidden" name="ex_num_rows" id="ex_num_rows" value="<?php echo $c-1; ?>" >

										<div class="row form-group mb-3">
											<div class="col-3">
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
												<input type="text" class="form-control" name="confname1" id="confname1" placeholder="First Name" >
												<span class="error_msg" id="cfn_error" ></span>
											</div>
											<div class="col-5">
												<input type="text" class="form-control" name="conlname1" id="conlname1" placeholder="Last Name" >
												<span class="error_msg" id="cln_error" ></span>
											</div>
										</div>

										<div class="row form-group mb-3">
											<div class="col-4 mb-3">
												<input type="text" class="form-control" name="conmobile1" id="conmobile1" placeholder="Mobile No." >
												<span class="error_msg" id="cmob_error" ></span>
											</div>
											<div class="col-4 mb-3">
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

									</form>
								</div>
							</div>
						</div>
					</div>

				</div>
			</main>

			<?php include('footer.php'); ?>
		</div>
	</div>

	<script src="js/app.js"></script>

	<script>

	function get_details(){
		var ctype = document.getElementById('ctype').value;
		
		const xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("show_details").innerHTML = this.responseText;
			}
		};
		xhttp.open("GET", "get_customer_form.php?ctype="+ctype);
		xhttp.send();
	}

	function add_more(){

	var title = new Array();
	var conName = new Array();
	var lastName = new Array();
	var conMobile = new Array();
	var conEmail = new Array();
	
	int_num_rows = parseInt(document.getElementById("num_rows").value);
	total_rows = int_num_rows+1;
	
	for(i=2; i<total_rows; i++){
		title[i]	= document.getElementById("contitle"+i).value;
		conName[i]	= document.getElementById("confname"+i).value;
		lastName[i]	= document.getElementById("conlname"+i).value;
		conMobile[i]= document.getElementById("conmobile"+i).value;
		conEmail[i]	= document.getElementById("conemail"+i).value;
	}
	
	document.getElementById("con_person_div").innerHTML = "";
	main_tab = '';
	
		
	for (i=2; i<=total_rows; i++) {
		if (i == total_rows) {
			
			
			main_tab += '<div class="row form-group mb-3">';
			main_tab += '<div class="col-3">';
			main_tab += '<select class="form-select" name="contitle'+i+'" id="contitle'+i+'" ><option value="">-Please Select-</option><?php $select_title  = mysqli_query($con, "SELECT id, title FROM title"); while($result_title = mysqli_fetch_array($select_title)){ ?><option value="<?php echo $result_title[0]; ?>"><?php echo $result_title[1]; ?></option><?php } ?></select></div>';
			main_tab += '<div class="col-4">';
			main_tab += '<input class="form-control " id="confname'+i+'" name="confname'+i+'" type="text" placeholder="First Name" /><span class="error_msg" id="cfn_error'+i+'" ></span></div>';
			main_tab += '<div class="col-5">';
			main_tab += '<input class="form-control " id="conlname'+i+'" name="conlname'+i+'" type="text" placeholder="Last Name" /></div></div>';
			main_tab += '<div class="row form-group mb-3">';
			main_tab += '<div class="col-4 mb-3">';
			main_tab += '<input class="form-control " id="conmobile'+i+'" name="conmobile'+i+'" type="text" placeholder="Mobile No." /><span class="error_msg" id="cmob_error'+i+'" ></span></div>';
			main_tab += '<div class="col-4 mb-3">';
			main_tab += '<input class="form-control " id="conemail'+i+'" name="conemail'+i+'" type="text" placeholder="Email" /><span class="error_msg" id="cem_error'+i+'" ></span></div>';
			main_tab += '<div class="col-1 mb-3">';
			main_tab += '<input type="button" name="button'+i+'" id="button'+i+'" value="Delete" class="btn btn-danger" onclick="deleteContactPerson('+i+')" /></div>';
			main_tab += '</div>';
		    
		}
		
		else {
			
			main_tab += '<div class="row form-group mb-3">';
			main_tab += '<div class="col-3">';
			main_tab += '<select class="form-select" name="contitle'+i+'" id="contitle'+i+'" ><option value="">-Please Select-</option><?php 
							$select_title  = mysqli_query($con, "SELECT id, title FROM title"); 
							while($result_title = mysqli_fetch_array($select_title)){ 
							?>';
			if(title[i]=='<?php echo $result_title[0]; ?>'){
			main_tab += '<option value="<?php echo $result_title[0]; ?>" selected ><?php echo $result_title[1]; ?></option>';
			} else {
			main_tab += '<option value="<?php echo $result_title[0]; ?>"><?php echo $result_title[1]; ?></option>';
			}
			main_tab += '<?php } ?>';
			main_tab += '</select></div>';
			main_tab += '<div class="col-4">';
			main_tab += '<input type="text" name="confname'+i+'" id="confname'+i+'" class="form-control" value=\"'+conName[i]+'\" placeholder="First Name" /><span class="error_msg" id="cfn_error'+i+'" ></span></div>';
			main_tab += '<div class="col-5">';
			main_tab += '<input type="text" name="conlname'+i+'" id="conlname'+i+'" class="form-control" value=\"'+lastName[i]+'\" placeholder="Last Name" /></div></div>';
			main_tab += '<div class="row form-group mb-3">';
			main_tab += '<div class="col-4 mb-3">';
			main_tab += '<input type="text" name="conmobile'+i+'" id="conmobile'+i+'" class="form-control"  value=\"'+conMobile[i]+'\" placeholder="Mobile No." /><span class="error_msg" id="cmob_error'+i+'" ></span></div>';
			main_tab += '<div class="col-4 mb-3">';
			main_tab += '<input type="text" name="conemail'+i+'" id="conemail'+i+'" class="form-control" value=\"'+conEmail[i]+'\" placeholder="Email" /><span class="error_msg" id="cem_error'+i+'" ></span></div>';
			main_tab += '<div class="col-1 mb-3">';
			main_tab += '<input type="button" name="button'+i+'" id="button'+i+'" value="Delete" class="btn btn-danger" onclick="deleteContactPerson('+i+')" /></div>';
			main_tab += '</div>';

		}
	}
	
	main_tab += "";
	
	document.getElementById("con_person_div").innerHTML = main_tab;
	document.getElementById("num_rows").value = total_rows;
}
// End of Ad Row


// Delete Row
function deleteContactPerson(row) {

	var title = new Array();
	var conName = new Array();
	var lastName = new Array();
	var conMobile = new Array();
	var conEmail = new Array();
	
	
	int_num_rows = parseInt(document.getElementById("num_rows").value);
	row = parseInt(row);
	k = 2;
	m = k;
	
	for (; k<=int_num_rows; k++) {
		if (k == row) {			
		}
		else {		
			title[m]	= document.getElementById("contitle"+k).value;
			conName[m]	= document.getElementById("confname"+k).value;
			lastName[m]	= document.getElementById("conlname"+k).value;
			conMobile[m]= document.getElementById("conmobile"+k).value;
			conEmail[m]	= document.getElementById("conemail"+k).value;
			m++;
		}
	}
	
	document.getElementById("con_person_div").innerHTML = "";
	main_tab = '';
	
	i = 2;
	j = i;
	for (; i<=int_num_rows; i++) {
		if (i == row) { 
		}
		else {
			
			main_tab += '<div class="row form-group mb-3">';
			main_tab += '<div class="col-3">';
			main_tab += '<select class="form-select name="contitle'+j+'" id="contitle'+j+'" "><option value="">-Please Select-</option><?php 
							$select_title  = mysqli_query($con, "SELECT id, title FROM title"); 
							while($result_title = mysqli_fetch_array($select_title)){ 
							?>';
			if(title[j]=='<?php echo $result_title[0]; ?>'){
			main_tab += '<option value="<?php echo $result_title[0]; ?>" selected ><?php echo $result_title[1]; ?></option>';
			} else {
			main_tab += '<option value="<?php echo $result_title[0]; ?>"><?php echo $result_title[1]; ?></option>';
			}
			main_tab += '<?php } ?>';
			main_tab += '</select></div>';
			main_tab += '<div class="col-4">';
			main_tab += '<input type="text" name="confname'+j+'" id="confname'+j+'" class="form-control" style="width:100%" value=\"'+conName[j]+'\" placeholder="First Name" /><span class="error_msg" id="cfn_error'+j+'" ></span></div>';
			main_tab += '<div class="col-5">';
			main_tab += '<input type="text" name="conlname'+j+'" id="conlname'+j+'" class="form-control" style="width:100%" value=\"'+lastName[j]+'\" placeholder="Last Name" /></div></div>';
			main_tab += '<div class="row form-group mb-3">';
			main_tab += '<div class="col-4 mb-3">';
			main_tab += '<input type="text" name="conmobile'+j+'" id="conmobile'+j+'" class="form-control" style="width:100%" value=\"'+conMobile[j]+'\"  placeholder="Mobile No." /><span class="error_msg" id="cmob_error'+j+'" ></span></div>';
			main_tab += '<div class="col-4 mb-3">';
			main_tab += '<input type="text" name="conemail'+j+'" id="conemail'+j+'" class="form-control" style="width:100%" value=\"'+conEmail[j]+'\" placeholder="Email" /><span class="error_msg" id="cem_error'+j+'" ></span></div>';
			main_tab += '<div class="col-1 mb-3">';
			main_tab += '<input type="button" name="button'+j+'" id="button'+j+'" value="Delete" class="btn btn-danger" onclick="deleteContactPerson('+j+')" /></div>';
			main_tab += '</div>'; 
			
			j++;
		}
	}
	
	main_tab += '';
	document.getElementById("con_person_div").innerHTML = main_tab;
	document.getElementById("num_rows").value = int_num_rows-1;
	
}
// End of Delete Row

function validateForm() {
  var prevent = '';

  if(document.getElementById("ctype").value == 'i'){		//validation for individual

  let title = document.forms["cust_form"]["ctitle"].value;
  if (title == "") {
	document.getElementById("ctitle_error").innerHTML = "Title must be selected";
	document.getElementById("ctitle").className  = "form-select error";
	prevent = 'yes';
  } else {
	document.getElementById("ctitle_error").innerHTML = "";
	document.getElementById("ctitle").className  = "form-select";
  }
  
  let fname = document.forms["cust_form"]["fname"].value;
  if (fname == "") {
	document.getElementById("fname_error").innerHTML = "First name must be filled out";
	document.getElementById("fname").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("fname_error").innerHTML = "";
	document.getElementById("fname").className  = "form-control";
  }

  let lname = document.forms["cust_form"]["lname"].value;
  if (lname == "") {
	document.getElementById("lname_error").innerHTML = "Last name must be filled out";
	document.getElementById("lname").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("lname_error").innerHTML = "";
	document.getElementById("lname").className  = "form-control";
  }
  
  let mobile = document.forms["cust_form"]["mobile"].value;
  var regPhone=/^\d{10}$/;
  if (mobile == "") {
	document.getElementById("mobile_error").innerHTML = "Mobile no. must be filled";
	document.getElementById("mobile").className  = "form-control error";
	prevent = 'yes';
  } else if (!regPhone.test(mobile)) {
    document.getElementById("mobile_error").innerHTML = "Mobile no. must have 10 digits";
	document.getElementById("mobile").className  = "form-control error";
	prevent = 'yes';
  }else {
	document.getElementById("mobile_error").innerHTML = "";
	document.getElementById("mobile").className  = "form-control";
  }
  
  let addr = document.forms["cust_form"]["address1"].value;
  if (addr == "") {
	document.getElementById("addr_error").innerHTML = "Address must be filled out";
	document.getElementById("address1").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("addr_error").innerHTML = "";
	document.getElementById("address1").className  = "form-control";
  }
  
  let email = document.forms["cust_form"]["email"].value;
  var regEmail=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/g;
  if ((email != "") && (!regEmail.test(email))) {
    document.getElementById("email_error").innerHTML = "Invalid email format";
	document.getElementById("email").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("email_error").innerHTML = "";
	document.getElementById("email").className  = "form-control";
  }
  
  } else {		//validation for company

  let cname = document.forms["cust_form"]["cname"].value;
  if (cname == "") {
	document.getElementById("cname_error").innerHTML = "Company name must be filled out";
	document.getElementById("cname").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("cname_error").innerHTML = "";
	document.getElementById("cname").className  = "form-control";
  }
  
  let phone = document.forms["cust_form"]["phone"].value;
  var regPhone=/^\d{10}$/;
  if (phone == "") {
	document.getElementById("phone_error").innerHTML = "Phone no. must be filled";
	document.getElementById("phone").className  = "form-control error";
	prevent = 'yes';
  } else if (!regPhone.test(phone)) {
    document.getElementById("phone_error").innerHTML = "Phone no. must have 10 digits";
	document.getElementById("phone").className  = "form-control error";
	prevent = 'yes';
  }else {
	document.getElementById("phone_error").innerHTML = "";
	document.getElementById("phone").className  = "form-control";
  }
  
  let email = document.forms["cust_form"]["email"].value;
  var regEmail=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/g;
  if ((email != "") && (!regEmail.test(email))) {
    document.getElementById("email_error").innerHTML = "Invalid email format";
	document.getElementById("email").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("email_error").innerHTML = "";
	document.getElementById("email").className  = "form-control";
  }
  
  let addr = document.forms["cust_form"]["address1"].value;
  if (addr == "") {
	document.getElementById("addr_error").innerHTML = "Address must be filled out";
	document.getElementById("address1").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("addr_error").innerHTML = "";
	document.getElementById("address1").className  = "form-control";
  }
  
  ex_num_rows = document.getElementById("ex_num_rows").value;	//no. of existing contcat person

  for(j=1; j<=ex_num_rows; j++){	//start of existing contact person rows
  
  let confname = document.forms["cust_form"]["ex_confname"+j].value;
  if (confname == "") {
	document.getElementById("ex_cfn_error"+j).innerHTML = "First name must be filled out";
	document.getElementById("ex_confname"+j).className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("ex_cfn_error"+j).innerHTML = "";
	document.getElementById("ex_confname"+j).className  = "form-control";
  }

  let conmobile = document.forms["cust_form"]["ex_conmobile"+j].value;
  var regPhone=/^\d{10}$/;
  if ((conmobile != "") && (!regPhone.test(conmobile))) {
    document.getElementById("ex_cmob_error"+j).innerHTML = "Mobile no. must have 10 digits";
	document.getElementById("ex_conmobile"+j).className  = "form-control error";
	prevent = 'yes';
  }else {
	document.getElementById("ex_cmob_error"+j).innerHTML = "";
	document.getElementById("ex_conmobile"+j).className  = "form-control";
  }
  
  let conemail = document.forms["cust_form"]["ex_conemail"+j].value;
  var regEmail=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/g;
  if ((conemail != "") && (!regEmail.test(conemail))) {
    document.getElementById("ex_cem_error"+j).innerHTML = "Invalid email format";
	document.getElementById("ex_conemail"+j).className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("ex_cem_error"+j).innerHTML = "";
	document.getElementById("ex_conemail"+j).className  = "form-control";
  }

  } //end of existing contact person rows
  
  let conmobile1 = document.forms["cust_form"]["conmobile1"].value;
  var regPhone1=/^\d{10}$/;
  if ((conmobile1 != "") && (!regPhone1.test(conmobile1))) {
    document.getElementById("cmob_error").innerHTML = "Mobile no. must have 10 digits";
	document.getElementById("conmobile1").className  = "form-control error";
	prevent = 'yes';
  }else {
	document.getElementById("cmob_error").innerHTML = "";
	document.getElementById("conmobile1").className  = "form-control";
  }
  
  let conemail1 = document.forms["cust_form"]["conemail1"].value;
  var regEmail1=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/g;
  if ((conemail1 != "") && (!regEmail1.test(conemail1))) {
    document.getElementById("cem_error").innerHTML = "Invalid email format";
	document.getElementById("conemail1").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("cem_error").innerHTML = "";
	document.getElementById("conemail1").className  = "form-control";
  }
  
  num_rows = document.getElementById("num_rows").value;

  for(i=2; i<=num_rows; i++){
  
  let confname = document.forms["cust_form"]["confname"+i].value;
  if (confname == "") {
	document.getElementById("cfn_error"+i).innerHTML = "First name must be filled out";
	document.getElementById("confname"+i).className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("cfn_error"+i).innerHTML = "";
	document.getElementById("confname"+i).className  = "form-control";
  }

  let conmobile = document.forms["cust_form"]["conmobile"+i].value;
  var regPhone=/^\d{10}$/;
  if ((conmobile != "") && (!regPhone.test(conmobile))) {
    document.getElementById("cmob_error"+i).innerHTML = "Mobile no. must have 10 digits";
	document.getElementById("conmobile"+i).className  = "form-control error";
	prevent = 'yes';
  }else {
	document.getElementById("cmob_error"+i).innerHTML = "";
	document.getElementById("conmobile"+i).className  = "form-control";
  }
  
  let conemail = document.forms["cust_form"]["conemail"+i].value;
  var regEmail=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/g;
  if ((conemail != "") && (!regEmail.test(conemail))) {
    document.getElementById("cem_error"+i).innerHTML = "Invalid email format";
	document.getElementById("conemail"+i).className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("cem_error"+i).innerHTML = "";
	document.getElementById("conemail"+i).className  = "form-control";
  }

  }
  
  }

  if(prevent == 'yes'){
	  return false;
  }
}

	</script>

</body>

</html>