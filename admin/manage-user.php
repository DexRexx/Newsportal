<?php
session_start();
require 'partials/header.php';

// Display success or error messages
$success_message = $_SESSION['deleteuser-success'] ?? null;
$error_message = $_SESSION['deleteuser-error'] ?? null;

unset($_SESSION['deleteuser-success']);
unset($_SESSION['deleteuser-error']);

// Fetch all users except the current user from the database
$current_admin_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE NOT id = $current_admin_id";
$users = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard | Manage Users</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- favicons -->
    <link href="../assets/images/favicons/favicon.png" rel="icon" />
    <link href="../assets/images/favicons/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Poppins:wght@100..900&family=Teko:wght@300..700&display=swap" rel="stylesheet" />

    <!-- Vendor Files -->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
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
       <?php include 'partials/sidebar.php'; ?>
      <!-- End of Sidebar -->

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">

          <!-- Topbar -->
          <?php include 'partials/topbar.php'; ?>
          <!-- End of Topbar -->

          <!-- Begin Page Content -->
          <!-- ======= Breadcrumbs ======= -->
          <section id="breadcrumbs" class="breadcrumbs">
            <div class="container">
              <ol>
                <li><a href="../index.php">Home</a></li>
                <li><a href="index.php">Dashboard</a></li>
              </ol>
              <h2>Manage Users</h2>
            </div>
          </section>
          <!-- End Breadcrumbs -->

        <!----------- Error Message ----------->
        <?php if (isset($_SESSION['deletepost-error'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_SESSION['deletepost-error']) ?>
        </div>
        <?php unset($_SESSION['deletepost-error']); ?>
        <?php endif; ?>

        <!----------- Success Message ------------>
        <?php if (isset($_SESSION['deletepost-success'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['deletepost-success']) ?>
        </div>
        <?php unset($_SESSION['deletepost-success']); ?>
        <?php endif; ?>

          <!-- Manage User Table -->
          <div class="edit-container">
            <a href="add-user.php">
              <button class="add-btn">
                Add <i class="fas fa-plus-circle"></i></button
            ></a>
            <table class="category-table">
              <thead style="font-size: 18px; font-family: Teko, sans-serif">
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Admin</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody style="font-size: 15px; font-family: Oswald, sans-serif">
                <?php while($user = mysqli_fetch_assoc($users)) : ?>
                <tr>
                  <td><?= htmlspecialchars($user['id']) ?></td>
                  <td><?= htmlspecialchars("{$user['firstname']} {$user['lastname']}") ?></td>
                  <td><?= htmlspecialchars($user['username']) ?></td>
                  <td><?= htmlspecialchars($user['email']) ?></td>
                  <td><?= htmlspecialchars($user['is_admin'] ? 'Yes' : 'No') ?></td>
                  <td>
                    <a href="edit-user.php?id=<?= htmlspecialchars($user['id']) ?>" class="edit-icon">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="forms/deleteuser-form.php?id=<?= htmlspecialchars($user['id']) ?>" class="delete-icon" onclick="return confirm('Are you sure you want to delete this user?');">
                      <i class="fas fa-trash"></i>
                    </a>
                  </td>
                </tr>
                <?php endwhile ?>
              </tbody>
            </table>
          </div>

          <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->

        <?php include 'partials/footer.php'; ?>
      </div>
    </div>
</body>
</html>
