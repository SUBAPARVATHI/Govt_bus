<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}
require '../config.php';

// Fetch route efficiency data
$stmt = $pdo->query("SELECT route, COUNT(*) AS trip_count, AVG(price) AS avg_fare, SUM(price) AS total_revenue FROM bookings GROUP BY route ORDER BY trip_count DESC");
$routes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Route Analysis</title>
    <link rel="stylesheet" href="css/admin_styles.css">
</head>
<body>
    <h2>Route Analysis</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Route</th>
                <th>Number of Trips</th>
                <th>Average Fare</th>
                <th>Total Revenue</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($routes as $route) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($route['route']); ?></td>
                    <td><?php echo htmlspecialchars($route['trip_count']); ?></td>
                    <td><?php echo htmlspecialchars(number_format($route['avg_fare'], 2)); ?> USD</td>
                    <td><?php echo htmlspecialchars(number_format($route['total_revenue'], 2)); ?> USD</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
