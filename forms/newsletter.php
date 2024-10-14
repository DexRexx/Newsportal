<?php
session_start();
require '../config/database.php'; 

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and sanitize the email input
    $email = trim($_POST['email']);
    
    if (empty($email)) {
        // Redirect with error message if email is empty
        header("Location: ../index.php?error=Email is required");
        exit();
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Redirect with error message if email is invalid
        header("Location: ../index.php?error=Invalid email format");
        exit();
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO newsletter (email) VALUES (?)");
    $stmt->bind_param("s", $email);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect with success message
        header("Location: ../index.php?success=Subscription successful");
    } else {
        // Redirect with error message if query fails
        header("Location: ../index.php?error=Subscription failed, please try again");
    }

    // Close the statement and connection
    $stmt->close();
}

$conn->close();
?>
