<?php
require '../../config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bus_id = $_POST['bus_id'] ?? null;
    $status = $_POST['status'] ?? null;

    if (!$bus_id || !$status) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields.']);
        exit;
    }

    try {
        // Update bus status in the database
        $stmt = $pdo->prepare("UPDATE buses SET status = ? WHERE id = ?");
        $stmt->execute([$status, $bus_id]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Bus status updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No changes made or invalid bus ID.']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
