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
					<h1 class="h3 mb-3 col-10">Customer List</h1>
					<div class="col-2" align="right"><a href="customer_register.php"><button class="btn btn-success">Add</button></a></div>
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
											<th>Address</th>
											<th>Mode</th>
											<th>Reg. Date</th>
											<th>Update</th>
										  </tr>
										</thead>
										<tbody>
										  <?php
										  $select_cus = mysqli_query($con, "SELECT * FROM customer");
										  while($result_cus = mysqli_fetch_array($select_cus)){

										  if($result_cus['title'] != '6'){
											$select_title = mysqli_query($con, "SELECT title FROM title WHERE id = '{$result_cus['title']}'");
											$result_title = mysqli_fetch_array($select_title);
												$title = $result_title['title'].'. ';
										  } else {
											  $title = '';
										  }

										  if($result_cus['reg_mode'] == 'online'){
											$mode = 'Web';
											$contact = $result_cus['email'];
										  } else {
											$mode = 'Walk-in';
											if($result_cus['ctype'] == 'i'){
												$contact = $result_cus['mobile'];
											} else {
												$contact = $result_cus['phone'];
											}
										  }

										  ?>
										  <tr>
											<td><?php echo $title.$result_cus['name'].' '.$result_cus['last_name']; ?></td>
											<td><?php echo $contact; ?></td>
											<td><?php echo $result_cus['address1'].' '.$result_cus['address2'].' '.$result_cus['address3']; ?></td>
											<td><?php echo $mode; ?></td>
											<td><?php echo substr($result_cus['reg_date'],0,10); ?></td>
											<td align="center"><?php if($result_cus['reg_mode'] != 'online'){ ?><a href="customer_update.php?cid=<?php echo $result_cus['id']; ?>"><button class="btn btn-sm btn-warning"><i data-feather="edit"></i></button></a><?php } ?></td>
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