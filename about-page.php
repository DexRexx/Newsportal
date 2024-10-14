<?php
session_start();  // Start the sessions
require 'config/database.php';

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>News 360 | About Us</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- favicons -->
    <link href="assets/images/favicons/favicon.png" rel="icon" />
    <link
      href="assets/images/favicons/apple-touch-icon.png"
      rel="apple-touch-icon"
    />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Teko:wght@300..700&display=swap"
      rel="stylesheet"
    />

    <!-- Vendor Files -->
    <link
      href="assets/vendors/bootstrap/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="assets/vendors/bootstrap-icons/bootstrap-icons.css"
      rel="stylesheet"
    />
    <link href="assets/vendors/swiper/swiper-bundle.min.css" rel="stylesheet" />
    <link
      href="assets/vendors/glightbox/css/glightbox.min.css"
      rel="stylesheet"
    />
    <link href="assets/vendors/aos/aos.css" rel="stylesheet" />
    <link href="assets/vendors/remixicon/remixicon.css" rel="stylesheet" />

    <!-- Css Main File -->
    <link rel="stylesheet" href="assets/css/main.css" />
  </head>

  <body>
    
            <!-- ======= header  ======= -->
            <?php
                  include 'partials/header.php';
            ?>
          <!-- End Header -->

    <main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li><a href="services-page.html">Services</a></li>
          </ol>
          <h2>About Us</h2>
        </div>
      </section>
      <!-- End Breadcrumbs -->

      <!-- ======= About Us Section ======= -->
      <section id="about" class="about">
        <div class="container" data-aos="fade-up">
          <div class="section-title">
            <h2>About Us</h2>
            <p>
            At News360, we deliver timely, accurate, and engaging news from around the globe. 
            Our mission is to keep you informed with insightful analysis, breaking stories, and diverse perspectives.
            </p>
          </div>

          <div class="row content">
            <div class="col-lg-6">
              <p>
              Here are three things your news website can offer:
              </p>
              <ul>
                <li>
                  <i class="ri-check-double-line"></i> <u>Breaking News & Timely Updates</u> <br>
                  Stay informed with real-time updates and breaking news from around the world. 
                  We provide fast and accurate coverage of major events as they happen.
                </li>
                <li>
                  <i class="ri-check-double-line"></i> <u>In-Depth Analysis & Features</u> <br>
                  Go beyond the headlines with in-depth articles and expert opinions. 
                  Our team of experienced journalists provides 
                  detailed insights on global events, politics, culture, and more.
                </li>
                <li>
                  <i class="ri-check-double-line"></i> <u>Diverse Perspectives</u> <br>
                  We bring you a wide range of viewpoints from different voices and regions, 
                  ensuring you get a comprehensive understanding of the issues that matter most.
                </li>
              </ul>
            </div>
            <div class="col-lg-6 pt-4 pt-lg-0">
              <p>
              News360 was founded with the vision of delivering reliable, timely, 
              and diverse news to a global audience. Established in 2020, 
              our goal has always been to provide in-depth reporting, insightful analysis, 
              and a platform for multiple perspectives on the stories shaping the world.
              </p>
              <a href="home-page.php" class="btn-learn-more">Terms & Conditions</a>
            </div>
          </div>
        </div>
      </section>
      <!-- End About Us Section -->
    </main>
            <!-- ======= Footer ======= -->
            <?php
                  include 'partials/footer.php';
            ?>
            <!-- ======= /footer ======= -->