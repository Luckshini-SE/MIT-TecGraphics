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
					<h1 class="h3 mb-3 col-10">Pending GRN</h1>
					<!--<div class="col-2" align="right"><a href="goods_received.php"><button class="btn btn-success">Add</button></a></div>-->
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
											<th>No.</th>
											<th>Date</th>
											<th>Supplier</th>
											<th>Amount (Rs.)</th>
											<th>&nbsp;</th>
										  </tr>
										</thead>
										<tbody>
										  <?php
										  $select_grn = mysqli_query($con, "SELECT * FROM grn_summary WHERE approval = 'pending'");
										  while($result_grn= mysqli_fetch_array($select_grn)){

											$select_supp = mysqli_query($con, "SELECT sname FROM supplier WHERE id = '{$result_grn['supplier']}'");
											$result_supp = mysqli_fetch_array($select_supp);

										  ?>
										  <tr>
											<td><?php echo $result_grn['grn_no']; ?></td>
											<td><?php echo $result_grn['grn_date']; ?></td>
											<td><?php echo $result_supp['sname']; ?></td>
											<td align="right"><?php echo number_format($result_grn['total'], 2, '.', ','); ?></td>
											<td align="center"><a href="approve_goods_received.php?qid=<?php echo $result_grn['id']; ?>" ><button type="button" class="btn btn-success" title="Approve" ><i data-feather="check"></i></button></a></td>
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