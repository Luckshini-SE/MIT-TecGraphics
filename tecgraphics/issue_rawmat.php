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

<body>
	<div class="wrapper">

	<?php include('sidebar.php'); ?>

		<div class="main">
			
		<?php include('topbar.php'); ?>

			<main class="content">
				<div class="container-fluid p-0">

					<div class="row">
					<h1 class="h3 mb-3 col-10">Issue Raw Material</h1>
					<div class="col-2" align="right"><a href="issue_rawmat_list.php"><button class="btn btn-warning">View List</button></a></div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">

									<form method="post" name="issue_form" action="issue_rawmat_submit.php" onsubmit="return validateForm()" >
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
										<div class="row form-group mb-3">
											<?php
											//Set time zone
											$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
											$cur_date = $createToday->format('Y-m-d');

											$select_max = mysqli_query($con, "SELECT issue_no FROM `issue_summary` ORDER BY id DESC");
											if(mysqli_num_rows($select_max) > 0){
												$result_max = mysqli_fetch_array($select_max);
													$temp = substr($result_max['issue_no'], 2);
													$max = $temp+1;
													$issue_no = 'MI'.$max;
											} else {
												$issue_no = 'MI10001';
											}
											?>
											<div class="col-2  mb-3">
												<label class="form-label">Issue Note No. </label>
												<input type="text" class="form-control" name="issue_num" id="issue_num" value="<?php echo $issue_no; ?>" readonly >
											</div>
											<div class="col-3  mb-3">
												<label class="form-label">Issued Date <span style="color:red">*</span></label>
												<input type="text" class="form-control flatpickr-minimum flatpickr-input" name="issue_date" id="issue_date" value="<?php echo $cur_date; ?>" readonly >
											</div>
											<div class="col-3  mb-3">
												<label class="form-label">Job No. <span style="color:red">*</span></label>
												<select class="form-select" name="job_no" id="job_no" onchange="get_details()" >
													<option value="">-Please Select-</option>
													<?php
													$select_job = mysqli_query($con, "SELECT j.id, j.jobno, d.qty, d.completed_qty FROM jobcard j, jobcard_details d WHERE j.id = d.jobcard_id GROUP BY j.jobno HAVING d.qty > d.completed_qty");
													while($result_job = mysqli_fetch_array($select_job)){
													?>
													<option value="<?php echo $result_job['jobno']; ?>"><?php echo $result_job['jobno']; ?></option>
													<?php } ?>
												</select>
												<span class="error_msg" id="jobno_error" ></span>
											</div>
											<div class="col-4  mb-3">
												<label class="form-label">Issued To <span style="color:red">*</span></label>
												<input type="text" class="form-control" name="issue_to" id="issue_to" >
												<span class="error_msg" id="isto_error" ></span>
											</div>
										</div>

										<div id="item_div"></div>

										
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
		document.addEventListener("DOMContentLoaded", function() {
			// Flatpickr
			flatpickr(".flatpickr-minimum", {
				maxDate: "today"
			});
		});
	</script>

	<script>

	function get_details(){
		var job_no = document.getElementById('job_no').value;
		
		const xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("item_div").innerHTML = this.responseText;
			}
		};
		xhttp.open("GET", "get_issue_details.php?jobno="+job_no);
		xhttp.send();
	}

	function isNumberKey(evt){

		var charCode = (evt.which) ? evt.which : event.keyCode;
		if (charCode == 8 || (charCode > 47 && charCode < 58)) { // Allow Numbers, Delete & Back Space
			return true;
		} else {
			return false;
		}
	}

	function isNumberKeyn(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode;
		if ((charCode > 47 && charCode < 58) || charCode == 46) {	// Allow Numbers, Full Stop, Delete & Back Space
			return true;
		} else {
			return false;
		}
	}

	function format_number(pnumber, decimals) {
		if (isNaN(pnumber)) {
			return 0
		};
		if (pnumber == '') {
			return 0
		};

		var snum = new String(pnumber);
		var sec = snum.split('.');
		var whole = parseFloat(sec[0]);
		var result = '';

		if (sec.length > 1) {
			var dec = new String(sec[1]);
			dec = String(parseFloat(sec[1]) / Math.pow(10, (dec.length - decimals)));
			dec = String(whole + Math.round(parseFloat(dec)) / Math.pow(10, decimals));
			var dot = dec.indexOf('.');
			if (dot == -1) {
				dec += '.';
				dot = dec.indexOf('.');
			}
			while (dec.length <= dot + decimals) {
				dec += '0';
			}
			result = dec;
		} else {
			var dot;
			var dec = new String(whole);
			dec += '.';
			dot = dec.indexOf('.');
			while (dec.length <= dot + decimals) {
				dec += '0';
			}
			result = dec;
		}
		return result;
	}
	
	function browseList(i){
		window.open("select_rawmaterial_issue.php?row="+i,"_blank","width=500,height=400");
	}
	
	function add_more(){

	var item = new Array();
	var itemid = new Array();
	var ava = new Array();
	var qty = new Array();
	
	int_num_rows = parseInt(document.getElementById("num_rows").value);
	total_rows = int_num_rows+1;
	
	for(i=2; i<total_rows; i++){
		item[i]	= document.getElementById("item"+i).value;
		itemid[i]	= document.getElementById("itemid"+i).value;
		ava[i]	= document.getElementById("ava"+i).value;
		qty[i]	= document.getElementById("qty"+i).value;
	}
	
	document.getElementById("item_div2").innerHTML = "";
	main_tab = '';
	
		
	for (i=2; i<=total_rows; i++) {
		if (i == total_rows) {
			
			
			main_tab += '<div class="row form-group mb-3">';
			main_tab += '<div class="col-5">';
			main_tab += '<input class="form-control" id="item'+i+'" name="item'+i+'" type="text" placeholder="Raw Material" onclick="browseList('+i+')" readonly /><input class="form-control" id="itemid'+i+'" name="itemid'+i+'" type="hidden" /></div>';
			main_tab += '<div class="col-2">';
			main_tab += '<input class="form-control " id="ava'+i+'" name="ava'+i+'" type="text" placeholder="Available" readonly /></div>';
			main_tab += '<div class="col-2">';
			main_tab += '<input class="form-control " id="qty'+i+'" name="qty'+i+'" type="text" placeholder="Qty" onkeypress="return isNumberKeyn(event);" onchange="chkava('+i+')" /></div>';
			main_tab += '<div class="col-1 mb-3">';
			main_tab += '<button type="button" name="button'+i+'" id="button'+i+'" class="btn btn-danger" onclick="deleteRow('+i+')" ><b>&times;</b></button></div>';
			main_tab += '</div>';
		    
		}
		
		else {
			
			main_tab += '<div class="row form-group mb-3">';
			main_tab += '<div class="col-5">';
			main_tab += '<input type="text" name="item'+i+'" id="item'+i+'" class="form-control" value=\"'+item[i]+'\" placeholder="Raw Material" onclick="browseList('+i+')" readonly /><input class="form-control" id="itemid'+i+'" name="itemid'+i+'" value=\"'+itemid[i]+'\" type="hidden" /></div>';
			main_tab += '<div class="col-2">';
			main_tab += '<input type="text" name="ava'+i+'" id="ava'+i+'" class="form-control" value=\"'+ava[i]+'\" placeholder="Available" readonly /></div>';
			main_tab += '<div class="col-2">';
			main_tab += '<input type="text" name="qty'+i+'" id="qty'+i+'" class="form-control"  value=\"'+qty[i]+'\" placeholder="Qty" onkeypress="return isNumberKeyn(event);" onchange="chkava('+i+')" /></div>';
			main_tab += '<div class="col-1 mb-3">';
			main_tab += '<button type="button" name="button'+i+'" id="button'+i+'" class="btn btn-danger" onclick="deleteRow('+i+')" ><b>&times;</b></button></div>';
			main_tab += '</div>';

		}
	}
	
	main_tab += "";
	
	document.getElementById("item_div2").innerHTML = main_tab;
	document.getElementById("num_rows").value = total_rows;
}
// End of Ad Row


// Delete Row
function deleteRow(row) {

	var item = new Array();
	var itemid = new Array();
	var ava = new Array();
	var qty = new Array();
	
	
	int_num_rows = parseInt(document.getElementById("num_rows").value);
	row = parseInt(row);
	k = 2;
	m = k;
	
	for (; k<=int_num_rows; k++) {
		if (k == row) {			
		}
		else {		
			item[m]	= document.getElementById("item"+k).value;
			itemid[m]	= document.getElementById("itemid"+k).value;
			ava[m]	= document.getElementById("ava"+k).value;
			qty[m]= document.getElementById("qty"+k).value;
			m++;
		}
	}
	
	document.getElementById("item_div2").innerHTML = "";
	main_tab = '';
	
	i = 2;
	j = i;
	for (; i<=int_num_rows; i++) {
		if (i == row) { 
		}
		else {
			
			main_tab += '<div class="row form-group mb-3">';
			main_tab += '<div class="col-5">';
			main_tab += '<input type="text" name="item'+j+'" id="item'+j+'" class="form-control" value=\"'+item[j]+'\" placeholder="Raw Material" onclick="browseList('+j+')" readonly /><input class="form-control" id="itemid'+j+'" name="itemid'+j+'" value=\"'+itemid[j]+'\" type="hidden" /></div>';
			main_tab += '<div class="col-2">';
			main_tab += '<input type="text" name="ava'+j+'" id="ava'+j+'" class="form-control" value=\"'+ava[j]+'\" placeholder="Available" readonly /></div>';
			main_tab += '<div class="col-2 mb-3">';
			main_tab += '<input type="text" name="qty'+j+'" id="qty'+j+'" class="form-control" value=\"'+qty[j]+'\"  placeholder="Qty" onkeypress="return isNumberKeyn(event);" onchange="chkava('+j+')" /></div>';
			main_tab += '<div class="col-1 mb-3">';
			main_tab += '<button type="button" name="button'+j+'" id="button'+j+'" class="btn btn-danger" onclick="deleteRow('+j+')" ><b>&times;</b></button></div>';
			main_tab += '</div>'; 
			
			j++;
		}
	}
	
	main_tab += '';
	document.getElementById("item_div2").innerHTML = main_tab;
	document.getElementById("num_rows").value = int_num_rows-1;

}
// End of Delete Row

function chkava(i){
	var ava = parseFloat(document.getElementById("ava"+i).value);
	var qty = parseFloat(document.getElementById("qty"+i).value);

	if(ava < qty){
		alert('Entered qty cannot be more than available qty!');
		document.getElementById("qty"+i).value = '';
	}
}


function validateForm() {
  var prevent = '';

  let job_no = document.forms["issue_form"]["job_no"].value;
  if (job_no == "") {
	document.getElementById("jobno_error").innerHTML = "Job no. must be selected";
	document.getElementById("job_no").className  = "form-select error";
	prevent = 'yes';
  } else {
	document.getElementById("jobno_error").innerHTML = "";
	document.getElementById("job_no").className  = "form-select";
  }
  
  let issue_to = document.forms["issue_form"]["issue_to"].value;
  if (issue_to == "") {
	document.getElementById("isto_error").innerHTML = "Issued to must be filled";
	document.getElementById("issue_to").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("isto_error").innerHTML = "";
	document.getElementById("issue_to").className  = "form-control";
  }

  var num_rows = document.getElementById("num_rows").value;

  for(i=1; i<=num_rows; i++){

  let item = document.forms["issue_form"]["item"+i].value;
  if (item == "") {
	document.getElementById("item"+i).className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("item"+i).className  = "form-control";
  }
  
  let qty = document.forms["issue_form"]["qty"+i].value;
  if (qty == "") {
	document.getElementById("qty"+i).className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("qty"+i).className  = "form-control";
  }

  }

  if(prevent == 'yes'){
	  return false;
  }
}

	</script>

</body>

</html>