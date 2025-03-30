<?php
require '../../config.php';

header('Content-Type: application/json');

try {
    // Fetch active buses with their last known location
    $stmt = $pdo->query("SELECT bus_id, route, latitude, longitude, last_updated FROM buses WHERE status='active'");
    $buses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'data' => $buses
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to retrieve bus locations: ' . $e->getMessage()
    ]);
}
?>
