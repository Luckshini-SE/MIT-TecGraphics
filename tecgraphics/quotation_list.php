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
					<h1 class="h3 mb-3 col-10">Quotation List</h1>
					<div class="col-2" align="right"><a href="pending_requests.php"><button class="btn btn-success">Add</button></a></div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">
									<table id="datatables-reponsive" class="table table-striped" style="width:100%">
										<thead>
										  <tr>
											<th>Quotation No.</th>
											<th>Date</th>
											<th>Customer</th>
											<th>Amount (Rs.)</th>
											<th>Approval</th>
											<th>&nbsp;</th>
										  </tr>
										</thead>
										<tbody>
										  <?php
										  $select_req = mysqli_query($con, "SELECT * FROM quotation");
										  while($result_req = mysqli_fetch_array($select_req)){

										  $select_cust = mysqli_query($con, "SELECT title, name, last_name FROM customer WHERE id = '{$result_req['cus_id']}'");
										  $result_cust = mysqli_fetch_array($select_cust);
											if($result_cust['title']!='6'){
												$select_title = mysqli_query($con, "SELECT title FROM title WHERE id = '{$result_cust['title']}'");
												$result_title = mysqli_fetch_array($select_title);
												$cusname = $result_title['title'].'. '.$result_cust['name'].' '.$result_cust['last_name'];
											} else {
												$cusname = $result_cust['name'].' '.$result_cust['last_name'];
											}

										  if($result_req['approval'] == 'yes'){
											  $approval = 'Yes';
										  } else {
											  $approval = 'Pending';
										  }

										  ?>
										  <tr>
											<td><?php echo $result_req['q_no']; ?></td>
											<td><?php echo $result_req['q_date']; ?></td>
											<td><?php echo $cusname; ?></td>
											<td align="right"><?php echo number_format($result_req['total'],2); ?></td>
											<td><?php echo $approval; ?></td>
											<td align="center"><?php if($result_req['approval'] == 'yes'){ ?><a href="print_quotation.php?qid=<?php echo $result_req['id']; ?>" target="_blank"><button type="button" class="btn btn-sm btn-primary" ><i data-feather="printer"></i></button></a><?php } ?></td>
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