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
if(isset($_GET['id'])){
	$pid = $_GET['id'];

	$select_pro = mysqli_query($con, "SELECT * FROM rawmaterial WHERE id = '$pid'");
	$result_pro = mysqli_fetch_array($select_pro);
		$code = $result_pro['code'];
		$name = $result_pro['name'];
		$uom = $result_pro['uom'];
		$cat = $result_pro['category'];
		$rlvl = $result_pro['ro_level'];
		$rqty = $result_pro['ro_qty'];
} else {
	$pid = $code = $name = $uom = $cat = $rlvl = $rqty = '';
}
?>

<body>
	<div class="wrapper">

	<?php include('sidebar.php'); ?>

		<div class="main">
			
		<?php include('topbar.php'); ?>

			<main class="content">
				<div class="container-fluid p-0">

					<div class="row">
					<h1 class="h3 mb-3 col-10">Register Raw Material</h1>
					<div class="col-2" align="right"><a href="raw_material_list.php"><button class="btn btn-warning">View List</button></a></div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">

									<form method="post" name="rawmat_form" action="raw_material_register_submit.php" onsubmit="return validateForm()" >
										<div class="row mb-3" id="alert_div">
											<?php
											if(isset($_SESSION['success']) && $_SESSION['success'] != ''){		//check if success
												echo '<div class="alert alert-success" role="alert"><div class="alert-message">'.$_SESSION['success'].'</div></div>';
												$_SESSION['success'] = '';
											}
											if(isset($_SESSION['error']) && $_SESSION['error'] != ''){			//check if error
												echo '<div class="alert alert-danger" role="alert"><div class="alert-message">'.$_SESSION['error'].'</div></div>';
												$_SESSION['error'] = '';
											}
											?>
										</div>	
										<script>
											setTimeout(function(){
											  document.getElementById('alert_div').innerHTML = '';
											}, 3000);		//clear error message in 3 seconds
										</script>
										<div class="row form-group mb-3">
											<div class="col-4  mb-3">
												<label class="form-label">Code <span style="color:red">*</span></label>
												<input type="text" class="form-control" name="rmcode" id="rmcode" placeholder="Code" value="<?php echo $code; ?>" >
												<input type="hidden" name="cid" id="cid" value="<?php echo $pid; ?>" >
												<span class="error_msg" id="rmcode_error" ></span>
											</div>
											<div class="col-4  mb-3">
												<label class="form-label">Name <span style="color:red">*</span></label>
												<input type="text" class="form-control" name="rmname" id="rmname" placeholder="Name" value="<?php echo $name; ?>" >
												<span class="error_msg" id="rmname_error" ></span>
											</div>
											<div class="col-4  mb-3">
												<label class="form-label">Unit of Measure <span style="color:red">*</span></label>
												<select type="text" class="form-select" name="uom" id="uom" >
													<option value="">-Please Select-</option>
													<?php
													$select_uom = mysqli_query($con, "SELECT id, name FROM unit_of_measure ORDER BY name");
													while($result_uom = mysqli_fetch_array($select_uom)){
													?>
													<option value="<?php echo $result_uom['id']; ?>" <?php if($uom == $result_uom['id']){ echo 'selected'; } ?> ><?php echo $result_uom['name']; ?></option>
													<?php } ?>
												</select>
												<span class="error_msg" id="uom_error" ></span>
											</div>
										</div>

										<div class="row form-group mb-3">
											<div class="col-4 mb-3">
												<label class="form-label">Category <span style="color:red">*</span></label>
												<select type="text" class="form-select" name="category" id="category" >
													<option value="">-Please Select-</option>
													<?php
													$select_cat = mysqli_query($con, "SELECT id, name FROM rawmaterial_category ORDER BY name");
													while($result_cat = mysqli_fetch_array($select_cat)){
													?>
													<option value="<?php echo $result_cat['id']; ?>" <?php if($cat == $result_cat['id']){ echo 'selected'; } ?> ><?php echo $result_cat['name']; ?></option>
													<?php } ?>
												</select>
												<span class="error_msg" id="category_error" ></span>
											</div>
											<div class="col-4 mb-3">
												<label class="form-label">Reorder Level</label>
												<input type="text" class="form-control" name="rlevel" id="rlevel" onkeypress="return isNumberKeyn(event);" placeholder="Reorder Level" value="<?php echo $rlvl; ?>" >
											</div>
											<div class="col-4 mb-3">
												<label class="form-label">Reorder Qty</label>
												<input type="text" class="form-control" name="rqty" id="rqty" onkeypress="return isNumberKeyn(event);" placeholder="Reorder Qty" value="<?php echo $rqty; ?>" >
											</div>
										</div>

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

	function isNumberKeyn(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode;
		if ((charCode > 47 && charCode < 58) || charCode == 46) {	// Allow Numbers, Full Stop, Delete & Back Space
			return true;
		} else {
			return false;
		}
	}

function validateForm() {
  var prevent = '';

  let rmcode = document.forms["rawmat_form"]["rmcode"].value;		//validate code
  if (rmcode == "") {
	document.getElementById("rmcode_error").innerHTML = "Code must be filled";	//display error message
	document.getElementById("rmcode").className  = "form-control error";		//focus input field
	prevent = 'yes';
  } else {
	document.getElementById("rmcode_error").innerHTML = "";				//clear error message
	document.getElementById("rmcode").className  = "form-control";		//remove focus
  }
  
  let rmname = document.forms["rawmat_form"]["rmname"].value;		//validate name
  if (rmname == "") {
	document.getElementById("rmname_error").innerHTML = "Name must be filled";
	document.getElementById("rmname").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("rmname_error").innerHTML = "";
	document.getElementById("rmname").className  = "form-control";
  }
  
  let uom = document.forms["rawmat_form"]["uom"].value;				//validate unit of measure
  if (uom == "") {
	document.getElementById("uom_error").innerHTML = "Unit must be filled";
	document.getElementById("uom").className  = "form-select error";
	prevent = 'yes';
  } else {
	document.getElementById("uom_error").innerHTML = "";
	document.getElementById("uom").className  = "form-select";
  }
  
  let category = document.forms["rawmat_form"]["category"].value;	//validate category
  if (category == "") {
	document.getElementById("category_error").innerHTML = "Category must be filled";
	document.getElementById("category").className  = "form-select error";
	prevent = 'yes';
  } else {
	document.getElementById("category_error").innerHTML = "";
	document.getElementById("category").className  = "form-select";
  }
  
  if(prevent == 'yes'){
	  return false;				//prevent form submit if errors exits
  }
}

	</script>

</body>

</html>