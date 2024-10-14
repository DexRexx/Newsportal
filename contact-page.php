<?php
session_start();  // Start the sessions
require 'config/database.php';

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>News 360|  Contact Us</title>
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
          <h2>Contact Us</h2>
        </div>
      </section>
      <!-- End Breadcrumbs -->

      <!-- ======= Contact Section ======= -->
      <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">
          <div class="section-title">
            <h2>Get In Touch With Us</h2>
          </div>

          <div
            class="row mt-1 d-flex justify-content-end"
            data-aos="fade-right"
            data-aos-delay="100"
          >
            <div class="col-lg-5">
              <div class="info">
                <div class="address">
                  <i class="bi bi-geo-alt"></i>
                  <h4>Location:</h4>
                  <p>Sahara, Dansoman, Accra.</p>
                </div>
                <div class="email">
                  <i class="bi bi-envelope"></i>
                  <h4>Email:</h4>
                  <p>info@example.com</p>
                </div>
                <div class="phone">
                  <i class="bi bi-phone"></i>
                  <h4>Call:</h4>
                  <p>0500504206</p>
                </div>
              </div>
            </div>
            <div
              class="col-lg-6 mt-5 mt-lg-0"
              data-aos="fade-left"
              data-aos-delay="100"
            >
              <form
                action="forms/contact.php"
                method="post"
                role="form"
                class="php-email-form"
              >
                <div class="row">
                  <div class="col-md-6 form-group">
                    <input
                      type="text"
                      name="name"
                      class="form-control"
                      id="name"
                      placeholder="Your Name"
                      required
                    />
                  </div>
                  <div class="col-md-6 form-group mt-3 mt-md-0">
                    <input
                      type="email"
                      class="form-control"
                      name="email"
                      id="email"
                      placeholder="Your Email"
                      required
                    />
                  </div>
                </div>
                <div class="form-group mt-3">
                  <input
                    type="text"
                    class="form-control"
                    name="subject"
                    id="subject"
                    placeholder="Subject"
                    required
                  />
                </div>
                <div class="form-group mt-3">
                  <textarea
                    class="form-control"
                    name="message"
                    rows="5"
                    placeholder="Message"
                    required
                  ></textarea>
                </div>
                <?php
if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success">'.$_SESSION['success_message'].'</div>';
    unset($_SESSION['success_message']);
}
if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger">'.$_SESSION['error_message'].'</div>';
    unset($_SESSION['error_message']);
}
?>
                <div class="text-center">
                  <button name="submit" type="submit">Send Message</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
      <!-- End Contact Section -->
    </main>

     <!-- ======= footer  ======= -->
            <?php
                  include 'partials/footer.php';
            ?>
          <!-- footer -->