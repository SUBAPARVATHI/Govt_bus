<?php
require '../../config.php';

header('Content-Type: application/json');

try {
    // Query to fetch revenue details
    $stmt = $pdo->query("
        SELECT route, COUNT(*) AS total_trips, 
               SUM(price) AS total_revenue, 
               AVG(price) AS avg_fare 
        FROM bookings 
        GROUP BY route 
        ORDER BY total_revenue DESC
    ");

    $revenueData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'data' => $revenueData
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch revenue reports: ' . $e->getMessage()
    ]);
}
?>
