<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('header.php'); ?>
	<?php include('db_connection.php'); ?>
	<?php
	//Set time zone
	$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
	$cur_date = $createToday->format('Y-m-d');
	$cur_year = $createToday->format('Y');
													
	if(isset($_POST['submit'])){
		$rep_year = $_POST['rep_year'];
	} else {
		$rep_year = $cur_year;
	}

	$chart_name = '[';
	$chart_amt = '[';
	$select_sp = mysqli_query($con, "SELECT id, first_name FROM users WHERE user_type = '6'");
	while($result_sp = mysqli_fetch_array($select_sp)){
		$chart_name .= '"'.$result_sp['first_name'].'", ';

		$select_sale = mysqli_query($con, "SELECT SUM(i.total) FROM invoice i, jobcard j, quotation q WHERE i.jobcard_id = j.id AND j.quotation_id = q.id AND q.sales_ex = '{$result_sp['id']}' AND i.invoice_date LIKE '$rep_year%' AND i.cancel = 'no'");
		$result_sale = mysqli_fetch_array($select_sale);
			$chart_amt .= $result_sale[0].', ';
	}
	$chart_name = substr($chart_name,0,-2);
	$chart_name .= ']';

	$chart_amt = substr($chart_amt,0,-2);
	$chart_amt .= ']';
	?>
	
	<style>
	
	.error_msg {
		color: rgba(255,0,0,.80);
	}

	.error {
		box-shadow:0 0 0 .2rem rgba(255,0,0,.45);
	}

	</style>
</head>

<body>
	<div class="wrapper">

	<?php include('sidebar.php'); ?>

		<div class="main">
			
		<?php include('topbar.php'); ?>

			<main class="content">
				<div class="container-fluid p-0">

					<div class="row">
					<h1 class="h3 mb-3 col-10">Sales - Sales Person wise</h1>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">

									<form method="post" name="report" action="" >
										<div class="row form-group mb-3">
											<div class="col-3 mb-3">
												<label class="form-label">Year</label>
												<select class="form-select" name="rep_year" id="rep_year" >
													<?php
													for($i=0; $i <= 5; $i++){
													?>
														<option value="<?php echo $cur_year-$i; ?>" <?php if($rep_year == $cur_year-$i){ echo 'selected'; } ?> ><?php echo $cur_year-$i; ?></option>
													<?php
													}
													?>
												</select>
											</div>
											<div class="col-2 mb-3">
												<label class="form-label col-12">&nbsp;</label>
												<input type="submit" class="btn btn-success" name="submit" id="submit" value="Search" onclick="get_report()" >
											</div>
										</div>

										<div class="row">
											<div class="col-12 col-md-2 col-xxl-2 d-flex order-xxl-3">&nbsp;</div>
											<div class="col-12 col-md-8 col-xxl-8 d-flex order-xxl-3">
												<div class="card flex-fill w-100">
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
											<div class="col-12 col-md-2 col-xxl-2 d-flex order-xxl-3">&nbsp;</div>
										</div>

										<div class="row form-group mb-2">
											<div class="col-8">&nbsp;</div>
											<div class="col-4" align="right">
												<input type="button" class="btn btn-primary" value="Print" onclick="get_report_print('Sales Report - Sales Person wise')" >
												<input type="button" class="btn btn-warning" value="Excel" onclick="get_report_excel()" >
											</div>
										</div>

										<div id="rep_div">
											<table width="100%" class="table table-bordered" id="rep_tbl" >
												<thead>
												<tr>
													<th>Sales Ex.</th>
													<?php
													for($j=1; $j <= 12; $j++){
														$dateObj   = DateTime::createFromFormat('!m', $j);
														$monthName = $dateObj->format('M');
													?>
													<th><?php echo $monthName; ?></th>
													<?php } ?>
													<th>Total</th>
												</tr>
												</thead>
												<tbody>
												<?php
												$col_tot = array();
												$q=1;
												$grand_total = 0;
												$select_sp_t = mysqli_query($con, "SELECT id, first_name FROM users WHERE user_type = '6'");
												while($result_sp_t = mysqli_fetch_array($select_sp_t)){
												?>
												<tr>
													<td><?php echo $result_sp_t['first_name']; ?></td>
													<?php
													$row_tot = 0;
													for($k=1; $k <= 12; $k++){
														$monthNum = str_pad($k,2,"0",STR_PAD_LEFT);

														$newdate = $rep_year.'-'.$monthNum;

														$select_sale_t = mysqli_query($con, "SELECT SUM(i.total) FROM invoice i, jobcard j, quotation q WHERE i.jobcard_id = j.id AND j.quotation_id = q.id AND q.sales_ex = '{$result_sp_t['id']}' AND i.invoice_date LIKE '$newdate%' AND i.cancel = 'no'");
														$result_sale_t = mysqli_fetch_array($select_sale_t);

													?>
													<td align="right"><?php echo number_format($result_sale_t[0],2,'.',','); ?></td>
													<?php 
													$row_tot += number_format($result_sale_t[0],2,'.','');
													if($q == 1){
														$col_tot[$k] = number_format($result_sale_t[0],2,'.',''); 
													} else {
														$col_tot[$k] += number_format($result_sale_t[0],2,'.',''); 
													}
													
													} 
													$grand_total += $row_tot;
													?>
													<td align="right"><?php echo number_format($row_tot,2,'.',','); ?></td>
												</tr>
												<?php $q++; } ?>
												<tr>
													<td><b>Total</b></td>
													<?php
													for($p=1; $p <= 12; $p++){
														
													?>
													<td align="right"><?php echo number_format($col_tot[$p],2,'.',','); ?></td>
													<?php } ?>
													<td align="right"><?php echo number_format($grand_total,2,'.',','); ?></td>
												</tr>
												</tbody>
											</table>
										</div>

									</form>
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
	<script type="text/javascript" src="assets/js/jquery.min.js"></script>

	<script>
		
		function get_report_print(tit){
			var mywindow = window.open('', 'PRINT', 'height=400,width=600');

			mywindow.document.write('<html><head><title>' + document.title  + '</title>');
			mywindow.document.write('<style>table, th, td { border: 1px solid #7a6960; border-collapse: collapse; padding: 7px; }</style>');
			mywindow.document.write('</head><body >');
			mywindow.document.write('<h2>' + tit  + '</h2>');
			mywindow.document.write(document.getElementById('rep_div').innerHTML);
			mywindow.document.write('</body></html>');
			
			mywindow.document.close(); // necessary for IE >= 10
			mywindow.focus(); // necessary for IE >= 10*/

			mywindow.print();
			mywindow.close();

			return true;
		}

		function get_report_excel() {

            var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
            var textRange; var j=0;
            tab = document.getElementById('rep_tbl'); // id of table
  
               for(j = 0 ; j < tab.rows.length ; j++) 
               {     
                     tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
                     //tab_text=tab_text+"</tr>";
               }
  
               tab_text=tab_text+"</table>";
   
               var ua = window.navigator.userAgent;
               var msie = ua.indexOf("MSIE "); 
  
               if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
               {
                  txtArea1.document.open("txt/html","replace");
                  txtArea1.document.write(tab_text);
                  txtArea1.document.close();
                  txtArea1.focus(); 
                  sa=txtArea1.document.execCommand("SaveAs",true,"Global View Task.xls");
               }  
               else //other browser not tested on IE 11
                  sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  
                 return (sa);
         }
	</script>

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

</body>

</html>