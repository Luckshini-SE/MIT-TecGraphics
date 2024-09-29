<!DOCTYPE html>
<html lang="en">

<head>
  <?php include('web_header.php'); ?>
	<style>
	
	.error_msg {
		color: rgba(255,0,0,.80);
        font-size: 12px;
	}

	.error {
		/*box-shadow:0 0 0 .2rem rgba(255,0,0,.45);*/
        border: 1px solid rgba(255,0,0,.80);
	}

	</style>
</head>

<body>

  <!-- ======= Header ======= -->

  <!-- End Header -->
    <?php include('web_navbar.php'); ?>
    <?php include('db_connection.php'); ?>

  <main id="main">

    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Service Details</h2>
          <ol>
            <li><a href="index.php">Home</a></li>
            <li>Service Details</li>
          </ol>
        </div>

      </div>
    </section><!-- Breadcrumbs Section -->

    <?php
    $prod = $_GET["pid"];

    $select_prod = mysqli_query($con, "SELECT * FROM products WHERE id = '$prod'");
    $result_prod = mysqli_fetch_array($select_prod);

    $select_unit = mysqli_query($con, "SELECT measure FROM pricing WHERE id = '{$result_prod['pricing']}'");
    $result_unit = mysqli_fetch_array($select_unit);
    ?>

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-6">
            <div class="portfolio-details-slider swiper">
              <div class="swiper-wrapper align-items-center">

              <?php 
              for($i=1; $i<=3; $i++){ 
                  if($result_prod['image'.$i] != ''){
              ?>

                <div class="swiper-slide">
                  <img src="assets/img/portfolio/<?php echo $result_prod['image'.$i]; ?>" alt="">
                </div>

              <?php }} ?>

              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="portfolio-info">
              <h3><?php echo $result_prod['name']; ?></h3>
              
              <form name="service_form" id="mainForm" action="details_submit.php" method="post" role="form" class="php-email-form" enctype="multipart/form-data" >
                 <div class="row mb-3">
                    
                    <input type="hidden" name="prodid" id="prodid" value="<?php echo $prod; ?>" />

                    <?php if($result_prod['material'] == 1){ ?>
                    <div class="form-group col-md-6">
                      <label for="artwork">Type/Material</label>
                      <select class="form-select" name="material" id="material" >
                        <?php
                        $select_mat = mysqli_query($con, "SELECT * FROM pro_material WHERE prod_id = '{$result_prod['id']}'");
						while($result_mat = mysqli_fetch_array($select_mat)){
                        ?>
                        <option value="<?php echo $result_mat['id']; ?>"><?php echo $result_mat['name']; ?></option>
                        <?php } ?>
                      </select>
                      <span id="material_error" ></span>
                    </div>
                    <?php } ?>

                    <?php 
                    if($result_prod['pricing'] == 1){ 
                    if($result_prod['size'] == 1){ 
                    ?>
                    <div class="form-group col-md-6">
                      <label for="artwork">Size</label>
                      <select class="form-select" name="size" id="size" >
                        <?php
                        $select_siz = mysqli_query($con, "SELECT * FROM pro_size WHERE prod_id = '{$result_prod['id']}'");
						while($result_siz = mysqli_fetch_array($select_siz)){
                        ?>
                        <option value="<?php echo $result_siz['id']; ?>"><?php echo $result_siz['name']; ?></option>
                        <?php } ?>
                      </select>
                      <span id="aw_error" ></span>
                    </div>
                    <?php }} else { ?>
                    <div class="form-group col-md-3">
                      <label for="artwork">Size (<?php echo $result_unit['measure']; ?>)</label>
                      <input type="text" class="form-control" name="width" id="width" placeholder="Width" onkeypress="return isNumberKeyn(event);" />
                      <span class="error_msg" id="wd_error" ></span>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="artwork">&nbsp;</label>
                      <input type="text" class="form-control" name="height" id="height" placeholder="Height" onkeypress="return isNumberKeyn(event);" />
                      <span class="error_msg" id="ht_error" ></span>
                    </div>
                    <?php } ?>
                    
                    <?php if($result_prod['finishing'] == 1){ ?>
                    <div class="form-group col-md-6">
                      <label for="artwork">Finishing</label>
                      <select class="form-select" name="finishing" id="finishing" >
                        <?php
                        $select_fin = mysqli_query($con, "SELECT * FROM pro_finishing WHERE prod_id = '{$result_prod['id']}'");
						while($result_fin = mysqli_fetch_array($select_fin)){
                        ?>
                        <option value="<?php echo $result_fin['id']; ?>"><?php echo $result_fin['name']; ?></option>
                        <?php } ?>
                      </select>
                      <span id="aw_error" ></span>
                    </div>
                    <?php } ?>
                    
                    <?php if($result_prod['color'] == 1){ ?>
                    <div class="form-group col-md-6">
                      <label for="artwork">Colour</label>
                      <select class="form-select" name="color" id="color" >
                        <?php
                        $select_col = mysqli_query($con, "SELECT * FROM pro_color WHERE prod_id = '{$result_prod['id']}'");
						while($result_col = mysqli_fetch_array($select_col)){
                        ?>
                        <option value="<?php echo $result_col['id']; ?>"><?php echo $result_col['name']; ?></option>
                        <?php } ?>
                      </select>
                      <span id="aw_error" ></span>
                    </div>
                    <?php } ?>
                    
                    <?php if($result_prod['spec1'] == 1){ ?>
                    <div class="form-group col-md-6">
                      <label for="artwork">Specification 1</label>
                      <select class="form-select" name="spec1" id="spec1" >
                        <?php
                        $select_spo = mysqli_query($con, "SELECT * FROM pro_spec1 WHERE prod_id = '{$result_prod['id']}'");
						while($result_spo = mysqli_fetch_array($select_spo)){
                        ?>
                        <option value="<?php echo $result_spo['id']; ?>"><?php echo $result_spo['name']; ?></option>
                        <?php } ?>
                      </select>
                      <span id="aw_error" ></span>
                    </div>
                    <?php } ?>
                    
                    <?php if($result_prod['spec2'] == 1){ ?>
                    <div class="form-group col-md-6">
                      <label for="artwork">Specification 2</label>
                      <select class="form-select" name="spec2" id="spec2" >
                        <?php
                        $select_spt = mysqli_query($con, "SELECT * FROM pro_spec2 WHERE prod_id = '{$result_prod['id']}'");
						while($result_spt = mysqli_fetch_array($select_spt)){
                        ?>
                        <option value="<?php echo $result_spt['id']; ?>"><?php echo $result_spt['name']; ?></option>
                        <?php } ?>
                      </select>
                      <span id="aw_error" ></span>
                    </div>
                    <?php } ?>

                    <div class="form-group col-md-6">
                      <label for="quantity">Quantity</label>
                      <input type="text" class="form-control" name="quantity" id="quantity" placeholder="Quantity" onkeypress="return isNumberKey(event);" >
                      <span class="error_msg" id="quantity_error" ></span>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="artwork">Artwork</label>
                      <select class="form-select" name="artwork" id="artwork" >
                        <option value="need">I need artwork</option>
                        <option value="not">I will provide artwork</option>
                      </select>
                      <span id="aw_error" ></span>
                    </div>
                    
                    <div class="form-group col-md-6">
                      <label for="service">Service Type</label>
                      <select class="form-select" name="service" id="service" >
                        <option value="standard">Standard</option>
                        <option value="oneday">One Day</option>
                      </select>
                      <span id="st_error" ></span>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="upload1">Upload 1</label>
                      <input type="file" class="form-control" name="upload1" id="upload1" >
                    </div>
                    
                    <div class="form-group col-md-6">
                      <label for="upload2">Upload 2</label>
                      <input type="file" class="form-control" name="upload2" id="upload2" >
                    </div>

                    <div class="form-group col-md-12">
                      <label for="spnote">Special Note</label>
                      <textarea class="form-control" name="spnote" id="spnote" rows="3" ></textarea>
                    </div>

                 </div>

                 <div class="row mb-3">
                    <div class="text-center">
                        <button type="button" onclick="validateForm()" >Request a quote</button>
                    </div>
                 </div>

              </form>

            </div>
            
          </div>

        </div>

      </div>
    </section><!-- End Portfolio Details Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php include('web_footer.php'); ?>

<script>

function isNumberKey(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if (charCode == 8 || (charCode > 47 && charCode < 58)) { // Allow Numbers, Delete & Back Space
		return true;
	} else {
	    return false;
	}
}

function isNumberKeyn(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if ((charCode > 47 && charCode < 58) || charCode == 46) {	// Allow Numbers, Full Stop, Delete & Back Space
		return true;
	} else {
		return false;
	}
}

function validateForm() {
  var prevent = '';

  let quantity = document.forms["service_form"]["quantity"].value;
  if (quantity == "") {
	document.getElementById("quantity_error").innerHTML = "Quantity must be filled";
	document.getElementById("quantity").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("quantity_error").innerHTML = "";
	document.getElementById("quantity").className  = "form-control";
  }

  <?php if($result_prod['pricing'] != 1){ ?>
  let width = document.forms["service_form"]["width"].value;
  if (width == "") {
	document.getElementById("wd_error").innerHTML = "Width must be filled";
	document.getElementById("width").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("wd_error").innerHTML = "";
	document.getElementById("width").className  = "form-control";
  }

  let height = document.forms["service_form"]["height"].value;
  if (height == "") {
	document.getElementById("ht_error").innerHTML = "Height must be filled";
	document.getElementById("height").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("ht_error").innerHTML = "";
	document.getElementById("height").className  = "form-control";
  }
  <?php } ?>
  
  if(prevent == 'yes'){
	  //return false;
  } else {
      <?php if(isset($_SESSION["customerId"])){ ?>
        document.getElementById('mainForm').submit();
      <?php } else { ?>
        openModal();
      <?php } ?>
  }
}
  
function addtoquote(){
    document.getElementById('mainForm').submit();
}

</script>

</body>

</html>