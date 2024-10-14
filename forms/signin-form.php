<?php
session_start();
require '../config/database.php';

if (isset($_POST['submit'])) {
    $username_email = trim($_POST['username_email']);
    $password = trim($_POST['password']);

    // Validate input fields
    if (empty($username_email) || empty($password)) {
        $_SESSION['signin'] = 'Both fields are required.';
        header('Location: ../signin-page.php');
        exit();
    }

    // Prepare and execute the query to fetch user data
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username_email, $username_email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    // Check if user exists and password is correct
    if ($user && password_verify($password, $user['password'])) {
        // Set user session and redirect to the dashboard
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: ../admin/index.php');
        exit();
    } else {
        $_SESSION['signin'] = 'Invalid username/email or password.';
        header('Location: ../signin-page.php');
        exit();
    }
}
?>
