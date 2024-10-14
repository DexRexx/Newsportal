<?php
session_start();
require '../partials/header.php'; 

if (isset($_GET['id'])) {
    $category_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // ID for the "undefined" category
    $undefined_category_id = 7; // Ensure you have a category with ID 0 or set a valid ID for "undefined"

    // Move all posts from the selected category to "undefined" category
    $update_posts_query = "UPDATE posts SET category_id = $undefined_category_id WHERE category_id = $category_id";
    if (mysqli_query($conn, $update_posts_query)) {
        // Delete the selected category
        $delete_category_query = "DELETE FROM categories WHERE id = $category_id LIMIT 1";
        if (mysqli_query($conn, $delete_category_query)) {
            $_SESSION['delete-success'] = "Category deleted successfully, and posts have been moved to 'undefined'.";
        } else {
            $_SESSION['delete-error'] = "Error deleting category: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['delete-error'] = "Error updating posts: " . mysqli_error($conn);
    }
} else {
    $_SESSION['delete-error'] = "No category ID provided.";
}

// Redirect to the manage categories page
header('Location: ../manage-category.php');
die();
