<?php
session_start();
require '../partials/header.php'; // Adjust the path if necessary

// Check if a post ID is provided in the URL
if (isset($_GET['id'])) {
    // Sanitize the input
    $post_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Check if the post ID is valid
    if ($post_id && $post_id > 0) {
        // Fetch the post details to get the thumbnail filename
        $query = "SELECT thumbnail FROM posts WHERE id = $post_id";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $post = mysqli_fetch_assoc($result);

            // Check if post was found
            if ($post) {
                // Delete the post from the database
                $query = "DELETE FROM posts WHERE id = $post_id";
                $delete_result = mysqli_query($conn, $query);

                if ($delete_result) {
                    // Delete the associated thumbnail file if it exists
                    $thumbnail_path = '../uploads/' . $post['thumbnail'];
                    if (file_exists($thumbnail_path)) {
                        unlink($thumbnail_path);
                    }

                    // Success message and redirection
                    $_SESSION['deletepost-success'] = "Post and associated files deleted successfully.";
                    header('Location: ../manage-post.php');
                    exit();
                } else {
                    // Store the error message in the session and redirect
                    $_SESSION['deletepost-error'] = "Error deleting post: " . mysqli_error($conn);
                    header('Location: ../manage-post.php');
                    exit();
                }
            } else {
                // Post not found, redirect with error
                $_SESSION['deletepost-error'] = "Post not found.";
                header('Location: ../manage-post.php');
                exit();
            }
        } else {
            // Query failed, redirect with error
            $_SESSION['deletepost-error'] = "Error fetching post: " . mysqli_error($conn);
            header('Location: ../manage-post.php');
            exit();
        }
    } else {
        // Invalid post ID, redirect with error
        $_SESSION['deletepost-error'] = "Invalid post ID.";
        header('Location: ../manage-post.php');
        exit();
    }
} else {
    // No post ID provided, redirect with error
    $_SESSION['deletepost-error'] = "No post ID provided.";
    header('Location: ../manage-post.php');
    exit();
}
