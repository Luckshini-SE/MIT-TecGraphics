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
					<h1 class="h3 mb-3 col-10">Machine List</h1>
					<div class="col-2" align="right"><a href="machine_register.php"><button class="btn btn-success">Add</button></a></div>
					</div>

					<div class="row">
						<div class="col-8 offset-2">
							<div class="card">
								<div class="card-body">
									<table id="datatables-reponsive" class="table table-striped" style="width:100%">
										<thead>
										  <tr>
											<th>#</th>
											<th>Name</th>
											<th>&nbsp;</th>
										  </tr>
										</thead>
										<tbody>
										  <?php
										  $i = 1;
										  $select_mach = mysqli_query($con, "SELECT * FROM machine");
										  while($result_mach = mysqli_fetch_array($select_mach)){

										  ?>
										  <tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $result_mach['name']; ?></td>
											<td align="center"><a href="machine_register.php?id=<?php echo $result_mach['id']; ?>" ><button type="button" class="btn btn-sm btn-warning" ><i data-feather="edit"></i></button></a></td>
										 </tr>
										  <?php $i++; } ?>
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