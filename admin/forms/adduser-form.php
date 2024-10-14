<?php
session_start();
require '../partials/header.php'; // Include your database connection

if (isset($_POST['submit'])) {
    // Get form data and sanitize
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $createpassword = trim($_POST['create_password']);
    $confirmpassword = trim($_POST['confirmpassword']);
    $avatar = $_FILES['avatar'];

    // Store form data in session to repopulate fields in case of an error
    $_SESSION['adduser-data'] = $_POST;

    // Validation flags
    $errors = [];

    // Check if required fields are empty
    if (empty($firstname) || empty($lastname) || empty($username) || empty($email) || empty($createpassword) || empty($confirmpassword)) {
        $errors[] = "All fields are required.";
    }

    // Check if username is within the maximum length
    if (strlen($username) > 15) {
        $errors[] = "Username must not exceed 15 characters.";
    }

    // Check if passwords match
    if ($createpassword !== $confirmpassword) {
        $errors[] = "Passwords do not match.";
    }

    // Validate password length (minimum 8 characters)
    if (strlen($createpassword) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    // Check if the username already exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $errors[] = "Username already exists.";
    }
    $stmt->close();

    // Check if the email already exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $errors[] = "Email already exists.";
    }
    $stmt->close();

    // Validate uploaded image if any
    if ($avatar['name']) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($avatar['type'], $allowed_types)) {
            $errors[] = "Only JPG, PNG, and GIF files are allowed.";
        }
        if ($avatar['size'] > 2 * 1024 * 1024) { // 2MB limit
            $errors[] = "File size must be less than 2MB.";
        }
    }

    // If there are no errors, proceed with the registration
    if (empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($createpassword, PASSWORD_BCRYPT);

        // Handle the file upload if there's a profile picture
        $avatar_name = null;
        if ($avatar['name']) {
            $avatar_name = time() . '-' . basename($avatar['name']);
            $upload_dir = '../assets/images/uploads/profiles/';
            if (!move_uploaded_file($avatar['tmp_name'], $upload_dir . $avatar_name)) {
                $errors[] = "Failed to upload the file.";
            }
        }

        // Insert the user into the database
        if (empty($errors)) {
            $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, username, email, password, avatar) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $firstname, $lastname, $username, $email, $hashed_password, $avatar_name);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // Registration successful
                unset($_SESSION['adduser-data']); // Clear the form data session
                header('Location: ../manage-user.php'); // Redirect to manage users page
                exit();
            } else {
                $errors[] = "Something went wrong. Please try again.";
            }
            $stmt->close();
        }
    }

    // If there were errors, set the error message in session and redirect back
    if (!empty($errors)) {
        $_SESSION['adduser-error'] = implode('<br>', $errors);
        header('Location: ../add-user.php'); // Redirect back to the add user page
        exit();
    }
}
?>
