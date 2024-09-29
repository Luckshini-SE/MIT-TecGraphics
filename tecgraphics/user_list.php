<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('header.php'); ?>
	<?php include('db_connection.php'); ?>
</head>

<body>
	<div class="wrapper">

	<?php include('sidebar.php'); ?>

		<div class="main">
			
		<?php include('topbar.php'); ?>

			<main class="content">
				<div class="container-fluid p-0">

					<div class="row">
					<h1 class="h3 mb-3 col-10">User List</h1>
					<div class="col-2" align="right"><a href="user_register.php"><button class="btn btn-success">Add</button></a></div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">
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
									<table id="datatables-reponsive" class="table table-striped" style="width:100%">
										<thead>
										  <tr>
											<th>Name</th>
											<th>Contact</th>
											<th>Email</th>
											<th>User Type</th>
											<th>Status</th>
											<th>Update</th>
										  </tr>
										</thead>
										<tbody>
										  <?php
										  $select_user = mysqli_query($con, "SELECT * FROM users");
										  while($result_user = mysqli_fetch_array($select_user)){

											$select_title = mysqli_query($con, "SELECT title FROM title WHERE id = '{$result_user['title']}'");
											$result_title = mysqli_fetch_array($select_title);

											$select_ut = mysqli_query($con, "SELECT name FROM user_type WHERE id = '{$result_user['user_type']}'");
											$result_ut = mysqli_fetch_array($select_ut);

										  ?>
										  <tr>
											<td><?php echo $result_title['title'].'. '.$result_user['first_name'].' '.$result_user['last_name']; ?></td>
											<td><?php echo $result_user['contact']; ?></td>
											<td><?php echo $result_user['username']; ?></td>
											<td><?php echo $result_ut['name']; ?></td>
											<td><?php if($result_user['active'] == 'yes'){ ?><span class="badge bg-success rounded-pill">Active</span><?php } else { ?><span class="badge bg-danger rounded-pill">Inactive</span><?php }  ?></td>
											<td align="center"><a href="user_register.php?id=<?php echo $result_user['id']; ?>"><button class="btn btn-sm btn-warning"><i data-feather="edit"></i></button></a></td>
										  </tr>
										  <?php } ?>
										</tbody>
									</table>
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
	<script src="js/datatables.js"></script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Datatables Responsive
			$("#datatables-reponsive").DataTable({
				responsive: true
			});
		});
	</script>
	
</body>

</html>