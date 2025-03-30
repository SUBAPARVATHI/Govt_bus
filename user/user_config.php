<?php
$host = 'localhost';       // Database Host
$dbname = 'bus_management'; // Database Name
$username = 'root';        // Database Username
$password = '';            // Database Password (Change if needed)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
