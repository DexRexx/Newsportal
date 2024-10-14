<?php
session_start();  // Start the sessions
require 'config/database.php';

// Number of posts per page
$posts_per_page = 6;

// Get the current page from the URL, if not set default to page 1
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $current_page = $_GET['page'];
} else {
    $current_page = 1;
}

// Calculate the starting point for the query
$offset = ($current_page - 1) * $posts_per_page;

// Fetch the total number of posts
$total_posts_query = "SELECT COUNT(*) AS total FROM posts";
$total_posts_result = $conn->query($total_posts_query);
$total_posts_row = $total_posts_result->fetch_assoc();
$total_posts = $total_posts_row['total'];

// Calculate total pages
$total_pages = ceil($total_posts / $posts_per_page);

// Fetch posts for the current page with category and author names
$query = "
    SELECT posts.*, categories.name AS category_name, users.username AS author_name 
    FROM posts
    INNER JOIN categories ON posts.category_id = categories.id
    INNER JOIN users ON posts.author_id = users.id
    ORDER BY posts.created_at DESC
    LIMIT $posts_per_page OFFSET $offset";

$posts_result = $conn->query($query);

if (!$posts_result) {
    die("Query failed: " . $conn->error);
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>News 360 | Latest News </title>
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

    <main id="main">
        <!-- ======= Hero Slider Section ======= -->
        <section id="hero-slider" class="hero-slider">
            <div class="container-md" data-aos="fade-in">
                <div class="row">
                    <div class="col-12">
                        <div class="swiper sliderFeaturedPosts">
                            <div class="swiper-wrapper">
                                <?php 
                                $featured_sql = "SELECT * FROM posts WHERE is_featured = 1 ORDER BY created_at DESC LIMIT 3";
                                $featured_result = $conn->query($featured_sql);
                                while ($post = $featured_result->fetch_assoc()) { ?>
                                <div class="swiper-slide">
                                    <a href="single-post.php?id=<?php echo $post['id']; ?>" 
                                       class="img-bg d-flex align-items-end" 
                                       style="background-image: url('admin/assets/images/uploads/<?php echo $post['thumbnail']; ?>')">
                                        <div class="img-bg-inner">
                                            <h2><?php echo $post['title']; ?></h2>
                                            <p><?php echo substr($post['description'], 0, 100); ?>...</p>
                                        </div>
                                    </a>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="custom-swiper-button-next">
                                <span class="bi-chevron-right"></span>
                            </div>
                            <div class="custom-swiper-button-prev">
                                <span class="bi-chevron-left"></span>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Hero Slider Section -->

        <!-- Blog Posts Section -->
        <section id="blog-posts" class="blog-posts section">
            <div class="container">
                <div class="row gy-4">
                    <?php while ($post = $posts_result->fetch_assoc()) { ?>
                    <div class="col-lg-4">
                        <article class="position-relative h-100">
                            <div class="post-img position-relative overflow-hidden">
                                <img src="admin/assets/images/uploads/<?php echo $post['thumbnail']; ?>" class="img-fluid" alt="" />
                                <span class="post-date"><?php echo date("F d", strtotime($post['created_at'])); ?></span>
                            </div>
                            <div class="post-content d-flex flex-column">
                                <h3 class="post-title"><?php echo $post['title']; ?></h3>
                                <div class="meta d-flex align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-person"></i>
                                        <span class="ps-2"><?php echo $post['author_name']; ?></span>
                                    </div>
                                    <span class="px-3 text-black-50">/</span>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-folder2"></i>
                                        <span class="ps-2"><?php echo $post['category_name']; ?></span>
                                    </div>
                                </div>
                                <p><?php echo substr($post['description'], 0, 150); ?>...</p>
                                <hr />
                                <a href="single-post.php?id=<?php echo $post['id']; ?>" class="readmore stretched-link">
                                    <span>Read More</span><i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </article>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </section>
        <!-- /Blog Posts Section -->

        <!-- Blog Pagination Section -->
        <section id="blog-pagination" class="blog-pagination section">
            <div class="container">
                <div class="d-flex justify-content-center">
                    <ul>
                        <?php if ($current_page > 1): ?>
                            <li><a href="?page=<?php echo $current_page - 1; ?>"><i class="bi bi-chevron-left"></i></a></li>
                        <?php endif; ?>
                        
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li><a href="?page=<?php echo $i; ?>" class="<?php echo $i == $current_page ? 'active' : ''; ?>"><?php echo $i; ?></a></li>
                        <?php endfor; ?>
                        
                        <?php if ($current_page < $total_pages): ?>
                            <li><a href="?page=<?php echo $current_page + 1; ?>"><i class="bi bi-chevron-right"></i></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </section>
        <!-- /Blog Pagination Section -->
    </main>

    <!-- ======= Footer ======= -->
    <?php
        include 'partials/footer.php';
    ?>
    <!-- End Footer -->