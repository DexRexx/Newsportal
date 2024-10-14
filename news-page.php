<?php
session_start();
require 'config/database.php';

// Get the current page number from the query string, default to 1 if not set
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$posts_per_page = 4;  // Display 4 latest posts per page
$offset = ($current_page - 1) * $posts_per_page;

// Query to get total number of posts
$total_posts_query = "SELECT COUNT(*) as total FROM posts";
$total_posts_result = mysqli_query($conn, $total_posts_query);
$total_posts = mysqli_fetch_assoc($total_posts_result)['total'];

// Fetch the latest 4 posts for the current page along with the author's name and category name
$posts_query = "SELECT posts.*, users.username AS author_name, categories.name AS category_name 
                FROM posts 
                JOIN users ON posts.author_id = users.id 
                JOIN categories ON posts.category_id = categories.id 
                ORDER BY posts.created_at DESC 
                LIMIT $offset, $posts_per_page";
$posts_result = mysqli_query($conn, $posts_query);

// Calculate total pages
$total_pages = ceil($total_posts / $posts_per_page);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>News 360 | News Section</title>
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
    <?php include 'partials/header.php'; ?>
    <!-- End Header -->

    <main id="main">
      <!-- Breadcrumbs -->
      <section id="breadcrumbs" class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li><a href="news-page.php">News</a></li>
          </ol>
          <h2>Latest News</h2>
        </div>
      </section>
      <!-- End Breadcrumbs -->

      <!-- Blog Section -->
      <section id="blog" class="blog">
        <div class="container" data-aos="fade-up">
          <div class="row">
            <div class="col-lg-8 entries">

              <?php
// Display the posts
if (mysqli_num_rows($posts_result) > 0) {
  while ($post = mysqli_fetch_assoc($posts_result)) {
    echo '
    <article class="entry">
      <div class="entry-img">
        <img src="admin/assets/images/uploads/' . htmlspecialchars($post['thumbnail']) . '" alt="" class="img-fluid" />
      </div>
      <h2 class="entry-title">
        <a href="single-post.php?id=' . htmlspecialchars($post['id']) . '">' . htmlspecialchars($post['title']) . '</a>
      </h2>
      <div class="entry-meta">
        <ul>
          <li class="d-flex align-items-center">
            <i class="bi bi-person"></i>
            <a href="single-post.php?id=' . htmlspecialchars($post['id']) . '">' . htmlspecialchars($post['author_name']) . '</a>
          </li>
          <li class="d-flex align-items-center">
            <i class="bi bi-clock"></i>
            <a href="single-post.php?id=' . htmlspecialchars($post['id']) . '"><time datetime="' . htmlspecialchars($post['created_at']) . '">' . date('M d, Y', strtotime($post['created_at'])) . '</time></a>
          </li>
          <li class="d-flex align-items-center">
            <i class="bi bi-folder2"></i>
            <a href="category-page.php?id=' . htmlspecialchars($post['id']) . '"><span class="ps-2">' . htmlspecialchars($post['category_name']) . '</span></a>
          </li>
        </ul>
      </div>
      <div class="entry-content">
        <p>' . htmlspecialchars(substr($post['description'], 0, 150)) . '...</p>
        <div class="read-more">
          <a href="single-post.php?id=' . htmlspecialchars($post['id']) . '">Read More</a>
        </div>
      </div>
    </article>';
  }
} else {
  echo '<p>No posts found.</p>';
}
?>


              <!-- Pagination -->
              <div class="blog-pagination">
                <ul class="justify-content-center">
                  <?php if ($current_page > 1): ?>
                    <li><a href="?page=<?php echo $current_page - 1; ?>"><i class="bi bi-chevron-left"></i></a></li>
                  <?php endif; ?>

                  <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li><a href="?page=<?php echo $i; ?>" class="<?php if ($i == $current_page) echo 'active'; ?>"><?php echo $i; ?></a></li>
                  <?php endfor; ?>

                  <?php if ($current_page < $total_pages): ?>
                    <li><a href="?page=<?php echo $current_page + 1; ?>"><i class="bi bi-chevron-right"></i></a></li>
                  <?php endif; ?>
                </ul>
              </div>
              <!-- End Pagination -->

            </div>

            <!-- Sidebar -->
            <?php include 'partials/sidebar.php'; ?>
            <!-- End Sidebar -->

          </div>
        </div>
      </section>
      <!-- End Blog Section -->
    </main>

    <!-- ======= Footer ======= -->
    <?php
        include 'partials/footer.php';
    ?>
    <!-- End Footer -->