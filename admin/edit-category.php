<?php
session_start();
require 'partials/header.php';

// Check for the 'id' parameter in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['addcategory-error'] = "Invalid category ID.";
    header('Location: manage-category.php');
    exit();
}

$categoryId = intval($_GET['id']);
$error_message = $_SESSION['addcategory-error'] ?? null;

// Fetch the current category data from the database
$query = "SELECT * FROM categories WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $categoryId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['addcategory-error'] = "Category not found.";
    header('Location: manage-category.php');
    exit();
}

$category = $result->fetch_assoc();

// Update category in the database if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['category']);
    $description = trim($_POST['description']);

    // Validate form input
    if (empty($name) || empty($description)) {
        $_SESSION['addcategory-error'] = "All fields are required.";
    } else {
        $updateQuery = "UPDATE categories SET name = ?, description = ?, updated_at = NOW() WHERE id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param('ssi', $name, $description, $categoryId);
        if ($updateStmt->execute()) {
            $_SESSION['success-message'] = "Category updated successfully.";
            header('Location: manage-category.php');
            exit();
        } else {
            $_SESSION['addcategory-error'] = "Error updating category: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>| Edit Category</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- favicons -->
    <link href="../assets/images/favicons/favicon.png" rel="icon" />
    <link href="../assets/images/favicons/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Teko:wght@300..700&display=swap" rel="stylesheet" />

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
                        <li><a href="manage-category.php">Manage Category</a></li>
                    </ol>
                    <h2>Edit Category</h2>
                </div>
            </section>
            <!-- End Breadcrumbs -->

            <!-- Display Error Message if Exists -->
            <?php if ($error_message): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($error_message) ?>
                </div>
                <?php unset($_SESSION['addcategory-error']); ?>
            <?php endif; ?>

            <!-- Edit Category Form -->
            <div class="form-container">
                <h2 style="border-bottom: 1px solid #3d3d3d; font-size: 20px">
                    Edit Category
                </h2>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="category">Category Name</label>
                        <input type="text" id="category" name="category" value="<?= htmlspecialchars($category['name']) ?>" required />
                    </div>
                    <div class="form-group">
                        <label for="description">Category Description</label>
                        <textarea id="description" name="description" rows="5" required><?= htmlspecialchars($category['description']) ?></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit">Submit</button>
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
