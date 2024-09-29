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
	$uid = $_GET['id'];

	$select_usrt = mysqli_query($con, "SELECT name FROM user_type WHERE id = '$uid'");
	$result_usrt = mysqli_fetch_array($select_usrt);
		$name = $result_usrt['name'];
} else {
	$uid = $name = '';
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
					<h1 class="h3 mb-3 col-10">User Type</h1>
					<div class="col-2" align="right"><a href="usertype_list.php"><button class="btn btn-warning">View List</button></a></div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">

									<form method="post" name="usertype_form" action="usertype_register_submit.php" onsubmit="return validateForm()" >
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
											<div class="col-4  mb-3">
												<label class="form-label">User Type <span style="color:red">*</span></label>
												<input type="text" class="form-control" name="utype" id="utype" placeholder="User Type" value="<?php echo $name; ?>" >
												<input type="hidden" name="utid" id="utid" value="<?php echo $uid; ?>" >
												<span class="error_msg" id="utype_error" ></span>
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

function validateForm() {
  var prevent = '';

  let utype = document.forms["usertype_form"]["utype"].value;
  if (utype == "") {
	document.getElementById("utype_error").innerHTML = "User type must be filled";
	document.getElementById("utype").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("utype_error").innerHTML = "";
	document.getElementById("utype").className  = "form-control";
  }
  
  if(prevent == 'yes'){
	  return false;
  }
}

	</script>

</body>

</html>