<?php
session_start(); // Start the session to store messages
require '../config/database.php'; // Adjust the path to your config

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize form inputs
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
    $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
    $post_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT); // Get post_id from the URL

    // Check if post_id is valid
    if ($post_id && $name && $email && $comment) {
        // Insert the comment into the database
        $query = "INSERT INTO comments (name, email, subject, comment_text, post_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssssi', $name, $email, $subject, $comment, $post_id);

        if ($stmt->execute()) {
            // Success: Store a success message in the session and redirect back to the post
            $_SESSION['message'] = "Comment posted successfully!";
            $_SESSION['message_type'] = "success";
        } else {
            // Error: Store an error message in the session and redirect back
            $_SESSION['message'] = "Failed to post comment. Please try again.";
            $_SESSION['message_type'] = "danger";
        }
        $stmt->close();
    } else {
        // Validation failed: Store an error message
        $_SESSION['message'] = "All fields are required. Please fill out the form.";
        $_SESSION['message_type'] = "danger";
    }

    // Redirect back to the post page
    header("Location: ../single-post.php?id=$post_id");
    exit();
} else {
    // If someone tries to access the page directly, redirect to home
    header('Location: ../index.php');
    exit();
}
?>
