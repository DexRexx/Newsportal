<?php
session_start();  // Start the sessions
require 'config/database.php';

// Get back form data if Registration error occurs
$firstname = $_SESSION['signup-data']['firstname'] ?? null;
$lastname = $_SESSION['signup-data']['lastname'] ?? null;
$username = $_SESSION['signup-data']['username'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
$createpassword = $_SESSION['signup-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['signup-data']['confirmpassword'] ?? null;
$error_message = $_SESSION['signup-error'] ?? null; // Error message if any

// delete the signup data session
unset($_SESSION['signup-data']);
unset($_SESSION['signup-error']); // Clear error message session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>News 360 | Create an Account</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- favicons -->
    <link href="assets/images/favicons/favicon.png" rel="icon" />
    <link href="assets/images/favicons/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Teko:wght@300..700&display=swap" rel="stylesheet" />

    <!-- Vendor Files -->
    <link href="assets/vendors/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/vendors/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="assets/vendors/swiper/swiper-bundle.min.css" rel="stylesheet" />
    <link href="assets/vendors/glightbox/css/glightbox.min.css" rel="stylesheet" />
    <link href="assets/vendors/aos/aos.css" rel="stylesheet" />
    <link href="assets/vendors/remixicon/remixicon.css" rel="stylesheet" />

    <!-- Css Main File -->
    <link rel="stylesheet" href="assets/css/main.css" />
</head>

<body id="sign-page">
    
 <!-- Display Error Message if Exists -->
        <?php if ($error_message): ?>
            <div class="alert alert-danger">
                <?= $error_message ?>
            </div>
        <?php endif; ?>

<div class="wrapper">

        <div class="title">Sign Up</div>
        <form action="forms/signup-form.php" enctype="multipart/form-data" method="post">
            <div class="field">
                <input type="text" name="firstname" value="<?= $firstname ?>" required />
                <label>First Name</label>
            </div>
            <div class="field">
                <input type="text" name="lastname" value="<?= $lastname ?>" required />
                <label>Last Name</label>
            </div>
            <div class="field">
                <input type="text" name="username" value="<?= $username ?>" required />
                <label>Username</label>
            </div>
            <div class="field">
                <input type="email" name="email" value="<?= $email ?>" required />
                <label>Email</label>
            </div>
            <div class="field">
                <input type="password" name="createpassword" value="<?= $createpassword ?>" required />
                <label>Password</label>
            </div>
            <div class="field">
                <input type="password" name="confirmpassword" value="<?= $confirmpassword ?>"  required />
                <label>Confirm Password</label>
            </div>
            <div class="content">
                <div class="checkbox">
                    <input type="file" id="remember-me" name="avatar" />
                    <label for="remember-me">Choose a Profile Picture</label>
                </div>
            </div>
            <div class="field">
                <input type="submit" name="submit" value="Register" />
            </div>
            <div class="signup-link">
                Already a member?
                <a href="signin-page.php">Log In</a>
            </div>
            <a href="index.php"><i class="ri-home-7-fill"></i> Home Page</a>
        </form>
    </div>

    <!-- Vendor Js Files -->
    <script src="assets/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendors/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendors/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendors/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendors/aos/aos.js"></script>

    <!-- Main Js Files -->
    <script src="assets/js/main.js"></script>
</body>
</html>
