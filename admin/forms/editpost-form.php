<?php
session_start();
require '../partials/header.php'; 

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = trim($_POST['title']);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $tags = trim($_POST['tags']);
    $description = trim($_POST['description']);
    $content = trim($_POST['article']);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    // File upload handling
    $thumbnail = $_FILES['thumbnail']['name'];
    $thumbnail_tmp = $_FILES['thumbnail']['tmp_name'];
    $thumbnail_size = $_FILES['thumbnail']['size'];
    $allowed_file_types = ['image/jpeg', 'image/png', 'image/jpg'];

    // Validate inputs
    if (empty($title) || empty($description) || empty($content)) {
        $_SESSION['addpost-error'] = "All fields marked with an asterisk (*) are required.";
        header("Location: editpost.php?id=$id");
        exit;
    }

    // If a new thumbnail is uploaded
    if ($thumbnail) {
        $thumbnail_type = mime_content_type($thumbnail_tmp);

        if (!in_array($thumbnail_type, $allowed_file_types)) {
            $_SESSION['addpost-error'] = "Invalid file type for thumbnail. Allowed types: JPG, PNG, jpeg.";
            header("Location: editpost.php?id=$id");
            exit;
        }

        if ($thumbnail_size > 3 * 1024 * 1024) { // 3MB file size limit
            $_SESSION['addpost-error'] = "Thumbnail size must be less than 2MB.";
            header("Location: editpost.php?id=$id");
            exit;
        }

        $thumbnail_path = '../assets/images/uploads/' . basename($thumbnail);
        move_uploaded_file($thumbnail_tmp, $thumbnail_path);
    } else {
        // Keep the old thumbnail if no new file is uploaded
        $query = "SELECT thumbnail FROM posts WHERE id=$id";
        $result = mysqli_query($conn, $query);
        $post = mysqli_fetch_assoc($result);
        $thumbnail_path = $post['thumbnail'];
    }

    // Update the post in the database
    $query = "UPDATE posts SET title=?, category_id=?, tags=?, description=?, content=?, thumbnail=?, is_featured=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sissssii', $title, $category_id, $tags, $description, $content, $thumbnail_path, $is_featured, $id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Post updated successfully.";
        header("Location: ../manage-post.php");
        exit;
    } else {
        $_SESSION['addpost-error'] = "Failed to update the post. Please try again.";
        header("Location: ../edit-post.php?id=$id");
        exit;
    }
} else {
    header("Location: manage-post.php");
    exit;
}
?>
