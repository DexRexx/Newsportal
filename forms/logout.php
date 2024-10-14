<?php
session_start(); // Start the session

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect the user to the homepage or login page after logout
header("Location: ../index.php");
exit();
?>
