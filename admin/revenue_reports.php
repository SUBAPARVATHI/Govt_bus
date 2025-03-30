<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}
require '../config.php';

// Fetch revenue and ticket sales data
$stmt = $pdo->query("SELECT route, COUNT(*) AS tickets_sold, SUM(price) AS total_revenue FROM bookings GROUP BY route ORDER BY total_revenue DESC");
$revenues = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenue Reports</title>
    <link rel="stylesheet" href="css/admin_styles.css">
</head>
<body>
    <h2>Revenue Reports</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Route</th>
                <th>Tickets Sold</th>
                <th>Total Revenue</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($revenues as $revenue) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($revenue['route']); ?></td>
                    <td><?php echo htmlspecialchars($revenue['tickets_sold']); ?></td>
                    <td><?php echo htmlspecialchars($revenue['total_revenue']); ?> USD</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
