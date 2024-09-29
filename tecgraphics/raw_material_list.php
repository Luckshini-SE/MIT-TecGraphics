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
					<h1 class="h3 mb-3 col-10">Raw Material List</h1>
					<div class="col-2" align="right"><a href="raw_material_register.php"><button class="btn btn-success">Add</button></a></div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">
									<table id="datatables-reponsive" class="table table-striped" style="width:100%">
										<thead>
										  <tr>
											<th>Code</th>
											<th>Name</th>
											<th>UoM</th>
											<th>Category</th>
											<th>Reorder Level</th>
											<th>&nbsp;</th>
										  </tr>
										</thead>
										<tbody>
										  <?php
										  $select_rmat = mysqli_query($con, "SELECT * FROM rawmaterial");
										  while($result_rmat = mysqli_fetch_array($select_rmat)){

										  $select_uom = mysqli_query($con, "SELECT name FROM unit_of_measure WHERE id = '{$result_rmat['uom']}'");
										  $result_uom = mysqli_fetch_array($select_uom);
										  
										  $select_cat = mysqli_query($con, "SELECT name FROM rawmaterial_category WHERE id = '{$result_rmat['category']}'");
										  $result_cat = mysqli_fetch_array($select_cat);

										  ?>
										  <tr>
											<td><?php echo $result_rmat['code']; ?></td>
											<td><?php echo $result_rmat['name']; ?></td>
											<td><?php echo $result_uom['name']; ?></td>
											<td><?php echo $result_cat['name']; ?></td>
											<td><?php echo $result_rmat['ro_level']; ?></td>
										 	<td align="center"><a href="raw_material_register.php?id=<?php echo $result_rmat['id']; ?>" ><button type="button" class="btn btn-sm btn-warning" ><i data-feather="edit"></i></button></a></td>
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