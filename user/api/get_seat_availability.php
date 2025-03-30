<?php
require '../user_config.php'; // Database connection

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['bus_id'])) {
    $bus_id = intval($_GET['bus_id']);

    try {
        // Fetch total seats and booked seats
        $stmt = $pdo->prepare("SELECT total_seats FROM buses WHERE id = ?");
        $stmt->execute([$bus_id]);
        $bus = $stmt->fetch();

        if (!$bus) {
            echo json_encode(["error" => "Bus not found"]);
            exit;
        }

        $stmt = $pdo->prepare("SELECT COUNT(*) AS booked_seats FROM bookings WHERE bus_id = ?");
        $stmt->execute([$bus_id]);
        $bookings = $stmt->fetch();

        $available_seats = $bus['total_seats'] - $bookings['booked_seats'];

        echo json_encode([
            "bus_id" => $bus_id,
            "total_seats" => $bus['total_seats'],
            "booked_seats" => $bookings['booked_seats'],
            "available_seats" => $available_seats
        ]);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>
