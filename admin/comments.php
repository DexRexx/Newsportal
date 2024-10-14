<?php
  session_start();
  require 'config/database.php';

// Fetch categories from database ordered by id in ascending order
$query = "SELECT * FROM comments ORDER BY id ASC";
$result = mysqli_query($conn, $query);
$comments = mysqli_query($conn, $query);

// Error handling for database query
if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard | Comments</title>
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
              <h2>Comments</h2>
            </div>
          </section>
          <!-- End Breadcrumbs -->

           <?php
            // Display success or error message if set
              if (isset($_SESSION['delete-success'])) {
              echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['delete-success']) . '</div>';
              unset($_SESSION['delete-success']);
              }

              if (isset($_SESSION['delete-error'])) {
              echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['delete-error']) . '</div>';
              unset($_SESSION['delete-error']);
              }
            ?>

          <!-- Manage Deleted Posts -->
          <div class="edit-container">
            <h3><i class="ri-chat-unread-fill"></i>Comments</h3>
            <table class="deleted-category-table">
              <thead style="font-size: 18px; font-family: Teko, sans-serif">
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Subject</th>
                  <th>Message</th>
                  <th>Article No</th>
                  <th>Action</th>
                </tr>
              </thead>
                <?php while ($comment = mysqli_fetch_assoc($comments)): ?>
                <tbody style="font-size: 15px; font-family: Oswald, sans-serif">
                  <tr>
                  <td><?= htmlspecialchars($comment['id']) ?></td>
                  <td><?= htmlspecialchars($comment['name']) ?></td>
                  <td><?= htmlspecialchars($comment['email']) ?></td>
                  <td><?= htmlspecialchars($comment['subject']) ?></td>
                  <td><?= htmlspecialchars($comment['comment_text']) ?></td>
                  <td><?= htmlspecialchars($comment['post_id']) ?></td>
                  <td>
                    <a href="forms/deletecomments.php?id=<?= htmlspecialchars($comment['id']) ?>" class="delete-icon"
                      ><i class="fas fa-trash"></i
                    ></a>
                  </td>
                  </tr>  
                  <?php endwhile; ?>   
                </tbody>              
            </table>
          </div>
          <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->

        <?php
        include 'partials/footer.php'
       ?>