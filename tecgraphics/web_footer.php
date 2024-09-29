  <footer id="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            <h3>Tec Graphics</h3>
            <p>
              100, Main Street, <br>
              Colombo 02<br>
              Sri Lanka. <br><br>
              <strong>Phone:</strong> +94 112 333 444<br>
              <strong>Email:</strong> info@tecgraphics.lk<br>
            </p>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="index.php#hero">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="index.php#about">About us</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="index.php#portfolio">Services</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="terms.php" target="_blank">Terms of service</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="privacy.php" target="_blank">Privacy policy</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="index.php#portfolio">Banners</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="index.php#portfolio">Leaflets</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="index.php#portfolio">Stickers</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="index.php#portfolio">Mugs</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="index.php#portfolio">Stamps</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Social Networks</h4>
            <div class="social-links mt-3">
              <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
              <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
              <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
              <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
              <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="container py-4">
      <div class="copyright">
        <strong><span>TecGraphics</span></strong> &copy; 2023. All Rights Reserved.
      </div>
      <div class="credits">
       
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  
  <!-- Modal -->
    <div id="signInModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <!-- Modal content goes here -->

            <h4>Sign in to continue...</h4>

            <!-- Tabs -->
            <div class="modal-tabs">
                <div class="modal-tab active" onclick="openTab('tab1')">Sing In</div>
                <div class="modal-tab" onclick="openTab('tab2')">Sing Up</div>
            </div>

            <!-- Tab content -->
            <div id="tab1" class="modal-tab-content">
                <form id="formTab1" onsubmit="submitForm('formTab1'); return false;">
                    <div id="message1"></div>
                    <!-- Form fields for Tab 1 -->
                    <label for="nameTab1">Email</label>
                    <input type="email" class="form-control" id="iemail" name="iemail" required>

                    <label for="emailTab1">Password</label>
                    <input type="password" class="form-control" id="ipassword" name="ipassword" required>

                    <div align="center"><button type="submit">Sign In</button></div>
                </form>
            </div>

            <div id="tab2" class="modal-tab-content" style="display:none">
                <form id="formTab2" onsubmit="submitForm('formTab2'); return false;">
                    <div id="message2"></div>
                    <!-- Form fields for Tab 2 -->
                    <div class="row">
                    <div class="col-6"><input type="radio" style="accent-color: #eb5d1e; height:12px !important;" name="ctype" id="r1" value="ind" checked /> &nbsp; Individual</div>
					<div class="col-6"><input type="radio" style="accent-color: #eb5d1e; height:12px !important;" name="ctype" id="r2" value="com" /> &nbsp; Company</div>
                    </div>

                    <label for="nameTab2">Email</label>
                    <input type="email" class="form-control" id="uemail" name="uemail" required>

                    <label for="emailTab2">Password</label>
                    <input type="password" class="form-control" id="upassword" name="upassword" required>

                    <div align="center"><button type="submit">Sign Up</button></div>
                </form>
            </div>
        </div>
    </div>
  <!-- Modal End -->
  
  <!-- Modal -->
    <div id="orderDetailModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeOrderModal()">&times;</span>
            <!-- Modal content goes here -->

            <h5>Request Details...</h5>

            <!-- Tab content -->
            <div class="modal-tab-content">
                <div id="order_details"></div>
            </div>

        </div>
    </div>
  <!-- Modal End -->

  <script>
    // Get the modal element
    var modal = document.getElementById('signInModal');

    // Get the close button element
    var closeBtn = document.getElementsByClassName('close')[0];

    // Function to open the modal
    function openModal() {
        modal.style.display = 'block';
        $("#message").html('');
    }

    function openOrderModal(ord) {
        const xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("order_details").innerHTML = this.responseText;
                document.getElementById('orderDetailModal').style.display = 'block';
			}
		};
		xhttp.open("GET", "get_order_form.php?ord="+ord);
		xhttp.send();

    }

    // Function to close the modal
    function closeModal() {
        modal.style.display = 'none';
    }

    function closeOrderModal() {
        document.getElementById('orderDetailModal').style.display = 'none';
    }

    // Event listener for the close button
    closeBtn.addEventListener('click', closeModal);

    // Function to open a specific tab
    function openTab(tabName) {
        var i, tabContent, tabs;

        // Hide all tabs
        tabContent = document.getElementsByClassName('modal-tab-content');
        for (i = 0; i < tabContent.length; i++) {
            tabContent[i].style.display = 'none';
        }

        // Deactivate all tabs
        tabs = document.getElementsByClassName('modal-tab');
        for (i = 0; i < tabs.length; i++) {
            tabs[i].classList.remove('active');
        }

        // Show the selected tab
        document.getElementById(tabName).style.display = 'block';

        // Activate the clicked tab
        event.currentTarget.classList.add('active');

    }

    // Function to handle form submission
    function submitForm(formId) {
 
    if(formId == 'formTab1'){
        var formData = {
          email: $("#iemail").val(),
          passw: $("#ipassword").val(),
          stype: formId,
        };
    } else {
         if(document.getElementById('r1').checked == true){
             var ctype = "ind";
         } else {
             var ctype = "com";
         }

         var formData = {
          email: $("#uemail").val(),
          passw: $("#upassword").val(),
          ctype: ctype,
          stype: formId,
        };
    }

    $.ajax({
      type: "POST",
      url: "modal_submit.php",
      data: formData,
      dataType: "json",
      encode: true,
    }).done(function (data) {
      
      if (!data.success) {              //errors present
        if(formId == 'formTab1'){       //sign in
            $("#message1").html(
              '<div class="alert alert-danger">' + data.errors + "</div>"
            );
        } else {                        //sign up
            $("#message2").html(
              '<div class="alert alert-danger">' + data.errors + "</div>"
            );
        }
      } else {                          //success
        if(formId == 'formTab1'){       //sign in
            $("#message1").html(
              '<div class="alert alert-success">' + data.message + "</div>"
            );
        } else {                        //sign up
            $("#message2").html(
              '<div class="alert alert-success">' + data.message + "</div>"
            );
        }
        closeModal();
        addtoquote();
      }
    })
    .fail(function (data) {
        $("#message").html(
          '<div class="alert alert-danger">Could not reach server, please try again later.</div>'
        );
    });
  
    }

  </script>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <!-- <script src="assets/vendor/php-email-form/validate.js"></script> -->

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/jquery.min.js"></script>
  