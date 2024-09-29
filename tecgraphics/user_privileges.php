<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('header.php'); ?>
	<?php include('db_connection.php'); ?>
	<?php
	//Set time zone
	$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
	$cur_date = $createToday->format('Y-m-d');
	?>
	
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
					<h1 class="h3 mb-3 col-10">Manage Privileges</h1>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">

									<form method="post" name="privileges" action="user_privileges_submit.php" >
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
												<label class="form-label">User Type</label>
												<select class="form-select" name="usertype" id="usertype" >
													<option value="">-Please Select-</option>
													<?php
													$select_ut = mysqli_query($con, "SELECT id, name FROM user_type");
													while($result_ut = mysqli_fetch_array($select_ut)){
													?>
													<option value="<?php echo $result_ut['id']; ?>"><?php echo $result_ut['name']; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-8 mb-3">
												<label class="form-label col-12">&nbsp;</label>
												<input type="button" class="btn btn-warning" name="search" id="search" value="Search" onclick="get_details()" >
											</div>
										</div>

										<div id="loader_div" style="padding-left:20px; font-weight:bold"></div>
										<div id="detail_div"></div>
										
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
	<script type="text/javascript" src="assets/js/jquery.min.js"></script>
	
	<script>
		
		function get_details(){
			
			var usertype = $("#usertype").val();

			if(usertype != ''){

				$("#detail_div").empty();
				$("#loader_div").empty();		// Waiting Div
				$("#loader_div").append('<img src="img/icons/spinner.gif" alt="Loading..." title="Loading"/>  Please wait while processing !!');
		
			$.post("get_user_privileges.php", {
				usertype:usertype
			},
			
			function(data,status) {
				$("#loader_div").empty();
				$("#detail_div").empty();			
				$("#detail_div").append(data);
			});
			} else {
				$("#detail_div").html("<span style='color:red'>Please select user type</span>");
			}
		
		}
	</script>

</body>

</html>