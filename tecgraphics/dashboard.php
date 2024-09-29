<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('header.php'); ?>
</head>

	<?php include('db_connection.php');

	//Set time zone
	$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
	$cur_date = $createToday->format('Y-m-d');
	$cur_mont = $createToday->format('Y-m');
	$cur_year = $createToday->format('Y');
	$cur_mon1 = $createToday->format('m');

	// date of Monday
	$monday = strtotime('last Monday');
	// check if we need to go back in time one more week
	$monday = date('W', $monday)==date('W') ? $monday-7*86400 : $monday;
	$monday = date("Y-m-d", $monday);

	// date of Sunday
	$sunday = strtotime('last Sunday');
	// check if we need to go back in time one more week
	$sunday = date('W', $sunday)==date('W') ? $sunday-7*86400 : $sunday;
	$sunday = date("Y-m-d", $sunday);

	// date of current week Monday
	$this_monday = date('Y-m-d', strtotime($sunday .' +1 day'));
	
	//Data for monthly sale
	$mon_chart_name = '[';
	$mon_chart_amt = '[';
	
	for($m=1; $m<=12; $m++){
		$chart_month = str_pad($m, 2, '0', STR_PAD_LEFT);
		$chart_year = $cur_year.'-'.$chart_month;
		
		$select_msale = mysqli_query($con, "SELECT SUM(total) FROM invoice WHERE cancel = 'no' AND invoice_date LIKE '$chart_year%'");
		$result_msale = mysqli_fetch_array($select_msale);
			$dateObj   = DateTime::createFromFormat('!m', $m);
			$monthName = $dateObj->format('M');
			$mon_chart_name .= '"'.$monthName.'", ';
			$mon_chart_amt .= $result_msale[0].', ';
	}
	$mon_chart_name = substr($mon_chart_name,0,-2);
	$mon_chart_name .= ']';

	$mon_chart_amt = substr($mon_chart_amt,0,-2);
	$mon_chart_amt .= ']';

	//Data for item wise sale

	if(isset($_POST['chart_bar_month'])){
		$chart_bar_month = $cur_year.'-'.$_POST['chart_bar_month'];
		$month_only1 = $_POST['chart_bar_month'];
	} else {
		$chart_bar_month = $cur_mont;
		$month_only1 = $cur_mon1;
	}
	
	$bar_chart_name = '[';
	$bar_chart_amt = '[';
	$select_sp = mysqli_query($con, "SELECT id, name FROM products");
	while($result_sp = mysqli_fetch_array($select_sp)){
		$bar_chart_name .= '"'.implode(" ",array_slice(explode(' ', $result_sp['name']), 0, -1)).'", ';

		$select_sale = mysqli_query($con, "SELECT SUM(i.total) FROM invoice i, invoice_details d WHERE i.id = d.invoice_id AND d.prod_id = '{$result_sp['id']}' AND i.invoice_date LIKE '$chart_bar_month%' AND i.cancel = 'no'");
		$result_sale = mysqli_fetch_array($select_sale);
			$bar_chart_amt .= $result_sale[0].', ';
	}
	$bar_chart_name = substr($bar_chart_name,0,-2);
	$bar_chart_name .= ']';

	$bar_chart_amt = substr($bar_chart_amt,0,-2);
	$bar_chart_amt .= ']';

	//Data for sales person wise sale

	if(isset($_POST['chart_pie_month'])){
		$chart_pie_month = $cur_year.'-'.$_POST['chart_pie_month'];
		$month_only2 = $_POST['chart_pie_month'];
	} else {
		$chart_pie_month = $cur_mont;
		$month_only2 = $cur_mon1;
	}
	
	$chart_name = '[';
	$chart_amt = '[';
	$select_sp = mysqli_query($con, "SELECT id, first_name FROM users WHERE user_type = '6'");
	while($result_sp = mysqli_fetch_array($select_sp)){
		$chart_name .= '"'.$result_sp['first_name'].'", ';

		$select_psale = mysqli_query($con, "SELECT SUM(i.total) FROM invoice i, jobcard j, quotation q WHERE i.jobcard_id = j.id AND j.quotation_id = q.id AND q.sales_ex = '{$result_sp['id']}' AND i.invoice_date LIKE '$chart_pie_month%' AND i.cancel = 'no'");
		$result_psale = mysqli_fetch_array($select_psale);
			$chart_amt .= $result_psale[0].', ';
	}
	$chart_name = substr($chart_name,0,-2);
	$chart_name .= ']';

	$chart_amt = substr($chart_amt,0,-2);
	$chart_amt .= ']';

	?>

<body>
	<div class="wrapper">
		
	<?php include('sidebar.php'); ?>

		<div class="main">
			
		<?php include('topbar.php'); ?>

			<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3">Dashboard</h1>

					<?php
					if($_SESSION["logUserType"] == 1 || $_SESSION["logUserType"] == 5){		// for admin & manager - start
					?>

					<div class="row">
						<div class="col-xl-6 col-xxl-5 d-flex">
							<div class="w-100">
								<div class="row">
									<div class="col-sm-6">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Sales-Today</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="truck"></i>
														</div>
													</div>
												</div>
												<?php
												//Sale of today
												$select_csale = mysqli_query($con, "SELECT SUM(total) FROM invoice WHERE cancel = 'no' AND invoice_date LIKE '$cur_date'");
												$result_csale = mysqli_fetch_array($select_csale);
												
												//Sale of last week
												$select_wsale = mysqli_query($con, "SELECT SUM(total) FROM invoice WHERE cancel = 'no' AND invoice_date BETWEEN '$monday' AND '$sunday'");
												$result_wsale = mysqli_fetch_array($select_wsale);
												
												//Sale of this week upto today
												$select_twsale = mysqli_query($con, "SELECT SUM(total) FROM invoice WHERE cancel = 'no' AND invoice_date BETWEEN '$this_monday' AND '$cur_date'");
												$result_twsale = mysqli_fetch_array($select_twsale);

												if($result_wsale[0] != 0){
													$sale_per = ($result_twsale[0]-$result_wsale[0])*100/$result_wsale[0];
													$sale_per = number_format($sale_per,2,'.','');
												} else {
													$sale_per = 0;
												}

												if($sale_per > 0){
													$scolor = 'success';
												} else {
													$scolor = 'danger';
												}
												?>
												<h1 class="mt-2 mb-2">Rs.<?php echo number_format($result_csale[0],2,'.',','); ?></h1>
												<div class="mb-0">
													<span class="text-<?php echo $scolor; ?>"> <i class="mdi mdi-arrow-bottom-right"></i><?php echo $sale_per; ?>% </span>
													<span class="text-muted">Since last week</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Collection-Today</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="dollar-sign"></i>
														</div>
													</div>
												</div>
												<?php
												//collection of today
												$select_coll1 = mysqli_query($con, "SELECT SUM(amount) FROM advance_payment WHERE rec_date LIKE '$cur_date'");
												$result_coll1 = mysqli_fetch_array($select_coll1);

												$select_coll2 = mysqli_query($con, "SELECT SUM(amount) FROM receipt WHERE rec_date LIKE '$cur_date'");
												$result_coll2 = mysqli_fetch_array($select_coll2);
												
												//collection of last week
												$select_wcoll1 = mysqli_query($con, "SELECT SUM(amount) FROM advance_payment WHERE rec_date BETWEEN '$monday' AND '$sunday'");
												$result_wcoll1 = mysqli_fetch_array($select_wcoll1);

												$select_wcoll2 = mysqli_query($con, "SELECT SUM(amount) FROM receipt WHERE rec_date BETWEEN '$monday' AND '$sunday'");
												$result_wcoll2 = mysqli_fetch_array($select_wcoll2);

												$lastweek = number_format($result_wcoll1[0]+$result_wcoll2[0],2,'.','');

												//collection of this week upto today
												$select_twcoll1 = mysqli_query($con, "SELECT SUM(amount) FROM advance_payment WHERE rec_date BETWEEN '$this_monday' AND '$cur_date'");
												$result_twcoll1 = mysqli_fetch_array($select_twcoll1);

												$select_twcoll2 = mysqli_query($con, "SELECT SUM(amount) FROM receipt WHERE rec_date BETWEEN '$this_monday' AND '$cur_date'");
												$result_twcoll2 = mysqli_fetch_array($select_twcoll2);

												$thisweek = number_format($result_twcoll1[0]+$result_twcoll2[0],2,'.','');
												
												if($lastweek!=0){
													$coll_per = ($thisweek-$lastweek)*100/$lastweek;
													$coll_per = number_format($coll_per,2,'.','');
												} else {
													$coll_per = 0;
												}

												if($coll_per > 0){
													$ccolor = 'success';
												} else {
													$ccolor = 'danger';
												}
												?>
												<h1 class="mt-2 mb-2">Rs.<?php echo number_format($result_coll1[0]+$result_coll2[0],2,'.',','); ?></h1>
												<div class="mb-0">
													<span class="text-<?php echo $ccolor; ?>"> <i class="mdi mdi-arrow-bottom-right"></i> <?php echo $coll_per; ?>% </span>
													<span class="text-muted">Since last week</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Pending Approvals</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="check"></i>
														</div>
													</div>
												</div>
												<?php
												$select_quot = mysqli_query($con, "SELECT COUNT(id) FROM quotation WHERE approval = 'no'");
												$result_quot = mysqli_fetch_array($select_quot);
												
												if($result_quot[0] == ''){
													$penquot = 0;
												} else {
													$penquot = $result_quot[0];
												}

												$select_po = mysqli_query($con, "SELECT COUNT(id) FROM purchase_order_summary WHERE approval = 'pending'");
												$result_po = mysqli_fetch_array($select_po);
												
												if($result_po[0] == ''){
													$penpo = 0;
												} else {
													$penpo = $result_po[0];
												}

												$select_grn = mysqli_query($con, "SELECT COUNT(id) FROM grn_summary WHERE approval = 'pending'");
												$result_grn = mysqli_fetch_array($select_grn);
												
												if($result_grn[0] == ''){
													$pengrn = 0;
												} else {
													$pengrn = $result_grn[0];
												}

												?>
												<div class="row">
													<span class="col-4 text-muted"><a href="pending_approve_quotations.php"><h1 class="mt-2 mb-2"><?php echo $penquot; ?></h1></a></span>
													<span class="col-4 text-muted"><a href="pending_po.php"><h1 class="mt-2 mb-2"><?php echo $penpo; ?></h1></a></span>
													<span class="col-4 text-muted"><a href="pending_grn.php"><h1 class="mt-2 mb-2"><?php echo $pengrn; ?></h1></a></span>
												</div>
												<div class="row">
													<span class="col-4 text-success">Quotation</span>
													<span class="col-4 text-info">Purchase Order</span>
													<span class="col-4 text-primary">GRN</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-xl-6 col-xxl-7">
							<div class="card flex-fill w-100">
								<div class="card-header">

									<h5 class="card-title mb-0">Monthly Sales - <?php echo $cur_year; ?></h5>
								</div>
								<div class="card-body py-3">
									<div class="chart chart-sm">
										<canvas id="chartjs-dashboard-bar2"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-12 col-lg-7 col-xxl-7 d-flex">
							<div class="card flex-fill w-100">
								<div class="card-header">
									<div class="float-end">
										<form class="row g-2" method="POST">
											<div class="col-auto">
												<select id="chart_bar_month" name="chart_bar_month" class="form-select form-select-sm bg-light border-0" onchange="this.form.submit()">
													<?php
													for ($i = 1; $i <= 12; $i++) {
														$value_1 = sprintf('%02d', $i);
														$label_1 = date("M", mktime(0, 0, 0, $value_1, 3));
													?>
														<option value="<?php echo $value_1; ?>" <?php if($value_1 == $month_only1){ echo 'selected'; } ?> ><?php echo $label_1; ?></option>";
													<?php } ?>
												</select>
											</div>
										</form>
									</div>
									<h5 class="card-title mb-0">Item wise Sale</h5>
								</div>
								<div class="card-body d-flex w-100">
									<div class="align-self-center chart chart-lg" id="big_div">
										<canvas id="chartjs-dashboard-bar"></canvas>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-5 col-xxl-5 d-flex order-2 order-xxl-3">
							<div class="card flex-fill w-100">
								<div class="card-header">
									<div class="float-end">
										<form class="row g-2" method="POST">
											<div class="col-auto">
												<select id="chart_pie_month" name="chart_pie_month" class="form-select form-select-sm bg-light border-0" onchange="this.form.submit()">
													<?php
													for ($j = 1; $j <= 12; $j++) {
														$value_2 = sprintf('%02d', $j);
														$label_2 = date("M", mktime(0, 0, 0, $value_2, 3));
													?>
														<option value="<?php echo $value_2; ?>" <?php if($value_2 == $month_only2){ echo 'selected'; } ?> ><?php echo $label_2; ?></option>
													<?php } ?>
												</select>
											</div>
										</form>
									</div>
									<h5 class="card-title mb-0">Sales Person wise Sale</h5>
								</div>
								<div class="card-body d-flex">
									<div class="align-self-center w-100">
										<div class="py-3">
											<div class="chart chart-xs">
												<canvas id="chartjs-dashboard-pie"></canvas>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<?php
					}		// for admin & manager - end
					else if($_SESSION["logUserType"] == 2) {		// for accountant - start
					?>
					
					<div class="row">
						<div class="col-xl-12 col-xxl-12 d-flex">
							<div class="w-100">
								<div class="row">
									<div class="col-sm-4">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Pending for invoice</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="alert-circle"></i>
														</div>
													</div>
												</div>
												<?php
												//Pending jobs for invoicing
												$select_penjob = mysqli_query($con, "SELECT COUNT(id), completed_qty, invoiced_qty FROM jobcard_details GROUP BY jobcard_id HAVING CAST(completed_qty AS UNSIGNED) > CAST(invoiced_qty AS UNSIGNED)");
												$result_penjob = mysqli_fetch_array($select_penjob);

												if(mysqli_num_rows($select_penjob) > 0){
													$penjob = mysqli_num_rows($select_penjob);
												} else {
													$penjob = 0;
												}
												?>
												<h1 class="mt-2 mb-2"><?php echo $penjob; ?></h1>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Collection of Today</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="dollar-sign"></i>
														</div>
													</div>
												</div>
												<?php
												//collection of today
												$select_coll1 = mysqli_query($con, "SELECT SUM(amount) FROM advance_payment WHERE rec_date LIKE '$cur_date'");
												$result_coll1 = mysqli_fetch_array($select_coll1);

												$select_coll2 = mysqli_query($con, "SELECT SUM(amount) FROM receipt WHERE rec_date LIKE '$cur_date'");
												$result_coll2 = mysqli_fetch_array($select_coll2);
												?>
												<h1 class="mt-2 mb-2">Rs.<?php echo number_format($result_coll1[0]+$result_coll2[0],2,'.',','); ?></h1>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Payments of Today</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="file-text"></i>
														</div>
													</div>
												</div>
												<?php
												//payments of today
												$select_pay = mysqli_query($con, "SELECT SUM(amount) FROM payment_voucher WHERE v_date LIKE '$cur_date'");
												$result_pay = mysqli_fetch_array($select_pay);
												?>
												<h1 class="mt-2 mb-2">Rs.<?php echo number_format($result_pay[0],2,'.',','); ?></h1>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
					}		// for accountant - end
					else if($_SESSION["logUserType"] == 3) {		// for coordinator - start
					?>
					
					<div class="row">
						<div class="col-xl-12 col-xxl-12 d-flex">
							<div class="w-100">
								<div class="row">
									<div class="col-sm-4">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Pending for jobcard</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="alert-circle"></i>
														</div>
													</div>
												</div>
												<?php
												//Pending for jobcard
												$select_penjob = mysqli_query($con, "SELECT COUNT(id) FROM quotation WHERE job_alloc = 'yes' AND jobcard = 'no' AND job_user = '{$_SESSION["logUserId"]}'");
												$result_penjob = mysqli_fetch_array($select_penjob);

												if($result_penjob[0] == ''){
													$penjob = 0;
												} else {
													$penjob = $result_penjob[0];
												}
												?>
												<h1 class="mt-2 mb-2"><?php echo $penjob; ?></h1>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Jobs being processed</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="edit"></i>
														</div>
													</div>
												</div>
												<?php
												//jobs being processed
												$select_projob = mysqli_query($con, "SELECT COUNT(jd.id), jd.qty, jd.completed_qty, j.log_user FROM jobcard_details jd, jobcard j WHERE jd.jobcard_id = j.id AND CAST(jd.qty AS UNSIGNED) >  CAST(jd.completed_qty AS UNSIGNED) AND j.log_user = '{$_SESSION["logUserId"]}'");
												$result_projob = mysqli_fetch_array($select_projob);

												if($result_projob[0] == ''){
													$projob = 0;
												} else {
													$projob = $result_projob[0];
												}
												?>
												<h1 class="mt-2 mb-2"><?php echo $projob; ?></h1>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Pending for delivery</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="truck"></i>
														</div>
													</div>
												</div>
												<?php
												//pending for delivery
												$select_pendel = mysqli_query($con, "SELECT COUNT(i.id) FROM invoice i, jobcard j WHERE i.jobcard_id = j.id AND i.inv_type = 'jobcard' AND i.delivery = 'no' AND j.log_user = '{$_SESSION["logUserId"]}'");
												$result_pendel = mysqli_fetch_array($select_pendel);

												if($result_pendel[0] == ''){
													$pendel = 0;
												} else {
													$pendel = $result_pendel[0];
												}
												?>
												<h1 class="mt-2 mb-2"><?php echo $pendel; ?></h1>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
					}		// for coordinator - end
					else if($_SESSION["logUserType"] == 4) {		// for inventory officer - start
					?>
					
					<div class="row">
						<div class="col-xl-12 col-xxl-12 d-flex">
							<div class="w-100">
								<div class="row">
									<div class="col-sm-4">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Pending PO for approval</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="alert-circle"></i>
														</div>
													</div>
												</div>
												<?php
												//Pending PO for approval
												$select_penpo = mysqli_query($con, "SELECT COUNT(id) FROM purchase_order_summary WHERE approval = 'pending'");
												$result_penpo = mysqli_fetch_array($select_penpo);

												if($result_penpo[0] == ''){
													$penpo = 0;
												} else {
													$penpo = $result_penpo[0];
												}
												?>
												<h1 class="mt-2 mb-2"><?php echo $penpo; ?></h1>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Pending GRN for approval</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="alert-circle"></i>
														</div>
													</div>
												</div>
												<?php
												//pending GRN for approval
												$select_grn = mysqli_query($con, "SELECT COUNT(id) FROM grn_summary WHERE approval = 'pending'");
												$result_grn = mysqli_fetch_array($select_grn);
												
												if($result_grn[0] == ''){
													$pengrn = 0;
												} else {
													$pengrn = $result_grn[0];
												}
												?>
												<h1 class="mt-2 mb-2"><?php echo $pengrn; ?></h1>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Pending PO for GRN</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="package"></i>
														</div>
													</div>
												</div>
												<?php
												//pending PO for GRN
												$select_tobegrn = mysqli_query($con, "SELECT COUNT(id) FROM purchase_order_summary WHERE approval = 'yes' AND grn = 'no'");
												$result_tobegrn = mysqli_fetch_array($select_tobegrn);
												
												if($result_tobegrn[0] == ''){
													$pentobegrn = 0;
												} else {
													$pentobegrn = $result_tobegrn[0];
												}
												?>
												<h1 class="mt-2 mb-2"><?php echo $pentobegrn; ?></h1>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
					}		// for inventory officer - end
					else if($_SESSION["logUserType"] == 6) {		// for sales executive - start
					?>
					
					<div class="row">
						<div class="col-xl-12 col-xxl-12 d-flex">
							<div class="w-100">
								<div class="row">
									<div class="col-sm-4">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Pending Quote for approval</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="alert-circle"></i>
														</div>
													</div>
												</div>
												<?php
												//Pending quote for approval
												$select_quot = mysqli_query($con, "SELECT COUNT(id) FROM quotation WHERE approval = 'no' AND sales_ex = '{$_SESSION["logUserId"]}'");
												$result_quot = mysqli_fetch_array($select_quot);
												
												if($result_quot[0] == ''){
													$penquot = 0;
												} else {
													$penquot = $result_quot[0];
												}
												?>
												<h1 class="mt-2 mb-2"><?php echo $penquot; ?></h1>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Quotes to be confirmed</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="alert-circle"></i>
														</div>
													</div>
												</div>
												<?php
												//quotes to be confirmed
												$select_quot2 = mysqli_query($con, "SELECT COUNT(id) FROM quotation WHERE approval = 'yes' AND confirm = 'no' AND sales_ex = '{$_SESSION["logUserId"]}'");
												$result_quot2 = mysqli_fetch_array($select_quot2);
												
												if($result_quot2[0] == ''){
													$penquot2 = 0;
												} else {
													$penquot2 = $result_quot2[0];
												}
												?>
												<h1 class="mt-2 mb-2"><?php echo $penquot2; ?></h1>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Achieved Sales</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="dollar-sign"></i>
														</div>
													</div>
												</div>
												<?php
												//acieved sales
												$select_asales = mysqli_query($con, "SELECT SUM(i.total) FROM quotation q, jobcard j, invoice i WHERE j.quotation_id = q.id AND i.jobcard_id = j.id AND q.sales_ex = '{$_SESSION["logUserId"]}' AND i.invoice_date LIKE '$cur_mont%'");
												$result_asales = mysqli_fetch_array($select_asales);
												
												if($result_asales[0] == ''){
													$penasale = 0;
												} else {
													$penasale = $result_asales[0];
												}
												?>
												<h1 class="mt-2 mb-2">Rs.<?php echo number_format($penasale,2,'.',','); ?></h1>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
					}		// for sales executive - end
					?>

					<div class="row">
						<div class="col-12 col-lg-8 col-xxl-9 d-flex">
							<div class="card flex-fill">
								<div class="card-header">

									<h5 class="card-title mb-0">Ongoing Jobs</h5>
								</div>
								<table class="table table-hover my-0">
									<thead>
										<tr>
											<th>Quotation No.</th>
											<th class="d-none d-xl-table-cell">Customer</th>
											<th class="d-none d-xl-table-cell">Confirmed Date</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$select_job = mysqli_query($con, "SELECT q.q_no, q.cus_id, q.conf_datetime, q.job_alloc, q.jobcard, jd.qty, jd.completed_qty, jd.invoiced_qty FROM quotation q, quotation_details qd, jobcard_details jd WHERE q.id = qd.quot_id AND qd.id = jd.qitm_id AND jd.qty > jd.invoiced_qty");
										while($result_job = mysqli_fetch_array($select_job)){

											$select_cus = mysqli_query($con, "SELECT name, last_name FROM customer WHERE id = '{$result_job['cus_id']}'");
											$result_cus = mysqli_fetch_array($select_cus);

											if($result_job['job_alloc'] == 'no'){
												$job_text = 'Pending';
												$job_color = 'danger';
											} else if($result_job['jobcard'] == 'no'){
												$job_text = 'Allocated';
												$job_color = 'warning';
											} else if($result_job['qty'] > $result_job['completed_qty']) {
												$job_text = 'In Progress';
												$job_color = 'primary';
											} else if($result_job['completed_qty'] > $result_job['invoiced_qty']){
												$job_text = 'To Be Invoiced';
												$job_color = 'success';
											}
										?>
										<tr>
											<td><?php echo $result_job['q_no']; ?></td>
											<td class="d-none d-xl-table-cell"><?php echo $result_cus['name'].' '.$result_cus['last_name']; ?></td>
											<td class="d-none d-xl-table-cell"><?php echo substr($result_job['conf_datetime'], 0, 10); ?></td>
											<td><span class="badge bg-<?php echo $job_color; ?>"><?php echo $job_text; ?></span></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-12 col-md-4 col-xxl-3 d-flex order-1 order-xxl-1">
							<div class="card flex-fill">
								<div class="card-header">

									<h5 class="card-title mb-0">Calendar</h5>
								</div>
								<div class="card-body d-flex">
									<div class="align-self-center w-100">
										<div class="chart">
											<div id="datetimepicker-dashboard"></div>
										</div>
									</div>
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

	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Pie chart
			new Chart(document.getElementById("chartjs-dashboard-pie"), {
				type: "pie",
				data: {
					labels: <?php echo $chart_name; ?>,
					datasets: [{
						data: <?php echo $chart_amt; ?>,
						backgroundColor: [
							'#56e2cf', '#56aee2', '#5669e2', '#8956e2', '#cf56e2', '#e256af', '#e25668', '#e28956', '#e2cf56', '#afe256', '#68e256', '#56e289'
						],
						borderWidth: 2
					}]
				},
				options: {
					responsive: !window.MSInputMethodContext,
					maintainAspectRatio: false,
					legend: {
						display: true,
						position: 'right'
					},
					cutoutPercentage: 60
				}
			});
		});
	</script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Bar chart
			new Chart(document.getElementById("chartjs-dashboard-bar"), {
				type: "bar",
				data: {
					labels: <?php echo $bar_chart_name; ?>,
					datasets: [{
						label: "Rs.",
						backgroundColor: window.theme.primary,
						borderColor: window.theme.primary,
						hoverBackgroundColor: window.theme.primary,
						hoverBorderColor: window.theme.primary,
						data: <?php echo $bar_chart_amt; ?>,
						barPercentage: .75,
						categoryPercentage: .5
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					scales: {
						yAxes: [{
							gridLines: {
								display: false
							},
							stacked: false,
							ticks: {
								stepSize: 2500
							}
						}],
						xAxes: [{
							stacked: false,
							gridLines: {
								color: "transparent"
							}
						}]
					}
				}
			});
		});

	</script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Bar chart
			new Chart(document.getElementById("chartjs-dashboard-bar2"), {
				type: "bar",
				data: {
					labels: <?php echo $mon_chart_name; ?>,
					datasets: [{
						label: "Rs.",
						backgroundColor: window.theme.danger,
						borderColor: window.theme.danger,
						hoverBackgroundColor: window.theme.danger,
						hoverBorderColor: window.theme.danger,
						data: <?php echo $mon_chart_amt; ?>,
						barPercentage: .75,
						categoryPercentage: .5
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					scales: {
						yAxes: [{
							gridLines: {
								display: false
							},
							stacked: false,
							ticks: {
								stepSize: 2500
							}
						}],
						xAxes: [{
							stacked: false,
							gridLines: {
								color: "transparent"
							}
						}]
					}
				}
			});
		});
	</script>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			var date = new Date(Date.now() - 5 * 24 * 60 * 60 * 1000);
			var defaultDate = date.getUTCFullYear() + "-" + (date.getUTCMonth() + 1) + "-" + date.getUTCDate();
			document.getElementById("datetimepicker-dashboard").flatpickr({
				inline: true,
				prevArrow: "<span title=\"Previous month\">&laquo;</span>",
				nextArrow: "<span title=\"Next month\">&raquo;</span>",
				defaultDate: defaultDate
			});
		});
	</script>

</body>

</html>