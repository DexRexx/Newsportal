<?php
session_start();
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "news360"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $user_id = filter_var($_POST['user_id'], FILTER_SANITIZE_NUMBER_INT);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $userrole = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);

    // Validate the input
    if (empty($username)) {
        $_SESSION['edituser-error'] = "Username cannot be empty.";
        header("Location: ../edit-user.php?id=$user_id");
        die();
    }

    // Update user in the database
    $stmt = $conn->prepare("UPDATE users SET username = ?, is_admin = ? WHERE id = ?");
    $stmt->bind_param("sii", $username, $userrole, $user_id);

    if ($stmt->execute()) {
        $_SESSION['edituser-success'] = "User updated successfully.";
        header("Location: ../manage-user.php");
    } else {
        $_SESSION['edituser-error'] = "Failed to update user.";
        header("Location: ../edit-user.php?id=$user_id");
    }

    $stmt->close();
}

$conn->close();
?>
