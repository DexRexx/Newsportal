<?php
session_start();  // Start the sessions
require 'config/database.php';

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>| Sign In</title>
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
  <body id="sign-page">
    <?php if (isset($_SESSION['signin'])) : ?>
        <div class="message error">
            <p>
                <?= htmlspecialchars($_SESSION['signin'], ENT_QUOTES, 'UTF-8'); ?>
                <?php unset($_SESSION['signin']); ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['signup-success'])) : ?>
        <div class="message success">
            <p>
                <?= htmlspecialchars($_SESSION['signup-success'], ENT_QUOTES, 'UTF-8'); ?>
                <?php unset($_SESSION['signup-success']); ?>
            </p>
        </div>
    <?php endif; ?>

    <div class="wrapper">
        <div class="title">Sign In</div>
        <form action="forms/signin-form.php" method="post" enctype="multipart/form-data">
            <div class="field">
                <input type="text" name="username_email"  required />
                <label>Username / Email</label>
            </div>
            <div class="field">
                <input type="password" name="password"  required />
                <label>Password</label>
            </div>
            <div class="field">
                <input type="submit" name="submit"  />
            </div>
            <div class="signup-link">
                Not a member? <a href="signup-page.php">Register</a>
            </div>
            <a href="index.php"><i class="ri-home-7-fill"></i> Home Page</a>
        </form>
    </div>
</body>
  <!-- Vendor Js Files -->
  <script src="assets/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendors/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendors/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendors/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendors/aos/aos.js"></script>

  <!-- Main Js Files -->
  <script src="assets/js/main.js"></script>
</html>
