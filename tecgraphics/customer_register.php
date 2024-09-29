<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('header.php'); ?>
	
	<style>
	
	.error_msg {
		color: rgba(255,0,0,.80);
	}

	.error {
		box-shadow:0 0 0 .2rem rgba(255,0,0,.45);
	}

	</style>
</head>

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

									<form method="post" name="cust_form" action="customer_register_submit.php" onsubmit="return validateForm()" >
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
										<div class="row">
											<div class="col-4 mb-3">
												<label class="form-label">Customer Type</label>
												<select class="form-select mb-3" name="ctype" id="ctype" onchange="get_details()">
												  <option value="">-Please Select-</option>
												  <option value="i">Individual</option>
												  <option value="c">Company</option>
												</select>
											</div>
										</div>

										<div id="show_details">

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
  
  let contitle1 = document.forms["cust_form"]["contitle1"].value;
  if (contitle1 == "") {
	document.getElementById("cont_error").innerHTML = "Title must be selected";
	document.getElementById("contitle1").className  = "form-select error";
	prevent = 'yes';
  } else {
	document.getElementById("cont_error").innerHTML = "";
	document.getElementById("contitle1").className  = "form-select";
  }
  
  let confname1 = document.forms["cust_form"]["confname1"].value;
  if (confname1 == "") {
	document.getElementById("cfn_error").innerHTML = "First name must be filled out";
	document.getElementById("confname1").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("cfn_error").innerHTML = "";
	document.getElementById("confname1").className  = "form-control";
  }

  let conlname1 = document.forms["cust_form"]["conlname1"].value;
  if (conlname1 == "") {
	document.getElementById("cln_error").innerHTML = "Last name must be filled out";
	document.getElementById("conlname1").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("cln_error").innerHTML = "";
	document.getElementById("conlname1").className  = "form-control";
  }
  
  let conmobile1 = document.forms["cust_form"]["conmobile1"].value;
  var regPhone1=/^\d{10}$/;
  if (conmobile1 == "") {
	document.getElementById("cmob_error").innerHTML = "Mobile no. must be filled";
	document.getElementById("conmobile1").className  = "form-control error";
	prevent = 'yes';
  } else if (!regPhone1.test(conmobile1)) {
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