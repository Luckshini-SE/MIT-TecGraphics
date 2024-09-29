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
					<h1 class="h3 mb-3 col-10">Return Raw Material</h1>
					<div class="col-2" align="right"><a href="return_rawmat_list.php"><button class="btn btn-warning">View List</button></a></div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">

									<form method="post" name="return_form" action="return_rawmat_submit.php" onsubmit="return validateForm()" >
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

											$select_max = mysqli_query($con, "SELECT return_no FROM `return_summary` ORDER BY id DESC");
											if(mysqli_num_rows($select_max) > 0){
												$result_max = mysqli_fetch_array($select_max);
													$temp = substr($result_max['return_no'], 2);
													$max = $temp+1;
													$return_no = 'MR'.$max;
											} else {
												$return_no = 'MR10001';
											}
											?>
											<div class="col-2 mb-3">
												<label class="form-label">Return Note No. </label>
												<input type="text" class="form-control" name="return_num" id="return_num" value="<?php echo $return_no; ?>" readonly >
											</div>
											<div class="col-3 mb-3">
												<label class="form-label">Return Date <span style="color:red">*</span></label>
												<input type="text" class="form-control flatpickr-minimum flatpickr-input" name="return_date" id="return_date" value="<?php echo $cur_date; ?>" readonly >
											</div>
											<div class="col-3 mb-3">
												<label class="form-label">Issue Note No. <span style="color:red">*</span></label>
												<select class="form-select" name="issue_no" id="issue_no" onchange="get_details()" >
													<option value="">-Please Select-</option>
													<?php
													$select_iss = mysqli_query($con, "SELECT issue_no FROM issue_summary");
													while($result_iss = mysqli_fetch_array($select_iss)){
													?>
													<option value="<?php echo $result_iss['issue_no']; ?>"><?php echo $result_iss['issue_no']; ?></option>
													<?php } ?>
												</select>
												<span class="error_msg" id="issue_error" ></span>
											</div>
											<div class="col-4 mb-3">
												&nbsp;
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
		var issue_no = document.getElementById('issue_no').value;
		
		const xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("item_div").innerHTML = this.responseText;
			}
		};
		xhttp.open("GET", "get_return_details.php?issueno="+issue_no);
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

function chkava(i){
	var ava = parseFloat(document.getElementById("ava"+i).value);
	var qty = parseFloat(document.getElementById("qty"+i).value);

	if(ava < qty){
		alert('Entered qty cannot be more than  qty!');
		document.getElementById("qty"+i).value = '';
	}
}

function selectrow(i){
	if(document.getElementById("select"+i).checked == true){
		document.getElementById("qty"+i).readOnly = false;
	} else {
		document.getElementById("qty"+i).readOnly = true;
	}
}


function validateForm() {
  var prevent = '';

  let issue_no = document.forms["return_form"]["issue_no"].value;
  if (issue_no == "") {
	document.getElementById("issue_error").innerHTML = "Issue no. must be selected";
	document.getElementById("issue_no").className  = "form-select error";
	prevent = 'yes';
  } else {
	document.getElementById("issue_error").innerHTML = "";
	document.getElementById("issue_no").className  = "form-select";
  }
  
  var num_rows = document.getElementById("num_rows").value;

  for(i=1; i<=num_rows; i++){
	if(document.getElementById("select"+i).checked == true){
	  let qty = document.forms["return_form"]["qty"+i].value;
	  if (qty == "") {
		document.getElementById("qty"+i).className  = "form-control error";
		prevent = 'yes';
	  } else {
		document.getElementById("qty"+i).className  = "form-control";
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