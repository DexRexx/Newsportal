<?php
session_start();  // Start the sessions
require 'config/database.php';

// Initialize search term
$search_term = '';
$search_results = [];
$total_results = 0;
$results_per_page = 10;  // Number of results per page
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $results_per_page;

// Check if search term is provided
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = $_GET['search'];
    $search_term = $conn->real_escape_string($search_term);

    // Get the total number of results for pagination
    $total_query = "SELECT COUNT(*) AS total FROM posts WHERE 
                    title LIKE '%$search_term%' OR 
                    description LIKE '%$search_term%' OR 
                    tags LIKE '%$search_term%'";
    $total_result = $conn->query($total_query);
    $total_row = $total_result->fetch_assoc();
    $total_results = $total_row['total'];

// Fetch posts with author name and category name
$search_query = "
    SELECT posts.*, users.username AS author_name, categories.name AS category_name 
    FROM posts 
    LEFT JOIN users ON posts.author_id = users.id 
    LEFT JOIN categories ON posts.category_id = categories.id 
    WHERE posts.title LIKE '%$search_term%' 
    OR posts.description LIKE '%$search_term%' 
    OR posts.tags LIKE '%$search_term%' 
    ORDER BY posts.created_at DESC 
    LIMIT $results_per_page OFFSET $offset
";
$search_results = $conn->query($search_query);

if (!$search_results) {
    die("Search query failed: " . $conn->error);
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>News 360 | Search Results</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- favicons -->
    <link href="assets/images/favicons/favicon.png" rel="icon" />
    <link href="assets/images/favicons/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Teko:wght@300..700&display=swap" rel="stylesheet" />

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

<body>
    
    <!-- ======= Header ======= -->
    <?php include 'partials/header.php'; ?>
    <!-- End Header -->

    <main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li><a href="news-page.php">News</a></li>
          </ol>
           <h2>Search Results for "<?php echo htmlspecialchars($search_term); ?>"</h2>
        </div>
      </section>
      <!-- End Breadcrumbs -->

      <!-- ======= Blog Section ======= -->
      <section id="blog" class="blog">
        <div class="container" data-aos="fade-up">
          <div class="row">
            <div class="col-lg-8 entries">
              <?php if ($search_results && $search_results->num_rows > 0): ?>
                <?php while ($post = $search_results->fetch_assoc()): ?>
                  <article class="entry">
                    <div class="entry-img">
                      <img src="admin/assets/images/uploads/<?php echo htmlspecialchars($post['thumbnail']); ?>" alt="" class="img-fluid" />
                    </div>
                    <h2 class="entry-title">
                      <a href="single-post.php?id=<?php echo htmlspecialchars($post['id']); ?>">
                        <?php echo htmlspecialchars(substr($post['title'], 0, 50)) . (strlen($post['title']) > 50 ? '...' : ''); ?>
                      </a>
                    </h2>
                    <div class="entry-meta">
                      <ul>
                        <li class="d-flex align-items-center">
                          <i class="bi bi-person"></i>
                          <a href="single-post.php?id=<?php echo htmlspecialchars($post['id']); ?>"><?php echo htmlspecialchars($post['author_name']); ?></a>
                        </li>
                        <li class="d-flex align-items-center">
                          <i class="bi bi-clock"></i>
                          <a href="single-post.php?id=<?php echo htmlspecialchars($post['id']); ?>">
                            <time datetime="<?php echo htmlspecialchars($post['created_at']); ?>">
                              <?php echo date("M d, Y", strtotime($post['created_at'])); ?>
                            </time>
                          </a>
                        </li>
                        <li class="d-flex align-items-center">
                          <i class="bi bi-folder2"></i>
                          <span class="ps-2"><?php echo $post['category_name']; ?></span>
                        </li>
                      </ul>
                    </div>
                    <div class="entry-content">
                      <p>
                        <?php echo htmlspecialchars(substr($post['description'], 0, 150)) . (strlen($post['description']) > 150 ? '...' : ''); ?>
                      </p>
                      <div class="read-more">
                        <a href="single-post.php?id=<?php echo htmlspecialchars($post['id']); ?>">Read More</a>
                      </div>
                    </div>
                  </article>
                <?php endwhile; ?>
              <?php else: ?>
                <p>No results found for " <?php echo htmlspecialchars($search_term); ?> "</p>
              <?php endif; ?>
              
              <!-- Page Pagination -->
              <section id="blog-pagination" class="blog-pagination section">
                <div class="container">
                  <div class="d-flex justify-content-center">
                    <ul>
                      <?php
                      // Calculate total pages
                      $total_pages = ceil($total_results / $results_per_page);

                      // Display pagination links
                      if ($current_page > 1) {
                          echo '<li><a href="?search=' . urlencode($search_term) . '&page=' . ($current_page - 1) . '"><i class="bi bi-chevron-left"></i></a></li>';
                      }

                      for ($i = 1; $i <= $total_pages; $i++) {
                          if ($i == $current_page) {
                              echo '<li><a href="#" class="active">' . $i . '</a></li>';
                          } else {
                              echo '<li><a href="?search=' . urlencode($search_term) . '&page=' . $i . '">' . $i . '</a></li>';
                          }
                      }

                      if ($current_page < $total_pages) {
                          echo '<li><a href="?search=' . urlencode($search_term) . '&page=' . ($current_page + 1) . '"><i class="bi bi-chevron-right"></i></a></li>';
                      }
                      ?>
                    </ul>
                  </div>
                </div>
              </section>
              <!-- /Blog Pagination Section -->
            </div>
            <!-- /End blog entries list -->

            <!-- ======= Sidebar ======= -->
            <?php include 'partials/sidebar.php'; ?>
            <!-- End blog sidebar -->

          </div>
        </div>
      </section>
      <!-- End Blog Section -->
    </main>

    <!-- ======= Footer ======= -->
    <?php include 'partials/footer.php'; ?>
    <!-- End Footer -->

</body>
</html>
