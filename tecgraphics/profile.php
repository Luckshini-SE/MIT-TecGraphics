<!DOCTYPE html>
<html lang="en">

<head>
  <?php include('web_header.php'); ?>

  <style>
  .link {
      color: #7a6960; 
      margin-bottom:15px; 
      cursor: pointer;
  }

  .link:hover {
      color: #eb5d1e;
  }

  a {
      color: #7a6960; 
  }

  h5 {
      padding-bottom: 20px;
  }

  table, th, td {
      border: 1px solid #eb5d1e;
      color: #7a6960;
      padding: 7px;
      font-size: 14px;
  } 

  th {
      background-color: #eb5d1e;
      color: white;
  }

  .error_msg {
	  color: rgba(255,0,0,.80);
      font-size: 12px;
  }

  .error {
	  /*box-shadow:0 0 0 .2rem rgba(255,0,0,.45);*/
      border: 1px solid rgba(255,0,0,.80);
  }

  button {
    background: #ffc1a1;
    border: 1px solid #fc9662;
    padding: 7px 18px;
    color: #eb5d1e;
    transition: 0.4s;
    border-radius: 25px;
  }

  button:hover {
    background: #ef7f4d;
  }

  </style>
</head>
<?php 
if(!isset($_SESSION["customerId"])){    //if not signed in
?>
  <script>
    setTimeout('window.location="index.php"',0);
  </script>
<?php 
} else {      //if signed in

include('db_connection.php');

    $select_cus = mysqli_query($con, "SELECT * FROM customer WHERE id = '{$_SESSION["customerId"]}'");
    $result_cus = mysqli_fetch_array($select_cus);

?>
<body <?php if((isset($_SESSION['p_success']) && $_SESSION['p_success'] != '') || (isset($_SESSION['p_error']) && $_SESSION['p_error'] != '')){ ?>onload="change_div('pas')"<?php } ?>>

  <!-- ======= Header ======= -->

  <!-- End Header -->
    <?php include('web_navbar.php'); ?>

    <section id="" class="contact section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>&nbsp;</h2>
        </div>

        <div class="row">

          <div class="col-lg-3 d-flex align-items-stretch">
            <div class="info">
              
              <div class="link" onclick="change_div('det')" >
                Personal Details
              </div>

              <div class="link" onclick="change_div('ord')" >
                My Orders
              </div>
              
              <div class="link" onclick="change_div('pas')" >
                Change Password
              </div>
              
              <div class="link" >
                <a href="signout.php">Sign Out</a>
              </div>

            </div>
          </div>

          <div class="col-lg-9 mt-5 mt-lg-0 d-flex align-items-stretch">
            <div id="detail_div" style="width:100%">
            <form name="contact_form" action="profile_submit.php" method="post" role="form" class="php-email-form" onsubmit="return validateForm()" >
            <h5><b>Personal Details</b></h5>  
            <?php if($result_cus['ctype'] == 'i'){ ?>
              
              <div class="row">
                <div class="form-group col-md-3">
                  <label for="title">Title <span style="color:red">*</span></label>
                  <select name="title" class="form-select" id="title" >
                    <?php
			        $select_title  = mysqli_query($con, "SELECT id, title FROM title");
			        while($result_title = mysqli_fetch_array($select_title)){
			        ?>
			        <option value="<?php echo $result_title['id']; ?>" <?php if($result_title['id'] == $result_cus['title']){ echo 'selected'; } ?> ><?php echo $result_title['title']; ?></option>
			        <?php } ?>
                  </select>
                </div>
                <div class="form-group col-md-4">
                  <label for="fname">First Name <span style="color:red">*</span></label>
                  <input type="text" name="fname" class="form-control" id="fname" placeholder="First Name" value="<?php echo $result_cus['name']; ?>" >
                  <span class="error_msg" id="fname_error" ></span>
                </div>
                <div class="form-group col-md-5 mt-3 mt-md-0">
                  <label for="lname">Last Name <span style="color:red">*</span></label>
                  <input type="text" class="form-control" name="lname" id="lname" placeholder="Last Name" value="<?php echo $result_cus['last_name']; ?>" >
                  <span class="error_msg" id="lname_error" ></span>
                </div>
              </div>

              <div class="row">
                <div class="form-group col-md-4">
                  <label for="mobile">Mobile No. <span style="color:red">*</span></label>
                  <input type="text" name="mobile" class="form-control" id="mobile" placeholder="Mobile No." value="<?php echo $result_cus['mobile']; ?>" >
                  <span class="error_msg" id="mobile_error" ></span>
                </div>
                <div class="form-group col-md-4">
                  <label for="phone">Phone No.</label>
                  <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone No." value="<?php echo $result_cus['phone']; ?>" >
                  <span class="error_msg" id="phone_error" ></span>
                </div>
                <div class="form-group col-md-4 mt-3 mt-md-0">
                  <label for="email">Email <span style="color:red">*</span></label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $result_cus['email']; ?>" >
                  <span class="error_msg" id="email_error" ></span>
                </div>
              </div>
              
              <?php } else { ?>
              
              <div class="row">
                <div class="form-group col-md-5">
                  <label for="mobile">Company Name <span style="color:red">*</span></label>
                  <input type="text" name="fname" class="form-control" id="fname" placeholder="Company Name" value="<?php echo $result_cus['name']; ?>" >
                  <span class="error_msg" id="fname_error" ></span>
                </div>
                <div class="form-group col-md-3">
                  <label for="phone">Phone No. <span style="color:red">*</span></label>
                  <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone No." value="<?php echo $result_cus['phone']; ?>" >
                  <span class="error_msg" id="phone_error" ></span>
                </div>
                <div class="form-group col-md-4 mt-3 mt-md-0">
                  <label for="email">Email <span style="color:red">*</span></label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $result_cus['email']; ?>" >
                  <span class="error_msg" id="email_error" ></span>
                </div>
              </div>
              
              <?php } ?>

              <div class="row">
                <div class="form-group col-md-4">
                  <label for="address1">Address (Line 1) <span style="color:red">*</span></label>
                  <input type="text" name="address1" class="form-control" id="address1" placeholder="Line 1" value="<?php echo $result_cus['address1']; ?>" >
                  <span class="error_msg" id="addr_error" ></span>
                </div>
                <div class="form-group col-md-4">
                  <label for="address2">Address (Line 2)</label>
                  <input type="text" name="address2" class="form-control" id="address2" placeholder="Line 2" value="<?php echo $result_cus['address2']; ?>" >
                </div>
                <div class="form-group col-md-4 mt-3 mt-md-0">
                  <label for="address3">Address (Line 3)</label>
                  <input type="text" class="form-control" name="address3" id="address3" placeholder="Line 3" value="<?php echo $result_cus['address3']; ?>" >
                </div>
              </div>

              <div class="row">
                <div class="text-center" style="padding: 15px;"><button type="submit">Update</button></div>
                <input type="hidden" name="cus_id" class="form-control" id="cus_id" value="<?php echo $_SESSION["customerId"]; ?>" >
                <input type="hidden" name="ctype" class="form-control" id="ctype" value="<?php echo $result_cus['ctype']; ?>" >
              </div>

            </form>
            </div>

            <div id="order_div" class="info" style="display:none; width:100%;">
            <h5><b>My Orders</b></h5>
            <?php
            $select_req = mysqli_query($con, "SELECT id, req_no, r_datetime, status FROM quotation_requests WHERE cus_id = '{$_SESSION["customerId"]}' ORDER BY r_datetime DESC");

            if(mysqli_num_rows($select_req) > 0){
            ?>
            <div class="row">
                <table>
                    <thead>
                    <tr>
                        <th style="border-right: 1px solid white;">Req. No.</th>
                        <th style="border-right: 1px solid white;">Description</th>
                        <th style="border-right: 1px solid white;">Date & Time</th>
                        <th style="border-right: 1px solid white;">Status</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while($result_req = mysqli_fetch_array($select_req)){

                    $req_products = '';
                    $select_pro = mysqli_query($con, "SELECT p.name, r.qty FROM products p, requests r WHERE p.id = r.prod_id AND r.req_id = '{$result_req['id']}'");
                    while($result_pro = mysqli_fetch_array($select_pro)){
                        $req_products .= $result_pro[0].' | Qty: '.$result_pro[1].'<br/>';
                    }
                    $req_products = substr($req_products,0,-5);

                    if($result_req['status'] == 'open'){
                        $rstatus = 'Pending';
                    } else if ($result_req['status'] == 'quotation'){
                        $rstatus = 'Quotation';
                    }
                    ?>
                    <tr>
                        <td><?php echo $result_req['req_no']; ?></td>
                        <td><?php echo $req_products; ?></td>
                        <td><?php echo $result_req['r_datetime']; ?></td>
                        <td><?php echo $rstatus; ?></td>
                        <td align="center"><button type="submit" onclick="openOrderModal(<?php echo $result_req['id']; ?>)" ><b>View</b></button></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>

            <?php
            } else {
            ?>
            <div class="row">
                <div class="form-group col-md-12">
                  <label>No records available.</label>
                </div>
            </div>
            <?php
            }
            ?>
            </div>

            
            <div id="pword_div" style="display:none; width:100%;">
            <form name="password_form" action="change_password.php" method="post" role="form" class="php-email-form" onsubmit="return validatePWForm()" >
            <h5><b>Change Password</b></h5>
            
              <div class="my-3">
                <?php if(isset($_SESSION['p_success']) && $_SESSION['p_success'] != ''){ ?>
                <div class="sent-message"><?php echo $_SESSION['p_success']; ?></div>
                <?php 
                }
                $_SESSION['p_success'] = '';

                if(isset($_SESSION['p_error']) && $_SESSION['p_error'] != ''){ ?>
                <div class="error-message"><?php echo $_SESSION['p_error']; ?></div>
                <?php 
                }
                $_SESSION['p_error'] = '';
                ?>
              </div>
              
              <div class="row">
                <div class="form-group col-md-4">
                  <label for="opass">Current Password <span style="color:red">*</span></label>
                  <input type="password" name="opass" class="form-control" id="opass" placeholder="Current Password" >
                  <span class="error_msg" id="opass_error" ></span>
                </div>
                <div class="form-group col-md-4">
                  <label for="npass">New Password <span style="color:red">*</span></label>
                  <input type="password" name="npass" class="form-control" id="npass" placeholder="New Password" >
                  <span class="error_msg" id="npass_error" ></span>
                </div>
                <div class="form-group col-md-4 mt-3 mt-md-0">
                  <label for="cpass">Confirm Password <span style="color:red">*</span></label>
                  <input type="password" class="form-control" name="cpass" id="cpass" placeholder="Confirm Password" >
                  <span class="error_msg" id="cpass_error" ></span>
                </div>
              </div>
              
              <div class="row">
                <div class="text-center" style="padding: 15px;"><button type="submit">Change Password</button></div>
                <input type="hidden" name="cus_id" class="form-control" id="cus_id" value="<?php echo $_SESSION["customerId"]; ?>" >
              </div>

            </form>
            </div>

          </div>

        </div>

      </div>
    </section>
 
    
  <!-- ======= Footer ======= -->
  <?php include('web_footer.php'); ?>

<script>

function change_div(a){

    if(a == 'ord'){
        document.getElementById("detail_div").style.display = 'none';
        document.getElementById("pword_div").style.display = 'none';
        document.getElementById("order_div").style.display = 'block';
    } else if(a == 'det'){
        document.getElementById("detail_div").style.display = 'block';
        document.getElementById("order_div").style.display = 'none';
        document.getElementById("pword_div").style.display = 'none';
    } else {
        document.getElementById("detail_div").style.display = 'none';
        document.getElementById("order_div").style.display = 'none';
        document.getElementById("pword_div").style.display = 'block';
    }

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
  
  let mobile = document.forms["contact_form"]["mobile"].value;
  var regMobile=/^\d{10}$/;
  if (mobile == "") {
	document.getElementById("mobile_error").innerHTML = "Mobile must be filled out";
	document.getElementById("mobile").className  = "form-control error";
	prevent = 'yes';
  } else if (!regMobile.test(mobile)) {
    document.getElementById("mobile_error").innerHTML = "Mobile must have 10 digits";
	document.getElementById("mobile").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("mobile_error").innerHTML = "";
	document.getElementById("mobile").className  = "form-control";
  }

  let phone = document.forms["contact_form"]["phone"].value;
  var regPhone=/^\d{10}$/;
  if (phone != "" && !regPhone.test(phone)) {
    document.getElementById("phone_error").innerHTML = "Telephone must have 10 digits";
	document.getElementById("phone").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("phone_error").innerHTML = "";
	document.getElementById("phone").className  = "form-control";
  }

  } else {

  let phone = document.forms["contact_form"]["phone"].value;
  var regPhone=/^\d{10}$/;
  if (phone == "") {
	document.getElementById("phone_error").innerHTML = "Telephone must be filled out";
	document.getElementById("phone").className  = "form-control error";
	prevent = 'yes';
  } else if (!regPhone.test(phone)) {
    document.getElementById("phone_error").innerHTML = "Telephone must have 10 digits";
	document.getElementById("phone").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("phone_error").innerHTML = "";
	document.getElementById("phone").className  = "form-control";
  }

  }
  
  let fname = document.forms["contact_form"]["fname"].value;
  if (fname == "") {
	document.getElementById("fname_error").innerHTML = "Name must be filled out";
	document.getElementById("fname").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("fname_error").innerHTML = "";
	document.getElementById("fname").className  = "form-control";
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
  
  let address1 = document.forms["contact_form"]["address1"].value;
  if (address1 == "") {
	document.getElementById("addr_error").innerHTML = "Address must be filled out";
	document.getElementById("address1").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("addr_error").innerHTML = "";
	document.getElementById("address1").className  = "form-control";
  }

  if(prevent == 'yes'){
	  return false;
  }

}

function validatePWForm(){
  var prevent = '';

  let opass = document.forms["password_form"]["opass"].value;
  if (opass == "") {
	document.getElementById("opass_error").innerHTML = "Fill current password";
	document.getElementById("opass").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("opass_error").innerHTML = "";
	document.getElementById("opass").className  = "form-control";
  }

  let npass = document.forms["password_form"]["npass"].value;
  if (npass == "") {
	document.getElementById("npass_error").innerHTML = "Fill new password";
	document.getElementById("npass").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("npass_error").innerHTML = "";
	document.getElementById("npass").className  = "form-control";
  }

  let cpass = document.forms["password_form"]["cpass"].value;
  if (cpass == "") {
	document.getElementById("cpass_error").innerHTML = "Confirm password";
	document.getElementById("cpass").className  = "form-control error";
	prevent = 'yes';
  } else if (cpass != npass) {
	document.getElementById("cpass_error").innerHTML = "Doesn't match with new password";
	document.getElementById("cpass").className  = "form-control error";
	prevent = 'yes';
  } else {
	document.getElementById("cpass_error").innerHTML = "";
	document.getElementById("cpass").className  = "form-control";
  }
  
  if(prevent == 'yes'){
	  return false;
  }

}

</script>

</body>
<?php } ?>
</html>
