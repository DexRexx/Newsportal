<?php
session_start();
require 'partials/header.php';
       
// Check if user ID is passed in the URL
if (isset($_GET['id'])) {
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

  // Fetch the user data based on ID
  $query = "SELECT username, is_admin FROM users WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();
      $username = $user['username'];
      $is_admin = $user['is_admin'];
  } else {
      // If no user found, redirect back to manage-user page
      header('Location: manage-user.php');
      die();
  }

  $stmt->close();
} else {
  header('Location: manage-user.php');
  die();
}

// Error message if any
$error_message = $_SESSION['edituser-error'] ?? null;
unset($_SESSION['edituser-error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit User</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- favicons -->
    <link href="../assets/images/favicons/favicon.png" rel="icon" />
    <link href="../assets/images/favicons/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Teko:wght@300..700&display=swap" rel="stylesheet" />

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
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="manage-user.php">Manage Users</a></li>
              </ol>
              <h2>Edit User</h2>
            </div>
          </section>
          <!-- End Breadcrumbs -->

            <!-- Display Error Message if Exists -->
                <?php if ($error_message): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($error_message) ?>
                    </div>
                <?php endif; ?> 

          <!-- Edit User Form -->
          <div class="form-container" style="width: 60%;">
            <h2 style="border-bottom: 1px solid #3d3d3d; font-size: 20px">Edit User</h2>
            <form action="forms/edituser-form.php" method="POST" style="width: 100%" >
              <div class="form-group">
                <input type="hidden" name="user_id" value="<?= htmlspecialchars($id) ?>">
                <label for="username" style="margin-top: 20px">Username</label>
                <input
                  type="text"
                  id="username"
                  name="username"
                  value="<?= htmlspecialchars($username) ?>"
                  style="width: 100%"
                  required
                />               
                <label for="userrole" style="margin-top: 20px">Select Role</label>
                <select name="userrole" id="userrole" required>
                <option value="0" <?= $is_admin == 0 ? 'selected' : '' ?>>Author</option>
                <option value="1" <?= $is_admin == 1 ? 'selected' : '' ?>>Admin</option>
                </select>
              </div>
              <div class="form-group">
                <button name="submit" type="submit">Submit</button>
              </div>
            </form>
          </div>

          <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->

         <?php include 'partials/footer.php'; ?>
      </div>
    </div>
</body>
</html>
