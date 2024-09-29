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
					<h1 class="h3 mb-3 col-10">Pending Quotation for Approval</h1>
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
											<th>Quotation No.</th>
											<th>Date</th>
											<th>Customer</th>
											<th>Amount (Rs.)</th>
											<th>Sales Executive</th>
											<th>&nbsp;</th>
										  </tr>
										</thead>
										<tbody>
										  <?php
										  $select_req = mysqli_query($con, "SELECT * FROM quotation WHERE approval = 'no' ORDER BY q_no DESC");
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

										  $select_se = mysqli_query($con, "SELECT first_name, last_name FROM users WHERE id = '{$result_req['sales_ex']}'");		
										  $result_se = mysqli_fetch_array($select_se);

										  ?>
										  <tr>
											<td><?php echo $result_req['q_no']; ?></td>
											<td><?php echo $result_req['q_date']; ?></td>
											<td><?php echo $cusname; ?></td>
											<td align="right"><?php echo number_format($result_req['total'],2); ?></td>
											<td><?php echo $result_se['first_name'].' '.$result_se['last_name']; ?></td>
											<td align="center"><a href="approve_quotation.php?qid=<?php echo $result_req['id']; ?>" ><button type="button" class="btn btn-success" title="Approve" ><i data-feather="check"></i></button></a></td>
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
				responsive: true,
				aaSorting: false
			});
		});
	</script>
	
</body>

</html>