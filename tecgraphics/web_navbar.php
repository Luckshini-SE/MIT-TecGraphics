  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <div class="logo">
        <!-- <h1 class="text-light"><a href="index.php"><span>TecGraphics</span></a></h1>-->
        <!-- Uncomment below if you prefer to use an image logo -->
        <a href="index.php"><img src="assets/img/logo.png" alt="TecGraphics" class="img-fluid"></a>
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="index.php#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="index.php#about">About Us</a></li>
          <li><a class="nav-link scrollto" href="index.php#portfolio">Services</a></li>
          <li><a class="nav-link scrollto" href="index.php#services">Why Us?</a></li>
          <li><a class="nav-link scrollto" href="index.php#contact">Contact</a></li>
          <?php if(isset($_SESSION["customerId"])){ ?>
          <li><a class="nav-link scrollto" href="profile.php">Profile</a></li>
          <?php } else { ?>
          <li><a class="nav-link scrollto" href="signin.php">Sign In</a></li>
          <?php } ?>
          <li><a class="getstarted scrollto" href="get_quotation.php">Request a Quote</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header>