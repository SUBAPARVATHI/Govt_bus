<?php
// Database Configuration
$host = 'localhost';
$dbname = 'bus_management';
$username = 'root';  // Change this if using a different DB user
$password = '';  // Set password if applicable

try {
    // Create PDO Connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Function to sanitize user input
function cleanInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}
?>
