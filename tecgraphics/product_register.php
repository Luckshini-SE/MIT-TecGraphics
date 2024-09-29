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

	$select_pro = mysqli_query($con, "SELECT `name`, `material`, `size`, `finishing`, `color`, `spec1`, `spec2`, `pricing`, `image1`, `image2`, `image3` FROM products WHERE id = '$pid'");
	$result_pro = mysqli_fetch_array($select_pro);
		$name = $result_pro['name'];
		$material = $result_pro['material'];
		$size = $result_pro['size'];
		$finishing = $result_pro['finishing'];
		$color = $result_pro['color'];
		$spec1 = $result_pro['spec1'];
		$spec2 = $result_pro['spec2'];
		$pricing = $result_pro['pricing'];
		$image1 = $result_pro['image1'];
		$image2 = $result_pro['image2'];
		$image3 = $result_pro['image3'];
} else {
	$pid = $name = $image1 = $image2 = $image3 = $pricing = '';
	$material = $size = $finishing = $color = $spec1 = $spec2 = 0;
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
					<h1 class="h3 mb-3 col-10">Product</h1>
					<div class="col-2" align="right"><a href="product_list.php"><button class="btn btn-warning">View List</button></a></div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">

									<form method="post" name="prod_form" action="product_register_submit.php" enctype="multipart/form-data" onsubmit="return validateForm()" >
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
											<div class="col-4 mb-3">
												<label class="form-label">Product Name <span style="color:red">*</span></label>
												<input type="text" class="form-control" name="pname" id="pname" placeholder="Product Name" value="<?php echo $name; ?>" >
												<input type="hidden" name="pid" id="pid" value="<?php echo $pid; ?>" >
												<span class="error_msg" id="pname_error" ></span>
											</div>
											<div class="col-4 mb-3">
												<label class="form-label">Pricing <span style="color:red">*</span></label>
												<select class="form-select" name="pricing" id="pricing" >
													<option value="">- Please Select -</option>
													<?php
													$select_pri = mysqli_query($con, "SELECT id, name FROM pricing");
													while($result_pri = mysqli_fetch_array($select_pri)){
													?>
													<option value="<?php echo $result_pri['id']; ?>" <?php if($pricing == $result_pri['id']){ echo 'selected'; } ?> ><?php echo $result_pri['name']; ?></option>
													<?php } ?>
												</select>
												<span class="error_msg" id="price_error" ></span>
											</div>
										</div>

										<div class="row form-group mb-3">
											<div class="col-4 mb-3">
												<label class="form-label">Image 1 <span style="color:red">*</span>  <?php if($image1 != ''){ ?>[<a href="assets/img/portfolio/<?php echo $image1; ?>" target="_blank">View</a>]<?php } ?></label>
												<input type="file" class="form-control" name="pimg1" id="pimg1" >
												<span class="error_msg" id="pimg1_error" ></span>
											</div>
											<div class="col-4 mb-3">
												<label class="form-label">Image 2  <?php if($image2 != ''){ ?>[<a href="assets/img/portfolio/<?php echo $image2; ?>" target="_blank">View</a>]<?php } ?></label>
												<input type="file" class="form-control" name="pimg2" id="pimg2" >
											</div>
											<div class="col-4 mb-3">
												<label class="form-label">Image 3  <?php if($image3 != ''){ ?>[<a href="assets/img/portfolio/<?php echo $image3; ?>" target="_blank">View</a>]<?php } ?></label>
												<input type="file" class="form-control" name="pimg3" id="pimg3" >
											</div>
										</div>

										<!--Material Section-->
										<div class="row form-group mb-3">
											<div class="col-3 mb-3">
												<label class="form-label"><b>Type/Material</b></label>
											</div>
											<div class="col-1 mb-3 form-check form-switch" style="margin-top: 3px">
												<input class="form-check-input" type="checkbox" name="mat_check" id="mat_check" <?php if($material == 1){ echo 'checked'; } ?> onchange="enable_div('mat')" >
											</div>
										</div>
										
										<div id="mat_div" <?php if($material == 0){ ?>style="display:none;"<?php } ?>>

										<?php 
										$j=1;
										if($material == 1){ 

										$select_mat = mysqli_query($con, "SELECT * FROM pro_material WHERE prod_id = '$pid'");
										while($result_mat = mysqli_fetch_array($select_mat)){
										?>
										<div class="row form-group mb-3">
											<div class="col-4  mb-3">
												<input type="text" class="form-control" name="ex_mat_name<?php echo $j; ?>" id="ex_mat_name<?php echo $j; ?>" value="<?php echo $result_mat['name']; ?>" >
												<input type="hidden" name="ex_mat_id<?php echo $j; ?>" id="ex_mat_id<?php echo $j; ?>" value="<?php echo $result_mat['id']; ?>" >
											</div>
											<div class="col-2  mb-3">
												<input type="checkbox" name="ex_mat_rem<?php echo $j; ?>" id="ex_mat_rem<?php echo $j; ?>" > Remove
											</div>
										</div>
										<?php $j++;	}} ?>
										<input type="hidden" name="ex_mat_num_rows" id="ex_mat_num_rows" value="<?php echo $j-1; ?>" >

										<div class="row form-group mb-3">
											<div class="col-4  mb-3">
												<input type="text" class="form-control" name="mat_name1" id="mat_name1" >
											</div>
											
											<div id="mat_add_div"></div>

											<input type="hidden" name="mat_num_rows" id="mat_num_rows" value="1" >

											<div class="mb-3">
												<input type="button" class="btn btn-primary" value="Add More" onclick="add_more('mat')" >
											</div>

										</div>
										</div>
										<!--Material Section-->
										
										<!--Size Section-->
										<div class="row form-group mb-3">
											<div class="col-3 mb-3">
												<label class="form-label"><b>Size</b></label>
											</div>
											<div class="col-1 mb-3 form-check form-switch" style="margin-top: 3px">
												<input class="form-check-input" type="checkbox" name="siz_check" id="siz_check" <?php if($size == 1){ echo 'checked'; } ?> onchange="enable_div('siz')" >
											</div>
										</div>
										
										<div id="siz_div" <?php if($size == 0){ ?>style="display:none;"<?php } ?>>
										
										<?php 
										$k=1;
										if($size == 1){ 

										$select_siz = mysqli_query($con, "SELECT * FROM pro_size WHERE prod_id = '$pid'");
										while($result_siz = mysqli_fetch_array($select_siz)){
										?>
										<div class="row form-group mb-3">
											<div class="col-4  mb-3">
												<input type="text" class="form-control" name="ex_siz_name<?php echo $k; ?>" id="ex_siz_name<?php echo $k; ?>" value="<?php echo $result_siz['name']; ?>" >
												<input type="hidden" name="ex_siz_id<?php echo $k; ?>" id="ex_siz_id<?php echo $k; ?>" value="<?php echo $result_siz['id']; ?>" >
											</div>
											<div class="col-2  mb-3">
												<input type="checkbox" name="ex_siz_rem<?php echo $k; ?>" id="ex_siz_rem<?php echo $k; ?>" > Remove
											</div>
										</div>
										<?php $k++;	}} ?>
										<input type="hidden" name="ex_siz_num_rows" id="ex_siz_num_rows" value="<?php echo $k-1; ?>" >

										<div class="row form-group mb-3">
											<div class="col-4  mb-3">
												<input type="text" class="form-control" name="siz_name1" id="siz_name1" >
											</div>
											
											<div id="siz_add_div"></div>

											<input type="hidden" name="siz_num_rows" id="siz_num_rows" value="1" >

											<div class="mb-3">
												<input type="button" class="btn btn-primary" value="Add More" onclick="add_more('siz')" >
											</div>

										</div>
										</div>
										<!--Size Section-->
										
										<!--Finishing Section-->
										<div class="row form-group mb-3">
											<div class="col-3 mb-3">
												<label class="form-label"><b>Finishing</b></label>
											</div>
											<div class="col-1 mb-3 form-check form-switch" style="margin-top: 3px">
												<input class="form-check-input" type="checkbox" name="fin_check" id="fin_check" <?php if($finishing == 1){ echo 'checked'; } ?> onchange="enable_div('fin')" >
											</div>
										</div>
										
										<div id="fin_div" <?php if($finishing == 0){ ?>style="display:none;"<?php } ?>>
										
										<?php 
										$l=1;
										if($finishing == 1){ 

										$select_fin = mysqli_query($con, "SELECT * FROM pro_finishing WHERE prod_id = '$pid'");
										while($result_fin = mysqli_fetch_array($select_fin)){
										?>
										<div class="row form-group mb-3">
											<div class="col-4  mb-3">
												<input type="text" class="form-control" name="ex_fin_name<?php echo $l; ?>" id="ex_fin_name<?php echo $l; ?>" value="<?php echo $result_fin['name']; ?>" >
												<input type="hidden" name="ex_fin_id<?php echo $l; ?>" id="ex_fin_id<?php echo $l; ?>" value="<?php echo $result_fin['id']; ?>" >
											</div>
											<div class="col-2  mb-3">
												<input type="checkbox" name="ex_fin_rem<?php echo $l; ?>" id="ex_fin_rem<?php echo $l; ?>" > Remove
											</div>
										</div>
										<?php $l++;	}} ?>
										<input type="hidden" name="ex_fin_num_rows" id="ex_fin_num_rows" value="<?php echo $l-1; ?>" >

										<div class="row form-group mb-3">
											<div class="col-4  mb-3">
												<input type="text" class="form-control" name="fin_name1" id="fin_name1" >
											</div>
											
											<div id="fin_add_div"></div>

											<input type="hidden" name="fin_num_rows" id="fin_num_rows" value="1" >

											<div class="mb-3">
												<input type="button" class="btn btn-primary" value="Add More" onclick="add_more('fin')" >
											</div>

										</div>
										</div>
										<!--Finishing Section-->
										
										<!--Colour Section-->
										<div class="row form-group mb-3">
											<div class="col-3 mb-3">
												<label class="form-label"><b>Colour</b></label>
											</div>
											<div class="col-1 mb-3 form-check form-switch" style="margin-top: 3px">
												<input class="form-check-input" type="checkbox" name="col_check" id="col_check" <?php if($color == 1){ echo 'checked'; } ?> onchange="enable_div('col')" >
											</div>
										</div>
										
										<div id="col_div" <?php if($color == 0){ ?>style="display:none;"<?php } ?>>
										
										<?php 
										$m=1;
										if($color == 1){ 

										$select_col = mysqli_query($con, "SELECT * FROM pro_color WHERE prod_id = '$pid'");
										while($result_col = mysqli_fetch_array($select_col)){
										?>
										<div class="row form-group mb-3">
											<div class="col-4  mb-3">
												<input type="text" class="form-control" name="ex_col_name<?php echo $m; ?>" id="ex_col_name<?php echo $m; ?>" value="<?php echo $result_col['name']; ?>" >
												<input type="hidden" name="ex_col_id<?php echo $m; ?>" id="ex_col_id<?php echo $m; ?>" value="<?php echo $result_col['id']; ?>" >
											</div>
											<div class="col-2  mb-3">
												<input type="checkbox" name="ex_col_rem<?php echo $m; ?>" id="ex_col_rem<?php echo $m; ?>" > Remove
											</div>
										</div>
										<?php $m++;	}} ?>
										<input type="hidden" name="ex_col_num_rows" id="ex_col_num_rows" value="<?php echo $m-1; ?>" >

										<div class="row form-group mb-3">
											<div class="col-4  mb-3">
												<input type="text" class="form-control" name="col_name1" id="col_name1" >
											</div>
											
											<div id="col_add_div"></div>

											<input type="hidden" name="col_num_rows" id="col_num_rows" value="1" >

											<div class="mb-3">
												<input type="button" class="btn btn-primary" value="Add More" onclick="add_more('col')" >
											</div>

										</div>
										</div>
										<!--Colour Section-->
										
										<!--Specification 1 Section-->
										<div class="row form-group mb-3">
											<div class="col-3 mb-3">
												<label class="form-label"><b>Specification 1</b></label>
											</div>
											<div class="col-1 mb-3 form-check form-switch" style="margin-top: 3px">
												<input class="form-check-input" type="checkbox" name="spo_check" id="spo_check" <?php if($spec1 == 1){ echo 'checked'; } ?> onchange="enable_div('spo')" >
											</div>
										</div>
										
										<div id="spo_div" <?php if($spec1 == 0){ ?>style="display:none;"<?php } ?>>
										
										<?php 
										$n=1;
										if($spec1 == 1){ 

										$select_spo = mysqli_query($con, "SELECT * FROM pro_spec1 WHERE prod_id = '$pid'");
										while($result_spo = mysqli_fetch_array($select_spo)){
										?>
										<div class="row form-group mb-3">
											<div class="col-4  mb-3">
												<input type="text" class="form-control" name="ex_spo_name<?php echo $n; ?>" id="ex_spo_name<?php echo $n; ?>" value="<?php echo $result_spo['name']; ?>" >
												<input type="hidden" name="ex_spo_id<?php echo $n; ?>" id="ex_spo_id<?php echo $n; ?>" value="<?php echo $result_spo['id']; ?>" >
											</div>
											<div class="col-2  mb-3">
												<input type="checkbox" name="ex_spo_rem<?php echo $n; ?>" id="ex_spo_rem<?php echo $n; ?>" > Remove
											</div>
										</div>
										<?php $n++;	}} ?>
										<input type="hidden" name="ex_spo_num_rows" id="ex_spo_num_rows" value="<?php echo $n-1; ?>" >

										<div class="row form-group mb-3">
											<div class="col-4  mb-3">
												<input type="text" class="form-control" name="spo_name1" id="spo_name1" >
											</div>
											
											<div id="spo_add_div"></div>

											<input type="hidden" name="spo_num_rows" id="spo_num_rows" value="1" >

											<div class="mb-3">
												<input type="button" class="btn btn-primary" value="Add More" onclick="add_more('spo')" >
											</div>

										</div>
										</div>
										<!--Specification 1 Section-->
										
										<!--Specification 2 Section-->
										<div class="row form-group mb-3">
											<div class="col-3 mb-3">
												<label class="form-label"><b>Specification 2</b></label>
											</div>
											<div class="col-1 mb-3 form-check form-switch" style="margin-top: 3px">
												<input class="form-check-input" type="checkbox" name="spt_check" id="spt_check" <?php if($spec2 == 1){ echo 'checked'; } ?> onchange="enable_div('spt')" >
											</div>
										</div>
										
										<div id="spt_div" <?php if($spec2 == 0){ ?>style="display:none;"<?php } ?>>
										
										<?php 
										$o=1;
										if($spec2 == 1){ 

										$select_spt = mysqli_query($con, "SELECT * FROM pro_spec2 WHERE prod_id = '$pid'");
										while($result_spt = mysqli_fetch_array($select_spt)){
										?>
										<div class="row form-group mb-3">
											<div class="col-4  mb-3">
												<input type="text" class="form-control" name="ex_spt_name<?php echo $o; ?>" id="ex_spt_name<?php echo $o; ?>" value="<?php echo $result_spt['name']; ?>" >
												<input type="hidden" name="ex_spt_id<?php echo $o; ?>" id="ex_spt_id<?php echo $o; ?>" value="<?php echo $result_spt['id']; ?>" >
											</div>
											<div class="col-2  mb-3">
												<input type="checkbox" name="ex_spt_rem<?php echo $o; ?>" id="ex_spt_rem<?php echo $o; ?>" > Remove
											</div>
										</div>
										<?php $o++;	}} ?>
										<input type="hidden" name="ex_spt_num_rows" id="ex_spt_num_rows" value="<?php echo $o-1; ?>" >

										<div class="row form-group mb-3">
											<div class="col-4  mb-3">
												<input type="text" class="form-control" name="spt_name1" id="spt_name1" >
											</div>
											
											<div id="spt_add_div"></div>

											<input type="hidden" name="spt_num_rows" id="spt_num_rows" value="1" >

											<div class="mb-3">
												<input type="button" class="btn btn-primary" value="Add More" onclick="add_more('spt')" >
											</div>

										</div>
										</div>
										<!--Specification 2 Section-->

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

function enable_div(a) {
	if(document.getElementById(a+"_check").checked == true){
		document.getElementById(a+"_div").style.display = 'block';
	} else {
		document.getElementById(a+"_div").style.display = 'none';
	}
}

function add_more(a){

	var newdata = new Array();
	
	int_num_rows = parseInt(document.getElementById(a+"_num_rows").value);
	total_rows = int_num_rows+1;
	
	for(i=2; i<total_rows; i++){
		newdata[i]	= document.getElementById(a+"_name"+i).value;
	}
	
	document.getElementById(a+"_add_div").innerHTML = "";
	main_tab = '';
	
	for (i=2; i<=total_rows; i++) {
		if (i == total_rows) {
			
			main_tab += '<div class="row form-group">';
			main_tab += '<div class="col-4 mb-3">';
			main_tab += '<input class="form-control" id="'+a+'_name'+i+'" name="'+a+'_name'+i+'" type="text" /></div>';
			main_tab += '<div class="col-1 mb-3">';
			main_tab += '<input type="button" name="button'+i+'" id="button'+i+'" value="Delete" class="btn btn-danger" onclick="deleteContactPerson(\''+a+'\','+i+')" /></div>';
			main_tab += '</div>';
		    
		} else {
			
			main_tab += '<div class="row form-group">';
			main_tab += '<div class="col-4 mb-3">';
			main_tab += '<input type="text" name="'+a+'_name'+i+'" id="'+a+'_name'+i+'" class="form-control" value=\"'+newdata[i]+'\" /></div>';
			main_tab += '<div class="col-1 mb-3">';
			main_tab += '<input type="button" name="button'+i+'" id="button'+i+'" value="Delete" class="btn btn-danger" onclick="deleteContactPerson(\''+a+'\','+i+')" /></div>';
			main_tab += '</div>';

		}
	}
	
	document.getElementById(a+"_add_div").innerHTML = main_tab;
	document.getElementById(a+"_num_rows").value = total_rows;
}
// End of Ad Row


// Delete Row
function deleteContactPerson(a,row) { 
	
	var newdata = new Array();
	
	int_num_rows = parseInt(document.getElementById(a+"_num_rows").value);
	row = parseInt(row);
	k = 2;
	m = k;
	
	for (; k<=int_num_rows; k++) {
		if (k == row) {			
		}
		else {		
			newdata[m]	= document.getElementById(a+"_name"+k).value;
			m++;
		}
	}
	
	document.getElementById(a+"_add_div").innerHTML = "";
	main_tab = '';
	
	i = 2;
	j = i;
	for (; i<=int_num_rows; i++) {
		if (i == row) { 
		}
		else {
			
			main_tab += '<div class="row form-group">';
			main_tab += '<div class="col-4 mb-3">';
			main_tab += '<input type="text" name="'+a+'_name'+j+'" id="'+a+'_name'+j+'" class="form-control" style="width:100%" value=\"'+newdata[j]+'\" /></div>';
			main_tab += '<div class="col-1 mb-3">';
			main_tab += '<input type="button" name="button'+j+'" id="button'+j+'" value="Delete" class="btn btn-danger" onclick="deleteContactPerson(\''+a+'\','+j+')" /></div>';
			main_tab += '</div>'; 
			
			j++;
		}
	}
	
	document.getElementById(a+"_add_div").innerHTML = main_tab;
	document.getElementById(a+"_num_rows").value = int_num_rows-1;
	
}
// End of Delete Row

function validateForm() {
  var prevent = '';

  let pname = document.forms["prod_form"]["pname"].value;
  if (pname == "") {
	document.getElementById("pname_error").innerHTML = "Product name must be filled";
	document.getElementById("pname").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("pname_error").innerHTML = "";
	document.getElementById("pname").className  = "form-control";
  }
  
  let pricing = document.forms["prod_form"]["pricing"].value;
  if (pricing == "") {
	document.getElementById("price_error").innerHTML = "Pricing must be selected";
	document.getElementById("pricing").className  = "form-select error";
	prevent = 'yes';
  } else {
	document.getElementById("price_error").innerHTML = "";
	document.getElementById("pricing").className  = "form-select";
  }
  
  if(document.getElementById("pid").value == ''){
  let pimg1 = document.forms["prod_form"]["pimg1"].value;
  if (pimg1 == "") {
	document.getElementById("pimg1_error").innerHTML = "Image must be selected";
	document.getElementById("pimg1").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("pimg1_error").innerHTML = "";
	document.getElementById("pimg1").className  = "form-control";
  }
  }

  if(document.getElementById("mat_check").checked == true){
	let ex_mat_rows = document.getElementById("ex_mat_num_rows").value;

	if(ex_mat_rows > 0){
		
		for(i=1; i<=ex_mat_rows; i++){
		let ex_mat_name = document.forms["prod_form"]["ex_mat_name"+i].value;
		if (ex_mat_name == "") {
			document.getElementById("ex_mat_name"+i).className  = "form-control error";
			prevent = 'yes';
		} else {
			document.getElementById("ex_mat_name"+i).className  = "form-control";
		}
	}
	} else {

	let mat_rows = document.getElementById("mat_num_rows").value;

	for(i=1; i<=mat_rows; i++){
		let mat_name = document.forms["prod_form"]["mat_name"+i].value;
		if (mat_name == "") {
			document.getElementById("mat_name"+i).className  = "form-control error";
			prevent = 'yes';
		} else {
			document.getElementById("mat_name"+i).className  = "form-control";
		}
	}
	}
  }
  
  if(document.getElementById("siz_check").checked == true){
	let ex_siz_rows = document.getElementById("ex_siz_num_rows").value;

	if(ex_siz_rows > 0){
		
		for(i=1; i<=ex_siz_rows; i++){
		let ex_siz_name = document.forms["prod_form"]["ex_siz_name"+i].value;
		if (ex_mat_name == "") {
			document.getElementById("ex_siz_name"+i).className  = "form-control error";
			prevent = 'yes';
		} else {
			document.getElementById("ex_siz_name"+i).className  = "form-control";
		}
	}
	} else {

	let siz_rows = document.getElementById("siz_num_rows").value;

	for(i=1; i<=siz_rows; i++){
		let siz_name = document.forms["prod_form"]["siz_name"+i].value;
		if (siz_name == "") {
			document.getElementById("siz_name"+i).className  = "form-control error";
			prevent = 'yes';
		} else {
			document.getElementById("siz_name"+i).className  = "form-control";
		}
	}
	}
  }
  
  if(document.getElementById("fin_check").checked == true){
	let ex_fin_rows = document.getElementById("ex_fin_num_rows").value;

	if(ex_fin_rows > 0){
		
		for(i=1; i<=ex_fin_rows; i++){
		let ex_fin_name = document.forms["prod_form"]["ex_fin_name"+i].value;
		if (ex_fin_name == "") {
			document.getElementById("ex_fin_name"+i).className  = "form-control error";
			prevent = 'yes';
		} else {
			document.getElementById("ex_fin_name"+i).className  = "form-control";
		}
	}
	} else {

	let fin_rows = document.getElementById("fin_num_rows").value;

	for(i=1; i<=fin_rows; i++){
		let fin_name = document.forms["prod_form"]["fin_name"+i].value;
		if (fin_name == "") {
			document.getElementById("fin_name"+i).className  = "form-control error";
			prevent = 'yes';
		} else {
			document.getElementById("fin_name"+i).className  = "form-control";
		}
	}
	}
  }
  
  if(document.getElementById("col_check").checked == true){
	let ex_col_rows = document.getElementById("ex_col_num_rows").value;

	if(ex_col_rows > 0){
		
		for(i=1; i<=ex_col_rows; i++){
		let ex_col_name = document.forms["prod_form"]["ex_col_name"+i].value;
		if (ex_col_name == "") {
			document.getElementById("ex_col_name"+i).className  = "form-control error";
			prevent = 'yes';
		} else {
			document.getElementById("ex_col_name"+i).className  = "form-control";
		}
	}
	} else {

	let col_rows = document.getElementById("col_num_rows").value;

	for(i=1; i<=col_rows; i++){
		let col_name = document.forms["prod_form"]["col_name"+i].value;
		if (col_name == "") {
			document.getElementById("col_name"+i).className  = "form-control error";
			prevent = 'yes';
		} else {
			document.getElementById("col_name"+i).className  = "form-control";
		}
	}
	}
  }
  
  if(document.getElementById("spo_check").checked == true){
	let ex_spo_rows = document.getElementById("ex_spo_num_rows").value;

	if(ex_spo_rows > 0){
		
		for(i=1; i<=ex_spo_rows; i++){
		let ex_spo_name = document.forms["prod_form"]["ex_spo_name"+i].value;
		if (ex_spo_name == "") {
			document.getElementById("ex_spo_name"+i).className  = "form-control error";
			prevent = 'yes';
		} else {
			document.getElementById("ex_spo_name"+i).className  = "form-control";
		}
	}
	} else {

	let spo_rows = document.getElementById("spo_num_rows").value;

	for(i=1; i<=spo_rows; i++){
		let spo_name = document.forms["prod_form"]["spo_name"+i].value;
		if (spo_name == "") {
			document.getElementById("spo_name"+i).className  = "form-control error";
			prevent = 'yes';
		} else {
			document.getElementById("spo_name"+i).className  = "form-control";
		}
	}
	}
  }
  
  if(document.getElementById("spt_check").checked == true){
	let ex_spt_rows = document.getElementById("ex_spt_num_rows").value;

	if(ex_spt_rows > 0){
		
		for(i=1; i<=ex_spt_rows; i++){
		let ex_spt_name = document.forms["prod_form"]["ex_spt_name"+i].value;
		if (ex_spt_name == "") {
			document.getElementById("ex_spt_name"+i).className  = "form-control error";
			prevent = 'yes';
		} else {
			document.getElementById("ex_spt_name"+i).className  = "form-control";
		}
	}
	} else {

	let spt_rows = document.getElementById("spt_num_rows").value;

	for(i=1; i<=spt_rows; i++){
		let spt_name = document.forms["prod_form"]["spt_name"+i].value;
		if (spt_name == "") {
			document.getElementById("spt_name"+i).className  = "form-control error";
			prevent = 'yes';
		} else {
			document.getElementById("spt_name"+i).className  = "form-control";
		}
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