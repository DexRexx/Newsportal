<?php
 session_start();
 require 'partials/header.php';

// Fetch counts from the database
$articleCount = $conn->query("SELECT COUNT(*) AS total FROM posts")->fetch_assoc()['total'];
$categoryCount = $conn->query("SELECT COUNT(*) AS total FROM categories")->fetch_assoc()['total'];
$publisherCount = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total']; // Assuming publishers are non-admin users
$commentCount = $conn->query("SELECT COUNT(*) AS total FROM comments")->fetch_assoc()['total'];

// Fetch admin status from session or database
$is_admin = $_SESSION['is_admin'] ?? 0; // Adjust this based on how you're storing the admin status 

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>News 360 | Dashboard</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- favicons -->
    <link href="../assets/images/favicons/favicon.png" rel="icon" />
    <link
      href="../assets/images/favicons/apple-touch-icon.png"
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
      href="assets/vendor/fontawesome-free/css/all.min.css"
      rel="stylesheet"
      type="text/css"
    />
    <link href="../assets/vendors/remixicon/remixicon.css" rel="stylesheet" />
    <link href="../assets/vendors/aos/aos.css" rel="stylesheet" />

    <!-- Css Main File -->
    <link rel="stylesheet" href="assets/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
  </head>

  <body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

      <!-- Sidebar -->
      <?php
        include 'partials/sidebar.php'
       ?>
      <!-- End of Sidebar -->

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">

          <!-- Topbar -->
          <?php
              include 'partials/topbar.php'
          ?>
          <!-- End of Topbar -->

          <!-- Begin Page Content -->
          <!-- ======= Breadcrumbs ======= -->
          <section id="breadcrumbs" class="breadcrumbs">
            <div class="container">
              <ol>
                <li><a href="../home-page.php">Home</a></li>
                <li><a href="../index.php">News</a></li>
              </ol>
              <h2>Dashboard</h2>
            </div>
          </section>
          <!-- End Breadcrumbs -->

          <!-- Category dashboard-->
          <div class="dashboard">
          <a
              href="manage-post.php"
              class="dashboard-item"
              style="border: 5px solid rgba(24, 24, 24, 0.74)"
            >
              <h3>ARTICLES</h3>
              <p><?= htmlspecialchars($articleCount) ?></p>
            </a>
            <!-- Show the following sections only if is_admin = 1 -->
            <?php if ($is_admin == 1): ?>
            <a
              href="manage-category.php"
              class="dashboard-item"
              style="border: 5px solid rgba(24, 24, 24, 0.74)"
            >
              <h3>CATEGORIES LISTED</h3>
              <p><?= htmlspecialchars($categoryCount) ?></p>
            </a>
            
            <a
              href="manage-user.php"
              class="dashboard-item"
              style="border: 5px solid rgba(24, 24, 24, 0.74)"
            >
              <h3>PUBLISHERS</h3>
              <p><?= htmlspecialchars($publisherCount) ?></p>
            </a>
            <a
              href="comments.php"
              class="dashboard-item"
              style="border: 5px solid rgba(24, 24, 24, 0.74)"
            >
              <h3>COMMENTS</h3>
              <p><?= htmlspecialchars($commentCount) ?></p>
            </a>
            <?php endif; ?>
          </div>
          <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->

       <?php
        include 'partials/footer.php'
       ?>