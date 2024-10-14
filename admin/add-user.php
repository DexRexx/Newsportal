<?php
session_start();
require 'partials/header.php';

//   Get back form data if any error occurs
$firstname = $_SESSION['add-user-data']['firstname'] ?? null;
$lastname = $_SESSION['add-user-data']['lastname'] ?? null;
$username = $_SESSION['add-user-data']['username'] ?? null;
$email = $_SESSION['add-user-data']['email'] ?? null;
$createpassword = $_SESSION['add-user-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['add-user-data']['confirmpassword'] ?? null;
$error_message = $_SESSION['adduser-error'] ?? null; // Error message if any


// Clear the adduser data session
unset($_SESSION['add-user-data']);
unset($_SESSION['adduser-error']); // Clear error message session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>News360 | Add User</title>
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
                        <h2>Add a User</h2>
                    </div>
                </section>
                <!-- End Breadcrumbs -->
                
                <!-- Display Error Message if Exists -->
                <?php if ($error_message): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($error_message) ?>
                    </div>
                <?php endif; ?>

                <div class="form-container" style="width: 60%; @media (max-width: 480px) {width: 100px}">
                    <h2 style="border-bottom: 1px solid #3d3d3d; font-size: 20px">Add User</h2>

                    <form action="forms/adduser-form.php" method="post" style="width: 100%" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="category">First Name</label>
                            <input type="text" id="category" value="<?= htmlspecialchars($firstname) ?>" name="firstname" style="width: 100%" required />
                            <label for="category" style="margin-top: 20px">Last Name</label>
                            <input type="text" id="category" value="<?= htmlspecialchars($lastname) ?>" name="lastname" style="width: 100%" required />
                            <label for="category" style="margin-top: 20px">Username</label>
                            <input type="text" value="<?= htmlspecialchars($username) ?>"  name="username" style="width: 100%" required />
                            <label for="category" style="margin-top: 20px">Email</label>
                            <input type="email" id="category" value="<?= htmlspecialchars($email) ?>" name="email" style="width: 100%" required />
                            <label for="category" style="margin-top: 20px">Create Password</label>
                            <input type="password" id="category" value="<?= htmlspecialchars($createpassword) ?>" name="create_password" style="width: 100%" required />
                            <label for="category" style="margin-top: 20px">Confirm Password</label>
                            <input type="password" id="category" value="<?= htmlspecialchars($confirmpassword) ?>" name="confirmpassword" style="width: 100%" required />
                            
                            <label for="category" style="margin-top: 20px">Profile Picture</label>
                            <input type="file" id="category" name="avatar" required />
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
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
</body>
</html>
