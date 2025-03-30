<?php
require '../../config.php';

header('Content-Type: application/json');

try {
    // Fetch all booking details
    $stmt = $pdo->query("
        SELECT b.id, b.user_id, u.name AS passenger_name, u.email, b.route, b.seat_number, 
               b.price, b.booking_date, b.status 
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        ORDER BY b.booking_date DESC
    ");

    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'data' => $bookings
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch booking details: ' . $e->getMessage()
    ]);
}
?>
