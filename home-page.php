<?php
session_start();  // Start the sessions
require 'config/database.php';

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>News 360</title>
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
        <!-- ======= Header ======= -->
    <?php
        include 'partials/header.php';
    ?>
    <!-- End Header -->    

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex justify-content-center align-items-center">
      <div
        id="heroCarousel"
        data-bs-interval="5000"
        class="container carousel carousel-fade"
        data-bs-ride="carousel"
      >
        <!-- Slide 1 -->
        <div class="carousel-item active">
          <div class="carousel-container">
            <h2 class="animate__animated animate__fadeInDown">
              Welcome to <span>News 360</span>
            </h2>
            <p class="animate__animated animate__fadeInUp">
             Stay updated with the latest headlines, in-depth analysis, and diverse perspectives from around the world.
              We're here to keep you informed and engaged with the news that matters.We're thrilled to have you here. 
              Dive into the latest headlines, expert analysis, and in-depth features on global events. 
              Our dedicated team is committed to bringing you accurate, timely news and diverse perspectives.
              Explore our comprehensive coverage and stay informed with the stories that shape our world."
            </p>
            <a
              href="signin-page.php"
              class="btn-get-started animate__animated animate__fadeInUp scrollto"
              >Become a Publisher</a
            >
          </div>
        </div>
        <!-- Slide 2 -->
        <div class="carousel-item">
          <div class="carousel-container">
            <h2 style="margin-top: 50px;" class="animate__animated animate__fadeInDown">
              Our Terms & Conditions
            </h2>
            <p class="animate__animated animate__fadeInUp">
              1. Acceptance of Terms By accessing and using News360 ("the Site"), you agree to comply with and be bound by these Terms & Conditions. If you do not agree with these terms, please do not use the Site. <br>
              2. Changes to Terms We reserve the right to modify these Terms & Conditions at any time. Any changes will be effective immediately upon posting. Your continued use of the Site constitutes your acceptance of the revised terms. <br>
              3. Use of Content All content on News360, including articles, images, and videos, is protected by copyright and intellectual property laws. You may not reproduce, distribute, or modify any content without prior written permission from News360. <br>
              4. User Conduct You agree to use the Site for lawful purposes only.  <br>

              <big style="color: red;">You must not:</big> <br>

              5. Post or transmit any unlawful, defamatory, or harmful content. <br>
              6. Engage in any activity that may damage or disrupt the Site.<br>
              7. Privacy Your use of the Site is also governed by our Privacy Policy, which outlines how we collect, use, and protect your personal information.<br>
              8. Disclaimers News360 provides the Site and content "as is" without warranties of any kind. We do not guarantee the accuracy, completeness, or timeliness of the information provided. Your use of the Site is at your own risk. <br>
              9. Limitation of Liability To the fullest extent permitted by law, News360 shall not be liable for any indirect, incidental, or consequential damages arising from your use of the Site or inability to access it. <br>
              10. Contact Us If you have any questions or concerns about these Terms & Conditions, please contact us at [Your Contact Information]. <br>
            </p>
            <a
              href="signup-page.php"
              class="btn-get-started animate__animated animate__fadeInUp scrollto"
              >Read & Accept</a
            >
          </div>
        </div>
        <!-- Slide 3 -->
        <div class="carousel-item">
          <div class="carousel-container">
            <h2 class="animate__animated animate__fadeInDown">
              For any Info
            </h2>
            <p class="animate__animated animate__fadeInUp">
              "Need more information or have any questions? Feel free to reach out to us at [Your Contact Information]. We're here to help and provide any assistance you may need!"
            </p>
            <a
              href="contact-page.php"
              class="btn-get-started animate__animated animate__fadeInUp scrollto"
              >Contact us</a
            >
          </div>
        </div>
        <a
          class="carousel-control-prev"
          href="#heroCarousel"
          role="button"
          data-bs-slide="prev"
        >
          <span
            class="carousel-control-prev-icon bx bx-chevron-left"
            aria-hidden="true"
          ></span>
        </a>
        <a
          class="carousel-control-next"
          href="#heroCarousel"
          role="button"
          data-bs-slide="next"
        >
          <span
            class="carousel-control-next-icon bx bx-chevron-right"
            aria-hidden="true"
          ></span>
        </a>
      </div>
    </section>
    <!-- End Hero -->
  </body>
  <!-- Vendor Js Files -->
  <script src="assets/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendors/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendors/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendors/swiper/swiper-bundle.min.js"></script>

  <!-- Main Js Files -->
  <script src="assets/js/main.js"></script>
</html>
