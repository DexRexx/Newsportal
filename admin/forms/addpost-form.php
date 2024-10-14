<?php
session_start();
require '../partials/header.php'; // Ensure you have a database connection script

// Initialize an error message variable
$error_message = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $title = trim(mysqli_real_escape_string($conn, $_POST['title']));
    $category_id = intval($_POST['category']);
    $tags = trim(mysqli_real_escape_string($conn, $_POST['tags']));
    $description = trim(mysqli_real_escape_string($conn, $_POST['description']));
    $content = trim(mysqli_real_escape_string($conn, $_POST['article']));
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $author_id = $_SESSION['user_id']; // Assuming the author is logged in and their ID is stored in session
    
    // Handle thumbnail upload
    $thumbnail = $_FILES['thumbnail'];
    $thumbnail_name = '';
    if ($thumbnail['error'] === UPLOAD_ERR_OK) {
        $allowed_extensions = ['jpg', 'jpeg', 'png'];
        $file_ext = pathinfo($thumbnail['name'], PATHINFO_EXTENSION);
        
        if (in_array($file_ext, $allowed_extensions)) {
            $thumbnail_name = uniqid('thumb_', true) . '.' . $file_ext;
            $upload_path = '../assets/images/uploads/' . $thumbnail_name;
            
            if (!move_uploaded_file($thumbnail['tmp_name'], $upload_path)) {
                $error_message = 'Failed to upload the thumbnail.';
            }
        } else {
            $error_message = 'Invalid file format for thumbnail. Only jpg, jpeg and png are allowed.';
        }
    } else {
        $error_message = 'Please upload a thumbnail.';
    }
    
    // If there are no errors, insert into database
    if (!$error_message) {
        $created_at = date('Y-m-d H:i:s');
        $updated_at = $created_at;
        
        $sql = "INSERT INTO posts (title, content, author_id, category_id, created_at, updated_at, thumbnail, tags, is_featured, description)
                VALUES ('$title', '$content', '$author_id', '$category_id', '$created_at', '$updated_at', '$thumbnail_name', '$tags', '$is_featured', '$description')";
        
        if (mysqli_query($conn, $sql)) {
            $_SESSION['success_message'] = 'Post added successfully!';
            header('Location: ../manage-post.php');
            exit;
        } else {
            $error_message = 'Failed to add the post: ' . mysqli_error($conn);
        }
    }
    
    $_SESSION['addpost-error'] = $error_message;
    header('Location: ../addpost.php'); // Redirect back to the form page if there's an error
    exit;
} else {
    header('Location: ../addpost.php'); // Redirect back to the form page if accessed directly
    exit;
}