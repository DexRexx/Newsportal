<?php
require 'config/database.php';

// Check if the user is logged in
$is_logged_in = isset($_SESSION['user_id']);
?>

<!-- ======= Top Bar ======= -->
<div id="topbar" class="fixed-top d-flex align-items-center">
      <div
        class="container d-flex align-items-center justify-content-center justify-content-md-between"
      >
        <div class="contact-info d-flex align-items-center">
          <i class="bi bi-envelope-fill"></i
          ><a href="mailto:contact@example.com">sherifissaka29@gmail.com</a>
          <i class="bi bi-phone-fill phone-icon"></i> 0208102626
        </div>
        <div class="cta d-none d-md-block">
          <i class="ri-calendar-fill"></i> <?= date('D d M Y') ?>
        </div>
      </div>
    </div>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center">
      <div class="container d-flex align-items-center justify-content-between">
        <h1 class="logo">
          <a href="index.php">News<span>360</span></a>
        </h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href=index.php" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

        <nav id="navbar" class="navbar">
          <ul>
            <li><a href="index.php">Home</a></li>
            <li class="dropdown">
  <a href="news-page.php">
    <span>News</span> <i class="bi bi-chevron-down"></i>
  </a>
  <ul>
    <li><a href="category-page.php?category_id=1">Politics</a></li>
    <li><a href="category-page.php?category_id=2">General News</a></li>
    <li><a href="category-page.php?category_id=3">International News</a></li>
    <li><a href="category-page.php?category_id=4">Sports News</a></li>
    <li><a href="category-page.php?category_id=5">Business News</a></li>
    <li><a href="category-page.php?category_id=6">Health News</a></li>
    <li><a href="category-page.php?category_id=7">Entertainment & Showbiz</a></li>
  </ul>
            </li>
            <li>
              <a href="about-page.php">About</a>
            </li>
            <li>
              <a href="services-page.php">Services</a>
            </li>
            <li>
              <a href="contact-page.php">Contact</a>
            </li>
            
            <?php if ($is_logged_in): ?>
            <!-- Show profile image if logged in -->
            <div class="dropdown text-end">
              <a
                href="admin/dashboard.php"
                class="d-block link-body-emphasis text-decoration-none dropdown-toggle"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <img style="height: 40px; width: 40px; border: 3px solid black"
                  src="assets/images/admin.jpg"
                  alt="Profile Image"
                  width="50"
                  height="50"
                  class="rounded-circle"
                />
              </a>
              <ul
                class="dropdown-menu text-small"
                style="font-family: Teko, sans-serif"
                ;
              >
                <li>
                  <a class="dropdown-item" href="admin/index.php"
                    >Dashboard<i
                      class="ri-dashboard-3-fill"
                      style="font-size: 15px"
                    ></i>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="admin/manage-post.php"
                    >Articles
                    <i class="ri-book-open-fill" style="font-size: 15px"></i></a>
                  
                </li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                  <a
                    class="dropdown-item"
                    style="background: rgb(180, 10, 10); color: #fff"
                    href="forms/logout.php"
                    >Log out
                    <i class="ri-logout-box-r-fill" style="font-size: 15px"></i
                  ></a>
                </li>
              </ul>
            </div>
            <?php else: ?> 
            <!-- Show Get Started link if not logged in -->
            <li><a href="signin-page.php" id="btn">Get Started</a></li> 
            <?php endif; ?>
          </ul>
          <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
        <!-- .navbar -->
      </div>
    </header>
