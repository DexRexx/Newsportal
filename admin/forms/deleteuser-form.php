<?php
session_start();
require '../partials/header.php'; 

if (isset($_GET['id'])) {
    $user_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Fetch all posts associated with the user
    $query = "SELECT * FROM posts WHERE author_id = $user_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        while ($post = mysqli_fetch_assoc($result)) {
            $thumbnail_name = $post['thumbnail'];
            $thumbnail_path = '../assets/images/uploads/profiles/' . $thumbnail_name;

            // Delete the thumbnail file if it exists
            if ($thumbnail_name && file_exists($thumbnail_path)) {
                if (!unlink($thumbnail_path)) {
                    $_SESSION['deleteuser-error'] = "Error deleting thumbnail file: " . htmlspecialchars($thumbnail_name);
                    header('Location: ../manage-user.php');
                    die();
                }
            }
        }

        // Delete all posts associated with the user
        $delete_posts_query = "DELETE FROM posts WHERE author_id = $user_id";
        if (!mysqli_query($conn, $delete_posts_query)) {
            $_SESSION['deleteuser-error'] = "Error deleting posts: " . mysqli_error($conn);
            header('Location: ../manage-user.php');
            die();
        }
    } else {
        $_SESSION['deleteuser-error'] = "Error fetching user posts: " . mysqli_error($conn);
        header('Location: ../manage-user.php');
        die();
    }

    // Delete the user
    $delete_user_query = "DELETE FROM users WHERE id = $user_id LIMIT 1";
    if (mysqli_query($conn, $delete_user_query)) {
        $_SESSION['deleteuser-success'] = "User and associated posts deleted successfully.";
    } else {
        $_SESSION['deleteuser-error'] = "Error deleting user: " . mysqli_error($conn);
    }
} else {
    $_SESSION['deleteuser-error'] = "No user ID provided.";
}

// Redirect to the admin page
header('Location: ../manage-user.php');
die();
