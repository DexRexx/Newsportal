<?php
session_start();
require '../partials/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['category']);
    $description = trim($_POST['description']);

    // Validation
    if (empty($name) || empty($description)) {
        $_SESSION['addcategory-error'] = 'Both fields are required.';
        header('Location: addcategory.php');
        exit();
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO categories (name, description, created_at, updated_at) VALUES (?, ?, NOW(), NOW())");
    $stmt->bind_param("ss", $name, $description);

    if ($stmt->execute()) {
        // Redirect or display success message
        header('Location: ../manage-category.php');
        exit();
    } else {
        // Error handling
        $_SESSION['addcategory-error'] = 'An error occurred. Please try again.';
        header('Location: ../addcategory.php');
        exit();
    }

    $stmt->close();
    $conn->close();
}