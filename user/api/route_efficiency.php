<?php
header("Content-Type: application/json");
require '../config.php';

try {
    // Fetch route efficiency data
    $stmt = $pdo->query("
        SELECT 
            route, 
            COUNT(*) AS trip_count, 
            AVG(travel_time) AS avg_travel_time, 
            SUM(passenger_count) AS total_passengers, 
            SUM(price) AS total_revenue 
        FROM bookings 
        GROUP BY route 
        ORDER BY trip_count DESC
    ");
    
    $routes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(["status" => "success", "routes" => $routes]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
