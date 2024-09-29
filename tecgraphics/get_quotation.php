<!DOCTYPE html>
<html lang="en">

<head>
  <?php include('web_header.php'); ?>

  <style>
	
	span {
		color: red;
        font-size: 14px;
	}

    .product-block {
        box-shadow: 0px 0 30px rgba(0, 0, 0, 0.15);
        border: 1px solid #f5d5c6;
        margin: 10px 15px 30px 15px;
        padding: 20px;
        font-size: 14px;
    }

    .product-add {
        box-shadow: 0px 0 30px rgba(0, 0, 0, 0.15);
        border: 1px solid #f5d5c6;
        margin: 10px 15px 30px 15px;
        padding: 15px;
        height: 100px;
        width: 100px;
    }
    
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

<?php
unset($_SESSION["req"]);

include('db_connection.php');
    
if(isset($_GET['res'])){
    $res = $_GET['res'];
    $ref = $_GET['ref'];

    $select_ref = mysqli_query($con, "SELECT req_no FROM quotation_requests WHERE id = '$ref'");
    $result_ref = mysqli_fetch_array($select_ref);
        $ref_no = mysqli_real_escape_string($con, $result_ref['req_no']);
} else {
    $res = '';
}

if(isset($_SESSION["customerId"])){
    $cust_id = $_SESSION["customerId"];
    
    $select_cus = mysqli_query($con, "SELECT ctype, title, name, last_name, phone, email, mobile FROM customer WHERE id = '$cust_id'");
    $result_cus = mysqli_fetch_array($select_cus);
        $cus_type = $result_cus['ctype'];
        $cus_title = $result_cus['title'];
        $cus_fname = $result_cus['name'];
        $cus_lname = $result_cus['last_name'];
        $cus_mobile = $result_cus['mobile'];
        $cus_phone = $result_cus['phone'];
        $cus_email = $result_cus['email'];
} else {
    $cust_id = $cus_type = $cus_title = $cus_fname = $cus_lname = $cus_mobile = $cus_phone = $cus_email = '';
}
?>

<body>

  <!-- ======= Header ======= -->

  <!-- End Header -->
    <?php include('web_navbar.php'); ?>
  
    <!-- ======= Contact Us Section ======= -->
    <section id="contact2" class="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-title" style="padding-top: 30px;">
          <h2>&nbsp;</h2>
          <p>Contact us to get started</p>
        </div>

        <div class="row">

          <div class="col-lg-12 mt-5 mt-lg-0 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
            <form name="contact_form" action="get_quotation_submit.php" method="post" role="form" class="php-email-form" enctype="multipart/form-data" onsubmit="return validateForm()" >
              <div class="my-3">
                <?php if ($res == 'y') { ?>
                <div class="sent-message">Your request has been sent. Your reference number is <?php echo $ref_no; ?>. Thank you!</div>
                <?php } else if ($res == 'n') { ?>
                <div class="error-message">Error in sending request. Try again!</div>
                <?php } ?>
              </div>
              <div class="row">
                  <div class="form-group col-md-8" style="border-right:1px solid #eb5d1e;">
                    <?php
                    $i=1;
                    if(isset($_SESSION["customerId"])){
                    $select_prod = mysqli_query($con, "SELECT * FROM requests WHERE cust_id = '$cust_id' AND status = 'open'");
                    while($result_prod = mysqli_fetch_array($select_prod)){

                        $select_prodname = mysqli_query($con, "SELECT name FROM products WHERE id = '{$result_prod['prod_id']}'");
                        $result_prodname = mysqli_fetch_array($select_prodname);

                        $description = '';

                        if($result_prod['material'] != ''){
                            $select_mat = mysqli_query($con, "SELECT name FROM pro_material WHERE id = '{$result_prod['material']}'");
                            $result_mat = mysqli_fetch_array($select_mat);

                            $description .= $result_mat['name'];
                        }
                        
                        if($result_prod['size'] != ''){
                            $select_siz = mysqli_query($con, "SELECT name FROM pro_size WHERE id = '{$result_prod['size']}'");
                            $result_siz = mysqli_fetch_array($select_siz);

                            $description .= ' | '.$result_siz['name'];
                        }
                        
                        if($result_prod['finishing'] != ''){
                            $select_fin = mysqli_query($con, "SELECT name FROM pro_finishing WHERE id = '{$result_prod['finishing']}'");
                            $result_fin = mysqli_fetch_array($select_fin);

                            $description .= ' | '.$result_fin['name'];
                        }
                        
                        if($result_prod['color'] != ''){
                            $select_col = mysqli_query($con, "SELECT name FROM pro_color WHERE id = '{$result_prod['color']}'");
                            $result_col = mysqli_fetch_array($select_col);

                            $description .= ' | '.$result_col['name'];
                        }
                        
                        if($result_prod['spec1'] != ''){
                            $select_sp1 = mysqli_query($con, "SELECT name FROM pro_spec1 WHERE id = '{$result_prod['spec1']}'");
                            $result_sp1 = mysqli_fetch_array($select_sp1);

                            $description .= ' | '.$result_sp1['name'];
                        }
                        
                        if($result_prod['spec2'] != ''){
                            $select_sp2 = mysqli_query($con, "SELECT name FROM pro_spec2 WHERE id = '{$result_prod['spec2']}'");
                            $result_sp2 = mysqli_fetch_array($select_sp2);

                            $description .= ' | '.$result_sp2['name'];
                        }

                    ?>
                    <div class="product-block">
                      <div class="row">
                        <div class="col-md-8">
                            <b><?php echo $result_prodname['name']; ?></b><br/><?php echo $description; ?>
                        </div>
                        <div class="col-md-2" style="margin-top:10px;" >
                            Qty : <?php echo $result_prod['qty']; ?>
                        </div>
                        <div class="col-md-2" align="center" >
                            <button type="button" class="btn btn-xs" style="background-color:#f5d5c6;" onclick="removeitem(<?php echo $result_prod['id']; ?>)" >&times;</button>
                        </div>
                      </div>
                    </div>
                    <?php $i++; }} ?>

                    <input type="hidden" name="numrow" class="form-control" id="numrow" value="<?php echo $i-1; ?>" >

                    <a href="index.php#portfolio">
                    <div class="product-add">
                        <div style="font-size: 30px;" align="center">&plus;</div>
                        <div style="font-size: 12px;" align="center">Add service</div>
                    </div>
                    </a>
                    <span class="error_msg" id="service_error" ></span>
                  </div>
                  <div class="form-group col-md-4">
                      <input type="hidden" name="ctype" class="form-control" id="ctype" value="<?php echo $cus_type; ?>" >
                      <input type="hidden" name="cusid" class="form-control" id="cusid" value="<?php echo $cust_id; ?>" >

                      <?php if($cus_type == 'i'){ ?>
                      <div class="row">
                        <div class="form-group col-md-4">
                          <label for="name">Title</label>
                          <select name="title" class="form-select" id="title" >
                            <?php
			                $select_title  = mysqli_query($con, "SELECT id, title FROM title");
			                while($result_title = mysqli_fetch_array($select_title)){
			                ?>
			                <option value="<?php echo $result_title['id']; ?>" <?php if($result_title['id'] == $cus_title){ echo 'selected'; } ?> ><?php echo $result_title['title']; ?></option>
			                <?php } ?>
                          </select>
                          <span class="error_msg" id="title_error" ></span>
                        </div>
                        <div class="form-group col-md-8 mt-3 mt-md-0">
                          <label for="name">First Name</label>
                          <input type="text" name="fname" class="form-control" id="fname" placeholder="First Name" value="<?php echo $cus_fname; ?>" >
                          <span class="error_msg" id="fname_error" ></span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-12 mt-3 mt-md-0">
                          <label for="name">Last Name</label>
                          <input type="text" name="lname" class="form-control" id="lname" placeholder="Last Name" value="<?php echo $cus_lname; ?>" >
                          <span class="error_msg" id="lname_error" ></span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-12 mt-3 mt-md-0">
                          <label for="phone">Telephone No.</label>
                          <input type="text" name="phone" class="form-control" id="phone" placeholder="Mobile No." value="<?php echo $cus_mobile; ?>" >
                          <span class="error_msg" id="phone_error" ></span>
                        </div>
                      </div>
                      <?php } else { ?>
                      <div class="row">
                        <div class="form-group col-md-12 mt-3 mt-md-0">
                          <label for="name">Company Name</label>
                          <input type="fname" name="fname" class="form-control" id="fname" placeholder="Name" value="<?php echo $cus_fname; ?>" >
                          <span class="error_msg" id="fname_error" ></span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-12 mt-3 mt-md-0">
                          <label for="phone">Telephone No.</label>
                          <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone No." value="<?php echo $cus_phone; ?>" >
                          <span class="error_msg" id="phone_error" ></span>
                        </div>
                      </div>
                      <?php } ?>
                      <div class="row">
                        <div class="form-group col-md-12 mt-3 mt-md-0">
                          <label for="email">Email</label>
                          <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $cus_email; ?>" >
                          <span class="error_msg" id="email_error" ></span>
                        </div>
                      </div>
                  </div>
              </div>
              
              <div class="text-center"><button type="submit">Send Message</button></div>
            </form>
          </div>

        </div>

      </div>
    </section><!-- End Contact Us Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php include('web_footer.php'); ?>

<script>

function removeitem(itm){
    var form = document.createElement("form");
    form.setAttribute("method", "POST");
    form.setAttribute("action", "remove_item.php");

    //Move the submit function to another variable so that it doesn't get overwritten.
    form._submit_function_ = form.submit;

    var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "rmvId");
        hiddenField.setAttribute("value", itm);

        form.appendChild(hiddenField);
   
    document.body.appendChild(form);
    form._submit_function_();
}

function validateForm() {
  var prevent = '';

  if(document.getElementById('ctype').value == 'i'){
  
  let lname = document.forms["contact_form"]["lname"].value;
  if (lname == "") {
	document.getElementById("lname_error").innerHTML = "Last name must be filled out";
	document.getElementById("lname").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("lname_error").innerHTML = "";
	document.getElementById("lname").className  = "form-control";
  }

  }
  
  let fname = document.forms["contact_form"]["fname"].value;
  if (fname == "") {
	document.getElementById("fname_error").innerHTML = "Name is required";
	document.getElementById("fname").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("fname_error").innerHTML = "";
	document.getElementById("fname").className  = "form-control";
  }

  let phone = document.forms["contact_form"]["phone"].value;
  var regPhone=/^\d{10}$/;
  if (phone == "") {
	document.getElementById("phone_error").innerHTML = "Telephone must be filled out";
	document.getElementById("phone").className  = "form-control error";
	prevent = 'yes';
	return false;
  } else if (!regPhone.test(phone)) {
    document.getElementById("phone_error").innerHTML = "Telephone must have 10 digits";
	document.getElementById("phone").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("phone_error").innerHTML = "";
	document.getElementById("phone").className  = "form-control";
  }

  let email = document.forms["contact_form"]["email"].value;
  var regEmail=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/g;
  if (email == "") {
	document.getElementById("email_error").innerHTML = "Email must be filled out";
	document.getElementById("email").className  = "form-control error";
	prevent = 'yes';
  } else if (!regEmail.test(email)) {
    document.getElementById("email_error").innerHTML = "Invalid email format";
	document.getElementById("email").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("email_error").innerHTML = "";
	document.getElementById("email").className  = "form-control";
  }

  if(document.getElementById("numrow").value <= 0){
    document.getElementById("service_error").innerHTML = "Service must be selected";
    prevent = 'yes';
  } else {
    document.getElementById("service_error").innerHTML = "";
  }

  if(prevent == 'yes'){
	  return false;
  }

}
</script>

</body>

</html>