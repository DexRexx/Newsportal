<?php
    session_start();
    require 'partials/header.php';

  // Fetch categories from the database
$query = "SELECT * FROM categories";
$categories = mysqli_query($conn, $query);

$error_message = $_SESSION['addpost-error'] ?? null;
unset($_SESSION['addpost-error']);

// Fetch post data from database if id is set
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $post = mysqli_fetch_assoc($result);
    } else {
        die("Error fetching post: " . mysqli_error($conn));
    }
    if (!$post) {
        header('location: manage-post.php');
        die();
    }
} else {
    header('location: manage-post.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard | Edit Post</title>
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

    <!-- Summernote Cdn Links -->
    <link
      href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css"
      rel="stylesheet"
    />

    <!-- Css Main File -->
    <link rel="stylesheet" href="assets/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
  </head>

  <body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

      <!-- Sidebar -->
      
      <!-- End of Sidebar -->
      <?php
        include 'partials/sidebar.php'
       ?>
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
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="manage-post.php">Manage Post</a></li>
              </ol>
              <h2>Edit Post</h2>
            </div>
          </section>
          <!-- End Breadcrumbs -->

           <!-- Error Message -->
            <?php if ($error_message): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>

          
          <!-- Edit Category Form -->
          <div class="form-container" style="margin-top: 50px;">
            <h2 style="border-bottom: 1px solid #3d3d3d; font-size: 20px">
              Edit Article
            </h2>
            <form action="forms/editpost-form.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $post['id'] ?>" />

            <div class="form-group">
                <label for="post-title">Post Title</label>
                <input type="text" id="post-title" name="title" value="<?= htmlspecialchars($post['title']) ?>" placeholder="Enter title..." required />
            </div>

            <div class="form-group">
                <label for="category">Choose a Category</label>
                <select name="category" required>
                    <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
                        <option value="<?= $category['id'] ?>" <?= $category['id'] == $post['category_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="tags">Enter keyword</label>
                <input type="text" id="tags" name="tags" value="<?= htmlspecialchars($post['tags']) ?>" placeholder="Tags help to identify the published article..." />
            </div>

            <div class="form-group">
                <label for="description">Enter Description or Summary</label>
                <textarea id="description" name="description" rows="1" placeholder="Describe or give a short summary of the article..." required><?= htmlspecialchars($post['description']) ?></textarea>
            </div>

            <div class="form-group">
                <label for="your_summernote">Post Article</label>
                <textarea name="article" rows="20" id="your_summernote" required><?= htmlspecialchars($post['content']) ?></textarea>
            </div>

            <div class="form-group">
                <label for="thumbnail">Thumbnail</label>
                <input type="file" id="thumbnail" name="thumbnail" />
                <?php if (!empty($post['thumbnail'])): ?>
                    <p style="font-size: 15px;">Current Thumbnail: <?= htmlspecialchars($post['thumbnail']) ?></p>
                <?php endif; ?>
            </div>

            <?php if ($is_admin == 1): ?>
            <div class="form-group">
                <label for="is_featured">Featured</label>
                <input type="checkbox" id="is_featured" name="is_featured" <?= $post['is_featured'] ? 'checked' : '' ?> />
            </div>
            <?php endif; ?>

            <div class="form-group">
                <button name="submit" type="submit">Update</button>
            </div>
            </form>
          </div>

          <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->

        <?php
        include 'partials/footer.php'
       ?>