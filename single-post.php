<?php
session_start();  // Start the sessions
require 'config/database.php';

// fetch post from database if id is section
if(isset($_GET['id'])) {
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
  $query = "SELECT posts.*, users.username AS author_name, categories.name AS category_name
    FROM posts
    JOIN users ON posts.author_id = users.id
    JOIN categories ON posts.category_id = categories.id
    WHERE posts.id = $id";
  $result = mysqli_query($conn, $query);
  $post = mysqli_fetch_assoc($result);

  // Fetch comments count related to the post
    $comments_query = "SELECT COUNT(*) AS comment_count FROM comments WHERE post_id = ?";
    $stmt = $conn->prepare($comments_query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $comments_result = $stmt->get_result();
    $comment_count = $comments_result->fetch_assoc()['comment_count'];

     // Fetch all comments related to the post
    $comments_query = "SELECT name, email, subject, comment_text, created_at 
                       FROM comments WHERE post_id = ?";
    $stmt = $conn->prepare($comments_query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $all_comments_result = $stmt->get_result();
} else {
  header('location: news-page.php');
  die();
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>News 360 | Article</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- favicons -->
    <link href="assets/images/favicons/favicon.png" rel="icon" />
    <link
      href="assets/images/favicons/apple-touch-icon.png"
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
      href="assets/vendors/bootstrap/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="assets/vendors/bootstrap-icons/bootstrap-icons.css"
      rel="stylesheet"
    />
    <link href="assets/vendors/swiper/swiper-bundle.min.css" rel="stylesheet" />
    <link
      href="assets/vendors/glightbox/css/glightbox.min.css"
      rel="stylesheet"
    />
    <link href="assets/vendors/aos/aos.css" rel="stylesheet" />
    <link href="assets/vendors/remixicon/remixicon.css" rel="stylesheet" />

    <!-- Css Main File -->
    <link rel="stylesheet" href="assets/css/main.css" />
  </head>

  <body>
     <!-- ======= header  ======= -->
     <?php
                  include 'partials/header.php';
            ?>
    <!-- End Header -->

    <main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li><a href="news-page.php">News</a></li>
          </ol>
          <h2><?= $post['category_name'] ?></h2>
        </div>
      </section>
      <!-- End Breadcrumbs -->

      <!-- ======= Blog Single Section ======= -->
      <section id="blog" class="blog">
        <div class="container" data-aos="fade-up">
          <div class="row">
            <div class="col-lg-8 entries">
              <article class="entry entry-single">
                <div class="entry-img">
                  <img src="admin/assets/images/uploads/<?= $post['thumbnail'] ?>" class="img-fluid" />
                </div>
                <h2 class="entry-title">
                  <a href="#"
                    ><?= $post['title'] ?></a
                  >
                </h2>
                <div class="entry-meta">
                  <ul>
                    <li class="d-flex align-items-center">
                      <i class="bi bi-person"></i>
                      <a href="#"><?= $post['author_name'] ?></a>
                    </li>
                    <li class="d-flex align-items-center">
                      <i class="bi bi-clock"></i>
                      <a href="#"
                        ><time datetime="2020-01-01"><time datetime="<?= htmlspecialchars($post['created_at']) ?>"><?= date("M d, Y", strtotime($post['created_at'])) ?></time></time></a
                      >
                    </li>
                    <li class="d-flex align-items-center">
                      <i class="bi bi-chat-dots"></i>
                      <a href="#"><?= $comment_count ?> Comment(s)</a>
                    </li>
                  </ul>
                </div>
                <div class="entry-content">
                  <p>
                  <?= $post['content'] ?>
                  </p>
                  <blockquote>
                    <p>
                    <?= $post['description'] ?>
                    </p>
                  </blockquote>      
                </div>
                <div class="entry-footer">
                  <i class="bi bi-folder"></i>
                  <ul class="cats">
                    <li><a href="#"><?= $post['category_name'] ?></a></li>
                  </ul>
                  <i class="bi bi-tags"></i>
                  <ul class="tags">
                    <li><a href="#"><?= $post['tags'] ?></a></li>
                    
                  </ul>
                </div>
              </article>
              <!-- End blog entry -->
              
              <!-- Comments Section -->
              <div class="blog-comments">
                <h4 class="comments-count"><?= $comment_count ?> Comment(s)</h4>
                
                            <!-- Loop through each comment -->
                <?php while ($comment = $all_comments_result->fetch_assoc()): ?>
                <div id="comment-<?= htmlspecialchars($comment['name']); ?>" class="comment">
                    <div class="d-flex">
                        <div class="comment-img">
                            <img style="height: 25px; width: 25px;" src="assets/images/admin.jpg" alt="Profile Picture" />
                        </div>
                        <div>
                            <h5>
                                <a href="#"><?= htmlspecialchars($comment['name']); ?></a>
                                <a href="#" class="reply"><i class="bi bi-reply-fill"></i> Reply</a>
                            </h5>
                            <time datetime="<?= $comment['created_at']; ?>">
                                <?= date('d M, Y', strtotime($comment['created_at'])); ?>
                            </time>
                            <p><?= htmlspecialchars($comment['comment_text']); ?></p>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
                
                <?php
                  if (isset($_SESSION['message'])): ?>
                      <div style="margin-top: 15px;" class="alert alert-<?= $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
                          <?= $_SESSION['message']; ?>
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                      <?php
                      // Clear the session message after displaying it
                      unset($_SESSION['message']);
                      unset($_SESSION['message_type']);
                  endif;
                  ?>

               <!--- Comment Form --->
                <div class="reply-form">
                  <h4>Leave a Reply</h4>
                  <p>
                    Your email address will not be published. Required fields
                    are marked *
                  </p>
                  <form action="forms/comments.php?id=<?= $post['id']; ?>" method="post"> 
                      <div class="row">
                      <div class="col-md-6 form-group">
                      <input name="name" type="text" class="form-control" placeholder="Your Name*" required />
                      </div>
                      <div class="col-md-6 form-group">
                      <input name="email" type="text" class="form-control" placeholder="Your Email*" required />
                      </div>
                      </div>
                      <div class="row">
                      <div class="col form-group">
                      <input name="subject" type="text" class="form-control" placeholder="Subject"  />
                    </div>
                    </div>
                    <div class="row">
                        <div class="col form-group">
                        <textarea name="comment" class="form-control" placeholder="Your Comment*" required ></textarea>
                    </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Post Comment</button>
                  </form>
                </div>
              </div>
              <!-- End blog comments -->
            </div>
            <!-- /End blog entries list -->

               <!-- ======= sidebar  ======= -->
            <?php
                  include 'partials/sidebar.php';
            ?>
          <!-- End Header -->

          </div>
        </div>
      </section>
      <!-- End Blog Single Section -->
    </main>

     <!-- ======= footer  ======= -->
            <?php
                  include 'partials/footer.php';
            ?>
          <!-- End footer -->