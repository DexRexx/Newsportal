<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "news360"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define ROOT_URL if not already defined
define('ROOT_URL', 'http://localhost/News 360/'); // Adjust to your site’s root URL
?>
