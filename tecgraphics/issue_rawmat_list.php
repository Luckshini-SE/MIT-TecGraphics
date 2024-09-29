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
					<h1 class="h3 mb-3 col-10">Issue Raw Material List</h1>
					<div class="col-2" align="right"><a href="issue_rawmat.php"><button class="btn btn-success">Add</button></a></div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">
									<table id="datatables-reponsive" class="table table-striped" style="width:100%">
										<thead>
										  <tr>
											<th>No.</th>
											<th>Date</th>
											<th>Job No.</th>
											<th>Details</th>
											<th>Issued To</th>
										  </tr>
										</thead>
										<tbody>
										  <?php
										  $select_in = mysqli_query($con, "SELECT * FROM issue_summary");
										  while($result_in= mysqli_fetch_array($select_in)){

											$details = '';
											$select_det = mysqli_query($con, "SELECT item_id, qty FROM issue_details WHERE issue_no = '{$result_in['issue_no']}'");
											while($result_det = mysqli_fetch_array($select_det)){
												$select_item = mysqli_query($con, "SELECT name FROM rawmaterial WHERE id = '{$result_det['item_id']}'");
												$result_item = mysqli_fetch_array($select_item);

												$details .= '<div style="display:flex"><div style="width:70%">'.$result_item['name'].'</div><div style="width:30%">'.$result_det['qty'].'</div></div>';
											}

										  ?>
										  <tr>
											<td><?php echo $result_in['issue_no']; ?></td>
											<td><?php echo $result_in['issue_date']; ?></td>
											<td><?php echo $result_in['jobno']; ?></td>
											<td><?php echo $details; ?></td>
											<td><?php echo $result_in['issued_to']; ?></td>
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