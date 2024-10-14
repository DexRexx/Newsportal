<?php
session_start();
require 'partials/header.php';

// Display success or error messages
$success_message = $_SESSION['addpost-success'] ?? null;
$error_message = $_SESSION['addpost-error'] ?? null;

unset($_SESSION['addpost-success']);
unset($_SESSION['addpost-error']);

// Pagination settings
$limit = 10; // Number of posts per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch posts with pagination
$query = "SELECT posts.id, posts.title, categories.name AS category_name, posts.created_at, users.username AS publisher 
          FROM posts 
          JOIN categories ON posts.category_id = categories.id 
          JOIN users ON posts.author_id = users.id
          ORDER BY posts.created_at DESC
          LIMIT $limit OFFSET $offset";
$posts_result = mysqli_query($conn, $query);

// Fetch total number of posts for pagination
$total_query = "SELECT COUNT(*) as total FROM posts";
$total_result = mysqli_query($conn, $total_query);
$total_posts = mysqli_fetch_assoc($total_result)['total'];
$total_pages = ceil($total_posts / $limit);

// Function to limit title to 15 words
function limit_title_words($title, $limit = 15) {
    $words = explode(' ', $title);
    if (count($words) > $limit) {
        $title = implode(' ', array_slice($words, 0, $limit)) . '...';
    }
    return $title;
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard | Manage Post</title>
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
                <li><a href="../index.php">Home</a></li>
                <li><a href="index.php">Dashboard</a></li>
              </ol>
              <h2>Manage Post</h2>
            </div>
          </section>
          <!-- End Breadcrumbs -->

          <!-- Error Message -->
        <?php if (isset($_SESSION['deletepost-error'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_SESSION['deletepost-error']) ?>
        </div>
        <?php unset($_SESSION['deletepost-error']); ?>
        <?php endif; ?>

        <!-- Success Message -->
        <?php if (isset($_SESSION['deletepost-success'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['deletepost-success']) ?>
        </div>
        <?php unset($_SESSION['deletepost-success']); ?>
        <?php endif; ?>

          <!-- Manage Post Table -->
          <div class="edit-container">
            <a href="add-post.php">
              <button class="add-btn">
                Add <i class="fas fa-plus-circle"></i></button
            ></a>
            <table class="category-table">
              <thead style="font-size: 18px; font-family: Teko, sans-serif">
                <tr>
                  <th>Title</th>
                  <th>Category</th>
                  <th>Upload Date</th>
                  <th>Publisher</th>
                  <!-- Show the following sections only if is_admin = 1 -->
                  <?php if ($is_admin == 1): ?>
                  <th>Action</th>
                  <?php endif; ?>
                </tr>
              </thead>
              <tbody style="font-size: 15px; font-family: Oswald, sans-serif">    
                <?php while ($post = mysqli_fetch_assoc($posts_result)): ?>            
                <tr style="border-bottom: 1px solid #222222c0">
                  <td>
                    <?= htmlspecialchars($post['title']) ?><
                  </td>
                  <td><?= htmlspecialchars($post['category_name']) ?></td>
                  <td><?= date("d M, Y", strtotime($post['created_at'])) ?></td>
                  <td><?= htmlspecialchars($post['publisher']) ?></td>
                  <!-- Show the following sections only if is_admin = 1 -->
                  <?php if ($is_admin == 1): ?>
                  <td>
                  <a href="edit-post.php?id=<?= $post['id'] ?>" class="edit-icon">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a href="forms/deletepost-form.php?id=<?= $post['id'] ?>" class="delete-icon">
                    <i class="fas fa-trash"></i>
                  </a>
                  </td>
                  <?php endif; ?>
                </tr>
                 <?php endwhile; ?>
              </tbody>
            </table>

            <!-- Pagination Controls -->
            <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>" class="pagination-link">&laquo; Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?>" class="pagination-link <?= $i == $page ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="?page=<?= $page + 1 ?>" class="pagination-link">Next &raquo;</a>
            <?php endif; ?>
            </div>
          </div>

          <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
 
        <?php
        include 'partials/footer.php'
         ?>