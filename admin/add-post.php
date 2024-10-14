<?php
  session_start();
  require 'partials/header.php';
  
// Fetch categories from the database
$query = "SELECT * FROM categories";
$categories = mysqli_query($conn, $query);
$error_message = $_SESSION['addpost-error'] ?? null; // Error message if any
$success_message = $_SESSION['addpost-success'] ?? null; // Error message if any

unset($_SESSION['addpost-error']); // Clear error message session
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>| Add Post</title>
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
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="manage-post.php">Manage Post</a></li>
              </ol>
              <h2>Add Post</h2>
            </div>
          </section>
          <!-- End Breadcrumbs -->

            <!-- Error Message -->
            <?php if ($error_message): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($error_message) ?>
                    </div>
            <?php endif; ?>

          <!--============ Add Post Form ================-->
          <!-- Add Category Form -->
          <div class="form-container" style="margin-top: 50px;">
            <h2 style="border-bottom: 1px solid #3d3d3d; font-size: 20px">
              Add an Article
            </h2>
            <form action="forms/addpost-form.php" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="category">Post Title</label>
                <input
                  type="text"
                  id="category"
                  name="title"
                  placeholder="Enter title..."
                  required
                />
              </div>
              <div class="form-group">
                <label for="category">Choose a Category</label>
                <select name="category" required>
                  <?php while($category = mysqli_fetch_assoc($categories)) : ?>
                  <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                  <?php endwhile ?>
                </select>
              </div>
              <div class="form-group">
                <label for="category">Enter keyword</label>
                <input
                  type="text"
                  id="category"
                  name="tags"
                  placeholder="Tags help to identify the published article..."
                />
              </div>
              <div class="form-group">
                <label for="description">Enter Description or Summary</label>
                <textarea
                  id="description"
                  name="description"
                  rows="2"
                  placeholder="describe or give a short summary of the article..."
                  required
                ></textarea>
              </div>
              <div class="form-group">
                <label for="description">Post Article</label>
                <textarea
                  name="article"
                  rows="20"
                  id="your_summernote"
                  required
                ></textarea>
              </div>
              <div class="form-group">
                <label for="category">Thumbnail</label>
                <input type="file" id="category" name="thumbnail" required />
              </div>
              <?php if ($is_admin == 1): ?>
              <div class="form-group">
                <label for="category">Featured</label>
                <input
                  type="checkbox"
                  id="category"
                  name="is_featured"
                />
              </div>
              <?php endif; ?>
              <div class="form-group">
                <button name="submit" type="submit">Publish</button>
              </div>
            </form>
          </div>

          <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->

        <?php
        include 'partials/footer.php'
       ?>