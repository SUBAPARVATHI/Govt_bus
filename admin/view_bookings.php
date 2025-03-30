<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}
require '../config.php';

// Fetch all bookings
$stmt = $pdo->query("SELECT * FROM bookings ORDER BY booking_date DESC");
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings</title>
    <link rel="stylesheet" href="css/admin_styles.css">
</head>
<body>
    <h2>View Bookings</h2>
    <table border="1">
        <tr>
            <th>Booking ID</th>
            <th>User</th>
            <th>Bus</th>
            <th>Seat Number</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
        <?php foreach ($bookings as $booking): ?>
        <tr>
            <td><?= htmlspecialchars($booking['id']) ?></td>
            <td><?= htmlspecialchars($booking['user_id']) ?></td>
            <td><?= htmlspecialchars($booking['bus_id']) ?></td>
            <td><?= htmlspecialchars($booking['seat_number']) ?></td>
            <td><?= htmlspecialchars($booking['booking_date']) ?></td>
            <td><?= htmlspecialchars($booking['status']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
