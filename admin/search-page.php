<?php
session_start();
require 'partials/header.php';

// Pagination settings
$limit = 10;  // Number of posts per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;  // Get the current page number
$offset = ($page - 1) * $limit;  // Offset for SQL query

// Check if the search query exists
if (isset($_GET['search'])) {
    $search_term = mysqli_real_escape_string($conn, $_GET['search']); // Sanitize input to prevent SQL injection
    
    // Query the database to find matching posts with pagination
    $query = "SELECT posts.id, posts.title, posts.content, categories.name AS category_name, posts.created_at, users.username AS publisher 
              FROM posts 
              JOIN categories ON posts.category_id = categories.id 
              JOIN users ON posts.author_id = users.id
              WHERE posts.title LIKE '%$search_term%' OR posts.content LIKE '%$search_term%'
              ORDER BY posts.created_at DESC
              LIMIT $limit OFFSET $offset";
    
    // Execute the query
    $posts_result = mysqli_query($conn, $query);
    
    // Check for query errors
    if (!$posts_result) {
        // Display an error message if the query fails
        echo "Error: " . mysqli_error($conn);
        exit;
    }
    
    // Get total number of results for pagination
    $count_query = "SELECT COUNT(*) AS total FROM posts 
                    WHERE posts.title LIKE '%$search_term%' OR posts.content LIKE '%$search_term%'";
    $count_result = mysqli_query($conn, $count_query);
    $total_posts = mysqli_fetch_assoc($count_result)['total'];
    $total_pages = ceil($total_posts / $limit);  // Calculate total number of pages
    
    // Check if there are results
    if (mysqli_num_rows($posts_result) > 0) {
        // Get current user's admin status
        $is_admin = isset($_SESSION['is_admin']) ? $_SESSION['is_admin'] : 0;
        
        echo '<div class="edit-container">';
        echo '<a href="add-post.php"><button class="add-btn">Add <i class="fas fa-plus-circle"></i></button></a>';
        echo '<table class="category-table">';
        echo '<thead style="font-size: 18px; font-family: Teko, sans-serif">';
        echo '<tr>';
        echo '<th>Title</th>';
        echo '<th>Category</th>';
        echo '<th>Upload Date</th>';
        echo '<th>Publisher</th>';
        
        if ($is_admin == 1) {
            echo '<th>Action</th>';
        }
        
        echo '</tr>';
        echo '</thead>';
        echo '<tbody style="font-size: 15px; font-family: Oswald, sans-serif">';
        
        // Display each post in the search results
        while ($post = mysqli_fetch_assoc($posts_result)) {
            echo '<tr style="border-bottom: 1px solid #222222c0">';
            echo '<td>' . htmlspecialchars($post['title']) . '</td>';
            echo '<td>' . htmlspecialchars($post['category_name']) . '</td>';
            echo '<td>' . date("d M, Y", strtotime($post['created_at'])) . '</td>';
            echo '<td>' . htmlspecialchars($post['publisher']) . '</td>';
            
            if ($is_admin == 1) {
                echo '<td>';
                echo '<a href="edit-post.php?id=' . $post['id'] . '" class="edit-icon"><i class="fas fa-edit"></i></a>';
                echo '<a href="forms/deletepost-form.php?id=' . $post['id'] . '" class="delete-icon"><i class="fas fa-trash"></i></a>';
                echo '</td>';
            }
            
            echo '</tr>';
        }
        
        echo '</tbody>';
        echo '</table>';
        
        // Pagination controls
        echo '<div class="pagination">';
        if ($page > 1) {
            echo '<a href="?search=' . urlencode($search_term) . '&page=' . ($page - 1) . '" class="pagination-link">&laquo; Previous</a>';
        }

        for ($i = 1; $i <= $total_pages; $i++) {
            echo '<a href="?search=' . urlencode($search_term) . '&page=' . $i . '" class="pagination-link ' . ($i == $page ? 'active' : '') . '">' . $i . '</a>';
        }

        if ($page < $total_pages) {
            echo '<a href="?search=' . urlencode($search_term) . '&page=' . ($page + 1) . '" class="pagination-link">Next &raquo;</a>';
        }
        echo '</div>';
        
        echo '</div>';
    } else {
        // If no results found
        echo '<div class="container">';
        echo "<h3>No results found for: " . htmlspecialchars($search_term) . "</h3>";
        echo '</div>';
    }
} else {
    // If no search term provided
    echo '<div class="container">';
    echo "<h3>No search query provided.</h3>";
    echo '</div>';
}

require 'partials/footer.php';
?>
