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
					<h1 class="h3 mb-3 col-10">Pending Requests for Quotation</h1>
					<div class="col-2" align="right"><a href="quotation_list.php"><button class="btn btn-warning">View List</button></a></div>
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
											<th>Request No.</th>
											<th>Customer</th>
											<th>Product</th>
											<th>Artwork</th>
											<th>Req. on</th>
											<th>&nbsp;</th>
										  </tr>
										</thead>
										<tbody>
										  <?php
										  $select_req = mysqli_query($con, "SELECT * FROM quotation_requests WHERE status = 'open'");
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

											$products = '';
											$artworkt  = 1;
											$select_req2 = mysqli_query($con, "SELECT * FROM requests WHERE req_id = '{$result_req['id']}'");
										    while($result_req2 = mysqli_fetch_array($select_req2)){

												$select_prod = mysqli_query($con, "SELECT name FROM products WHERE id = '{$result_req2['prod_id']}'");
												$result_prod = mysqli_fetch_array($select_prod);
													$products .= $result_prod['name'].', ';

												if($result_req2['artwork'] == 'need'){
													$artworkt += 1;
												}
											}
											$products = substr($products, 0, -2);

											if($artworkt > 1){
												$artwork = 'Needed';
											} else {
												$artwork = 'Not Needed';
											}
										  ?>
										  <tr>
											<td><?php echo $result_req['req_no']; ?></td>
											<td><?php echo $cusname; ?></td>
											<td><?php echo $products; ?></td>
											<td><?php echo $artwork; ?></td>
											<td><?php echo substr($result_req['r_datetime'], 0, 10); ?></td>
											<td><a href="create_quotation.php?req=<?php echo $result_req['id']; ?>"><button type="button" class="btn btn-sm btn-primary" >Quotation</button></a></td>
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