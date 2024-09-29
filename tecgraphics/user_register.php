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
if(isset($_GET['id'])){		//check whether id is passed
	$uid = $_GET['id'];

	$select_user = mysqli_query($con, "SELECT `title`, `first_name`, `last_name`, `contact`, `designation`, `user_type`, `username`, `profile_pic`, `active` FROM users WHERE id = '$uid'");
	$result_user = mysqli_fetch_array($select_user);
		$title = $result_user['title'];
		$first_name = $result_user['first_name'];
		$last_name = $result_user['last_name'];
		$contact = $result_user['contact'];
		$designation = $result_user['designation'];
		$user_type = $result_user['user_type'];
		$email = $result_user['username'];
		$profile = $result_user['profile_pic'];
		$uactive = $result_user['active'];
} else {
	$uid = $title = $first_name = $last_name = $contact = $designation = $user_type = $email = $profile = $uactive = '';
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
					<h1 class="h3 mb-3 col-10">Create User</h1>
					<div class="col-2" align="right"><a href="user_list.php"><button class="btn btn-warning">View List</button></a></div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">

									<form method="post" name="user_form" action="user_register_submit.php" enctype="multipart/form-data" onsubmit="return validateForm()" >
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
											<div class="col-3  mb-3">
												<label class="form-label">Title <span style="color:red">*</span></label>
												<select class="form-select" name="utitle" id="utitle" >
													<option value="">-Please Select-</option>
													<?php
													$select_title  = mysqli_query($con, "SELECT id, title FROM title");
													while($result_title = mysqli_fetch_array($select_title)){
													?>
													<option value="<?php echo $result_title['id']; ?>" <?php if($result_title['id'] == $title){ echo 'selected'; } ?> ><?php echo $result_title['title']; ?></option>
													<?php } ?>
												</select>
												<span class="error_msg" id="utitle_error" ></span>
											</div>
											<div class="col-4  mb-3">
												<label class="form-label">First Name <span style="color:red">*</span></label>
												<input type="text" class="form-control" name="fname" id="fname" placeholder="First Name" value="<?php echo $first_name; ?>" >
												<input type="hidden" name="uid" id="uid" value="<?php echo $uid; ?>" >
												<span class="error_msg" id="fname_error" ></span>
											</div>
											<div class="col-5  mb-3">
												<label class="form-label">Last Name <span style="color:red">*</span></label>
												<input type="text" class="form-control" name="lname" id="lname" placeholder="Last Name" value="<?php echo $last_name; ?>" >
												<span class="error_msg" id="lname_error" ></span>
											</div>
										</div>

										<div class="row form-group mb-3">
											<div class="col-4 mb-3">
												<label class="form-label">Mobile No. <span style="color:red">*</span></label>
												<input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile No." value="<?php echo $contact; ?>" >
												<span class="error_msg" id="mobile_error" ></span>
											</div>
											<div class="col-4 mb-3">
												<label class="form-label">Designation</label>
												<input type="text" class="form-control" name="designation" id="designation" placeholder="Designation" value="<?php echo $designation; ?>" >
											</div>
											<div class="col-4  mb-3">
												<label class="form-label">User Type <span style="color:red">*</span></label>
												<select class="form-select" name="utype" id="utype" >
													<option value="">-Please Select-</option>
													<?php
													$select_utype  = mysqli_query($con, "SELECT id, name FROM user_type");
													while($result_utype = mysqli_fetch_array($select_utype)){
													?>
													<option value="<?php echo $result_utype['id']; ?>" <?php if($result_utype['id'] == $user_type){ echo 'selected'; } ?> ><?php echo $result_utype['name']; ?></option>
													<?php } ?>
												</select>
												<span class="error_msg" id="utype_error" ></span>
											</div>
										</div>

										<div class="row form-group mb-3">
											<div class="col-4  mb-3">
												<label class="form-label">Email <span style="color:red">*</span></label>
												<input type="text" class="form-control" name="uname" id="uname" placeholder="Username" value="<?php echo $email; ?>" >
												<span class="error_msg" id="uname_error" ></span>
											</div>
											<div class="col-4 mb-3">
											<?php if($uid == ''){ ?>
												<label class="form-label">Password <span style="color:red">*</span></label>
												<input type="password" class="form-control" name="password" id="password" placeholder="Password" >
												<span class="error_msg" id="pass_error" ></span>
											<?php } else {  ?>
												<label class="form-label col-12">Status <span style="color:red">*</span></label>
												<input type="radio" name="ustatus" value="yes" <?php if($uactive == 'yes'){ echo 'checked'; } ?> >&nbsp;Active&nbsp;&nbsp;
												<input type="radio" name="ustatus" value="no" <?php if($uactive != 'yes'){ echo 'checked'; } ?> >&nbsp;Deactive
											<?php } ?>
											</div>
											<div class="col-4 mb-3">
												<label class="form-label">Profile Picture</label>
												<input type="file" class="form-control" name="profile" id="profile" >
											</div>
										</div>

										<?php if($uid != '' && $profile != ''){ ?>
										<div class="row form-group mb-3">
											<div class="col-8 mb-3" pull-right>&nbsp;</div>
											<div class="col-4 mb-3">
												<img src="img/avatars/<?php echo $profile; ?>" width="75px;" />
											</div>
										</div>
										<?php } ?>

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
function validateForm() {
  var prevent = '';

  let title = document.forms["user_form"]["utitle"].value;
  if (title == "") {
	document.getElementById("utitle_error").innerHTML = "Title must be selected";
	document.getElementById("utitle").className  = "form-select error";
	prevent = 'yes';
  } else {
	document.getElementById("utitle_error").innerHTML = "";
	document.getElementById("utitle").className  = "form-select";
  }

  let fname = document.forms["user_form"]["fname"].value;
  if (fname == "") {
	document.getElementById("fname_error").innerHTML = "First name must be filled";
	document.getElementById("fname").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("fname_error").innerHTML = "";
	document.getElementById("fname").className  = "form-control";
  }
  
  let lname = document.forms["user_form"]["lname"].value;
  if (lname == "") {
	document.getElementById("lname_error").innerHTML = "Last name must be filled";
	document.getElementById("lname").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("lname_error").innerHTML = "";
	document.getElementById("lname").className  = "form-control";
  }
  
  let mobile = document.forms["user_form"]["mobile"].value;
  var regPhone=/^\d{10}$/;
  if (mobile == "") {
	document.getElementById("mobile_error").innerHTML = "Mobile must be filled";
	document.getElementById("mobile").className  = "form-control error";
	prevent = 'yes';
  } else if (!regPhone.test(mobile)) {
    document.getElementById("mobile_error").innerHTML = "Mobile must have 10 digits";
	document.getElementById("mobile").className  = "form-control error";
	prevent = 'yes';
  }else {
	document.getElementById("mobile_error").innerHTML = "";
	document.getElementById("mobile").className  = "form-control";
  }
  
  let utype = document.forms["user_form"]["utype"].value;
  if (utype == "") {
	document.getElementById("utype_error").innerHTML = "User type must be selected";
	document.getElementById("utype").className  = "form-select error";
	prevent = 'yes';
  } else {
	document.getElementById("utype_error").innerHTML = "";
	document.getElementById("utype").className  = "form-select";
  }
  
  let uname = document.forms["user_form"]["uname"].value;
  var regEmail=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/g;
  if (uname == "") {
	document.getElementById("uname_error").innerHTML = "Email must be filled";
	document.getElementById("uname").className  = "form-control error";
	prevent = 'yes';
  } else if (!regEmail.test(uname)) {
    document.getElementById("uname_error").innerHTML = "Invalid email format";
	document.getElementById("uname").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("uname_error").innerHTML = "";
	document.getElementById("uname").className  = "form-control";
  }
  
  <?php if($uid == ''){ ?>
  let password = document.forms["user_form"]["password"].value;
  if (password == "") {
	document.getElementById("pass_error").innerHTML = "Password must be filled";
	document.getElementById("password").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("pass_error").innerHTML = "";
	document.getElementById("password").className  = "form-control";
  }
  <?php } ?>

  if(prevent == 'yes'){
	  return false;
  }
}
	</script>

</body>

</html>