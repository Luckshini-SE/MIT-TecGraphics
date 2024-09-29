<!DOCTYPE html>
<html lang="en">

<head>
  <?php include('web_header.php'); ?>
</head>

<body>

  <!-- ======= Header ======= -->

  <!-- End Header -->
    <?php include('web_navbar.php'); ?>
    <?php include('db_connection.php'); ?>
  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">

    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
          <h1>Transform ideas into vibrant creations</h1>
          <h2>We are passionately dedicated to bringing your vision to life with precision and creativity. Our unwavering commitment to quality ensures every print makes a lasting impression.</h2>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img">
          <img src="assets/img/machine.jpg" class="img-fluid animated" alt="" width="150%" >
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">

        <div class="row justify-content-between">
          <div class="col-lg-5 d-flex align-items-center justify-content-center about-img">
            <img src="assets/img/Prepress.jpg" class="img-fluid" alt="" data-aos="zoom-in">
          </div>
          <div class="col-lg-6 pt-5 pt-lg-0">
            <h3 data-aos="fade-up">About Tec Graphics...</h3>
            <p data-aos="fade-up" data-aos-delay="100">
              Founded in 2003, Tec Graphics has emerged as a pioneering force in Sri Lanka's digital printing landscape. Our expertise lies in producing a diverse array of marketing materials. Equipped with cutting-edge digital technology, our team's dedication and creativity ensure your every printing need is met with excellence.
            </p>
            <div class="row">
              <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                <i class="bx bx-show"></i>
                <h4>Our Vision</h4>
                <p>Thriving in the advertising and printing industry, prioritizing trusted service, lasting impressions, and personalized care for every order.</p>
              </div>
              <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                <i class="bx bx-target-lock"></i>
                <h4>Our Mission</h4>
                <p>To invest in top-notch equipment to deliver swift, high-quality service to clients seeking our prestigious expertise.</p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End About Section -->

    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Services</h2>
          <p>Check out the wide range of services we offer</p>
        </div>

        <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">

        <?php
        $select_product = mysqli_query($con, "SELECT * FROM products");
        while($result_product = mysqli_fetch_array($select_product)){
        ?>
          <div class="col-lg-3 col-md-6 portfolio-item filter-app">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/<?php echo $result_product['image1']; ?>" class="img-fluid" alt="">
              <div class="portfolio-links">
                <a href="assets/img/portfolio/<?php echo $result_product['image1']; ?>" data-gallery="portfolioGallery" class="portfolio-lightbox" title="<?php echo $result_product['name']; ?>"><i class="bi bi-eye"></i></a>
                <a href="product-details.php?pid=<?php echo $result_product['id']; ?>" title="Request a quote"><i class="bi bi-plus"></i></a>
              </div>
              <div class="portfolio-info">
                <h4><?php echo $result_product['name']; ?></h4>
              </div>
            </div>
          </div>
        <?php } ?>

        </div>

      </div>
    </section><!-- End Portfolio Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Why Us?</h2>
          <p>Discover the compelling reasons to choose our services</p>
        </div>

        <div class="row">
          <div class="col-md-6 col-lg-3 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-box">
              <div class="icon"><i class="bx bx-check-shield"></i></div>
              <h4 class="title"><a href="">Quality Assurance</a></h4>
              <p class="description">We ensure impeccable print quality, leaving no detail untouched in all your projects.</p>
            </div>
          </div>

          <div class="col-md-6 col-lg-3 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="200">
            <div class="icon-box">
              <div class="icon"><i class="bx bx-tachometer"></i></div>
              <h4 class="title"><a href="">Fast Turnaround</a></h4>
              <p class="description">Our efficient processes and dedicated team ensure timely delivery, meeting your deadlines.</p>
            </div>
          </div>

          <div class="col-md-6 col-lg-3 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="300">
            <div class="icon-box">
              <div class="icon"><i class="bx bx-extension"></i></div>
              <h4 class="title"><a href="">Custom Solutions</a></h4>
              <p class="description">We tailor our services to your unique needs, providing customized printing solutions.</p>
            </div>
          </div>

          <div class="col-md-6 col-lg-3 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="400">
            <div class="icon-box">
              <div class="icon"><i class="bx bx-smile"></i></div>
              <h4 class="title"><a href="">Exceptional Service</a></h4>
              <p class="description">Count on our friendly, professional, and responsive support for your complete satisfaction.</p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Services Section -->

    <!-- ======= Contact Us Section ======= -->
    <section id="contact" class="contact section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Contact Us</h2>
          <p>Contact us to get started</p>
        </div>

        <div class="row">

          <div class="col-lg-5 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
            <div class="info">
              <div class="address">
                <i class="bi bi-geo-alt"></i>
                <h4>Location:</h4>
                <p>100, Main Street, Colombo 02.</p>
              </div>

              <div class="email">
                <i class="bi bi-envelope"></i>
                <h4>Email:</h4>
                <p>info@tecgraphics.lk</p>
              </div>

              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Call:</h4>
                <p>+94 112 333 444 </p>
              </div>

            </div>

          </div>

          <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
            <div class="info">
                <p data-aos="fade-up" data-aos-delay="100">
                  Our highly skilled team is fully prepared to deliver accurate quotations tailored to your specific needs. Moreover, our team of designers is at the ready, eager to offer personalized design support crafted to bring your unique vision to life. Whether you require cost clarity or creative direction, we're here to ensure your project's success.
                </p>
                <br/>
                <p data-aos="fade-up" data-aos-delay="100">
                  Click below to get started...
                </p>
              <!--<div class="text-center"><a href="get_quotation.php"><button type="button" class="btn btn-warning" style="background-color:#eb5d1e;border-color:#eb5d1e;color:#fff">Request a Quote</button></a></div>-->
              <div class="text-center"><a href="index.php#portfolio"><button type="button" class="btn btn-warning" style="background-color:#eb5d1e;border-color:#eb5d1e;color:#fff">Request a Quote</button></a></div>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Contact Us Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php include('web_footer.php'); ?>

</body>

</html>