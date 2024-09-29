<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('header.php'); ?>
	<?php include('db_connection.php'); ?>
	<?php
	//Set time zone
	$createToday = new DateTime('now', new DateTimeZone('Asia/Colombo'));
	$cur_date = $createToday->format('Y-m-d');
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
					<h1 class="h3 mb-3 col-10">Stock Movement Report</h1>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">

									<form method="post" name="report" action="" >
										<div class="row form-group mb-3">
											<div class="col-3 mb-3">
												<label class="form-label">From Date</label>
												<input type="text" class="form-control flatpickr-minimum flatpickr-input" name="from_date" id="from_date" value="<?php echo $cur_date; ?>" readonly >
											</div>
											<div class="col-3 mb-3">
												<label class="form-label">To Date</label>
												<input type="text" class="form-control flatpickr-minimum flatpickr-input" name="to_date" id="to_date" value="<?php echo $cur_date; ?>" readonly >
											</div>
											<div class="col-4 mb-3">
												<label class="form-label">Raw Material</label>
												<select class="form-select" name="rawmat" id="rawmat" >
													<option value="">-Please Select-</option>
													<?php
													$select_rm = mysqli_query($con, "SELECT id, name FROM rawmaterial");
													while($result_rm = mysqli_fetch_array($select_rm)){
													?>
													<option value="<?php echo $result_rm['id']; ?>"><?php echo $result_rm['name']; ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-2 mb-3">
												<label class="form-label col-12">&nbsp;</label>
												<input type="button" class="btn btn-success" name="submit" id="submit" value="Search" onclick="get_report()" >
											</div>
										</div>

										<div id="loader_div" style="padding-left:20px; font-weight:bold"></div>
										<div id="report_div"></div>

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
		document.addEventListener("DOMContentLoaded", function() {
			// Flatpickr
			flatpickr(".flatpickr-minimum", {
				maxDate: "today"
			});
		});

		function get_report(){
			
			var fromDate = $("#from_date").val();
			var toDate = $("#to_date").val();
			var rawmat = $("#rawmat").val();

			if(fromDate != '' && toDate != '' && rawmat != ''){
		
				$("#report_div").empty();
				$("#loader_div").empty();		// Waiting Div
				$("#loader_div").append('<img src="img/icons/spinner.gif" alt="Loading..." title="Loading"/>  Please wait while processing !!');
		
			$.post("get_stockm_report.php", {
				fromDate:fromDate,
				toDate:toDate,
				rawmat:rawmat
			},
			
			function(data,status) {
				$("#loader_div").empty();
				$("#report_div").empty();			
				$("#report_div").append(data);
			});
		
			} else {
				alert('Please select date range and raw material!');
			}
			
		}

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

</body>

</html>