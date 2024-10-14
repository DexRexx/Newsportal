<?php
session_start();  // Start the sessions
require 'config/database.php';

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>News 360 | Services</title>
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
            <li><a href="news-page.html">News</a></li>
          </ol>
          <h2>Services</h2>
        </div>
      </section>
      <!-- End Breadcrumbs -->

      <!-- ======= Services Section ======= -->
      <section id="services" class="services">
        <div class="container" data-aos="fade-up">
          <div class="section-title">
            <h2>How Can We Help You?</h2>
            <p>
            At News360, we’re committed to keeping you informed and engaged. 
            Whether you’re looking for breaking news, in-depth analysis, or diverse opinions, 
            we’ve got you covered. Have a question or need assistance? Reach out to our team, 
            and we’ll be happy to help you find the information you need.
          </div>

          <div class="row">
            <div
              class="col-md-6 d-flex align-items-stretch"
              data-aos="fade-up"
              data-aos-delay="100"
            >
              <div class="icon-box">
                <i class="bi bi-card-checklist"></i>
                <h4><a href="index.php">Breaking News Alerts</a></h4>
                <p>
                This service keeps users informed with real-time updates on major events happening globally. 
                Subscribers can receive instant notifications through email or mobile alerts, 
                ensuring they’re always up-to-date on critical breaking news, whether it’s political events, 
                natural disasters, or major announcements.
                </p>
              </div>
            </div>
            <div
              class="col-md-6 d-flex align-items-stretch mt-4 mt-md-0"
              data-aos="fade-up"
              data-aos-delay="200"
            >
              <div class="icon-box">
                <i class="bi bi-bar-chart"></i>
                <h4><a href="#">Daily Newsletters</a></h4>
                <p>
                Subscribers can sign up to receive a curated newsletter delivered to their inbox every day. 
                This service provides a roundup of the most important news stories, handpicked by editors,
                saving users time while keeping them informed. It’s a convenient way to stay updated with the latest 
                developments without constantly checking the website.
                </p>
              </div>
            </div>
            <div
              class="col-md-6 d-flex align-items-stretch mt-4 mt-md-0"
              data-aos="fade-up"
              data-aos-delay="300"
            >
              <div class="icon-box">
                <i class="bi bi-binoculars"></i>
                <h4><a href="news-page.php">In-Depth Investigative Reports</a></h4>
                <p>
                Your website can offer comprehensive investigative journalism on key issues, 
                uncovering the truth behind complex stories that require deeper examination. 
                These reports delve into topics like politics, business, or social justice, providing readers 
                with well-researched, detailed information they can’t find in everyday news.
                </p>
              </div>
            </div>
            <div
              class="col-md-6 d-flex align-items-stretch mt-4 mt-md-0"
              data-aos="fade-up"
              data-aos-delay="400"
            >
              <div class="icon-box">
                <i class="bi bi-brightness-high"></i>
                <h4><a href="index.php">Opinion & Editorial Pieces</a></h4>
                <p>
                This service presents thoughtful commentaries and opinion pieces written by experts, 
                journalists, and guest contributors. Readers can explore diverse viewpoints on current events 
                and societal issues, engaging with critical thinking and debate on topics ranging from politics 
                and economics to culture and technology.
                </p>
              </div>
            </div>
            <div
              class="col-md-6 d-flex align-items-stretch mt-4 mt-md-0"
              data-aos="fade-up"
              data-aos-delay="500"
            >
              <div class="icon-box">
                <i class="bi bi-calendar4-week"></i>
                <h4><a href="index.php">Customizable News Feed</a></h4>
                <p>
                To enhance user experience, the customizable news feed allows visitors to select the topics, 
                categories, or regions they’re most interested in. This service delivers a personalized stream 
                of news content tailored to their preferences, ensuring that users only see the most relevant 
                stories to them, from entertainment and business to world news.
              </div>
            </div>
            <div
              class="col-md-6 d-flex align-items-stretch mt-4 mt-md-0"
              data-aos="fade-up"
              data-aos-delay="600"
            >
              <div class="icon-box">
                <i class="bi bi-briefcase"></i>
                <h4><a href="news-page.php">Live Coverage & Event Streaming</a></h4>
                <p>
                For significant global events such as political debates, 
                international summits, or sporting events, this service allows users to follow 
                live streams directly on the website. It provides real-time coverage and commentary, 
                enabling users to stay connected to important happenings as they unfold.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- End Services Section -->
    </main>

     <!-- ======= footer  ======= -->
            <?php
                  include 'partials/footer.php';
            ?>
          <!--  /footer -->