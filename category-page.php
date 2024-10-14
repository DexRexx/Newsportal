<?php
session_start();  // Start the sessions
require 'config/database.php';

if (isset($_GET['category_id'])) {
  $category_id = $_GET['category_id'];

// Validate the category ID
if ($category_id <= 0) {
    // Invalid category ID, redirect to a default page or show an error
    header("Location: news.php");
    exit();
}

// Fetch the category name from the database
$category_query = "SELECT name FROM categories WHERE id = ?";
$stmt = $conn->prepare($category_query);
$stmt->bind_param("i", $category_id);
$stmt->execute();
$category_result = $stmt->get_result();

if ($category_result->num_rows === 0) {
    // Category not found, redirect or show an error
    header("Location: news.php");
    exit();
}

$category = $category_result->fetch_assoc();
$category_name = htmlspecialchars($category['name']);

// Pagination settings
$posts_per_page = 4;  // Display 4 posts per page
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) $current_page = 1;
$offset = ($current_page - 1) * $posts_per_page;

// Query to get total number of posts in this category
$total_posts_query = "SELECT COUNT(*) as total FROM posts WHERE category_id = ?";
$stmt_total = $conn->prepare($total_posts_query);
$stmt_total->bind_param("i", $category_id);
$stmt_total->execute();
$total_posts_result = $stmt_total->get_result();
$total_posts = $total_posts_result->fetch_assoc()['total'];

// Calculate total pages
$total_pages = ceil($total_posts / $posts_per_page);

// Fetch posts for the current page along with author and category names
$posts_query = "
    SELECT posts.*, users.username AS author_name, categories.name AS category_name 
    FROM posts 
    JOIN users ON posts.author_id = users.id 
    JOIN categories ON posts.category_id = categories.id 
    WHERE posts.category_id = ? 
    ORDER BY posts.created_at DESC 
    LIMIT ? OFFSET ?
";
$stmt_posts = $conn->prepare($posts_query);
$stmt_posts->bind_param("iii", $category_id, $posts_per_page, $offset);
$stmt_posts->execute();
$posts_result = $stmt_posts->get_result();

} else {
    echo '<p>Invalid category.</p>';
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $category_name; ?> | News 360</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- Favicons -->
    <link href="assets/images/favicons/favicon.png" rel="icon" />
    <link href="assets/images/favicons/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Teko:wght@300..700&display=swap"
      rel="stylesheet"
    />

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
                    <li><?php echo $category_name; ?></li>
                </ol>
                <h2><?php echo $category_name; ?></h2>
            </div>
        </section>
        <!-- End Breadcrumbs -->

        <!-- ======= Blog Section ======= -->
        <section id="blog" class="blog">
            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="col-lg-8 entries">

                        <?php
                        // Display the posts
                        if ($posts_result->num_rows > 0) {
                            while ($post = $posts_result->fetch_assoc()) {
                                echo '
                                <article class="entry">
                                    <div class="entry-img">
                                        <img src="admin/assets/images/uploads/' . htmlspecialchars($post['thumbnail']) . '" alt="' . htmlspecialchars($post['title']) . '" class="img-fluid" />
                                    </div>
                                    <h2 class="entry-title">
                                        <a href="single-post.php?id=' . htmlspecialchars($post['id']) . '">' . htmlspecialchars($post['title']) . '</a>
                                    </h2>
                                    <div class="entry-meta">
                                        <ul>
                                            <li class="d-flex align-items-center">
                                                <i class="bi bi-person"></i>
                                                <a href="author.php?id=' . htmlspecialchars($post['author_id']) . '">' . htmlspecialchars($post['author_name']) . '</a>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <i class="bi bi-clock"></i>
                                                <a href="single-post.php?id=' . htmlspecialchars($post['id']) . '">
                                                    <time datetime="' . htmlspecialchars($post['created_at']) . '">' . date('M d, Y', strtotime($post['created_at'])) . '</time>
                                                </a>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <i class="bi bi-folder2"></i>
                                                <a href="#?category_id=' . htmlspecialchars($post['category_id']) . '"><span class="ps-2">' . htmlspecialchars($post['category_name']) . '</span></a>
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
                            echo '<p>No posts found in this category.</p>';
                        }
                        ?>

                        <!-- Pagination -->
                        <?php if ($total_pages > 1): ?>
                            <div class="blog-pagination">
                                <ul class="justify-content-center">
                                    <!-- Previous Page Link -->
                                    <?php if ($current_page > 1): ?>
                                        <li>
                                            <a href="?category_id=<?php echo $category_id; ?>&page=<?php echo $current_page - 1; ?>">
                                                <i class="bi bi-chevron-left"></i>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <!-- Page Number Links -->
                                    <?php
                                    // Display a range of pages around the current page
                                    $range = 2; // Number of pages to show on each side of current page
                                    $start = max(1, $current_page - $range);
                                    $end = min($total_pages, $current_page + $range);

                                    if ($start > 1) {
                                        echo '<li><a href="?category_id=' . $category_id . '&page=1">1</a></li>';
                                        if ($start > 2) {
                                            echo '<li>...</li>';
                                        }
                                    }

                                    for ($i = $start; $i <= $end; $i++) {
                                        if ($i == $current_page) {
                                            echo '<li><a href="#" class="active">' . $i . '</a></li>';
                                        } else {
                                            echo '<li><a href="?category_id=' . $category_id . '&page=' . $i . '">' . $i . '</a></li>';
                                        }
                                    }

                                    if ($end < $total_pages) {
                                        if ($end < $total_pages - 1) {
                                            echo '<li>...</li>';
                                        }
                                        echo '<li><a href="?category_id=' . $category_id . '&page=' . $total_pages . '">' . $total_pages . '</a></li>';
                                    }
                                    ?>

                                    <!-- Next Page Link -->
                                    <?php if ($current_page < $total_pages): ?>
                                        <li>
                                            <a href="?category_id=<?php echo $category_id; ?>&page=<?php echo $current_page + 1; ?>">
                                                <i class="bi bi-chevron-right"></i>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <!-- End Pagination -->

                    </div>
                    <!-- End blog entries list -->

                    <!-- ======= Sidebar ======= -->
                    <?php include 'partials/sidebar.php'; ?>
                    <!-- End Sidebar -->

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
