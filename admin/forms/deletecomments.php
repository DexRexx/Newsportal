<?php
session_start();
require '../config/database.php'; // Adjust the path as needed

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    if ($id) {
        // Prepare the DELETE statement
        $query = "DELETE FROM comments WHERE id = ?";
        $stmt = $conn->prepare($query);
        
        if ($stmt) {
            $stmt->bind_param('i', $id);
            $result = $stmt->execute();
            
            if ($result) {
                // Success
                $_SESSION['delete-success'] = 'Comment successfully deleted.';
            } else {
                // Error
                $_SESSION['delete-error'] = 'Error deleting comment: ' . $stmt->error;
            }

            $stmt->close();
        } else {
            $_SESSION['delete-error'] = 'Error preparing the SQL statement.';
        }
    } else {
        $_SESSION['delete-error'] = 'Invalid comment ID.';
    }
} else {
    $_SESSION['delete-error'] = 'No comment ID provided.';
}

// Redirect back to the comments page
header('Location: ../comments.php');
exit();
?>
