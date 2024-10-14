<?php
session_start();
require '../config/database.php'; 

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Retrieve and sanitize form input
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Insert form data into the contacts table
    $sql = "INSERT INTO contacts (name, email, subject, message) 
            VALUES ('$name', '$email', '$subject', '$message')";

    // Execute the query and check if successful
    if (mysqli_query($conn, $sql)) {
        // Set success message and redirect or display on the same page
        $_SESSION['success_message'] = "Your message has been sent successfully!";
        header("Location: ../contact-page.php");
    } else {
        // Set error message and redirect or display on the same page
        $_SESSION['error_message'] = "There was an error sending your message. Please try again.";
        header("Location: ../contact-page.php");
    }

    // Close connection
    mysqli_close($conn);
}