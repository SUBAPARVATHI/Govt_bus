<?php
// Database Configuration for Admin Panel
$host = 'localhost';
$dbname = 'bus_management';
$username = 'root';  // Change as per your database credentials
$password = '';  // Change as per your database credentials

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}
?>
