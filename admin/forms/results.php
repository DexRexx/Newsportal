<?php
session_start();
require '../partials/header.php'; 

if (isset($_GET['submit']) && isset($_GET['search'])) {
    $search_term = mysqli_real_escape_string($conn, $_GET['search']); // Sanitize input to prevent SQL injection
    
    // Query the database to find matching posts
    $query = "SELECT posts.id, posts.title, posts.content, categories.name AS category_name, posts.created_at, users.username AS publisher 
              FROM posts 
              JOIN categories ON posts.category_id = categories.id 
              JOIN users ON posts.author_id = users.id
              WHERE posts.title LIKE '%$search_term%' OR posts.content LIKE '%$search_term%'
              ORDER BY posts.created_at DESC";
    
    $result = mysqli_query($conn, $query);

    // Check for errors
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
    
    // Store the search results in the session to display them on the results page
    $_SESSION['search_results'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $_SESSION['search_term'] = $search_term;

    // Redirect to the search results page
    header('Location: ../search-page.php');
    exit();
} else {
    // Redirect back if search term is not set
    header('Location: ../index.php');
    exit();
}
?>
