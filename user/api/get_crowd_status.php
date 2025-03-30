<?php
require '../config.php';

if (isset($_GET['bus_id'])) {
    $bus_id = $_GET['bus_id'];

    $stmt = $pdo->prepare("SELECT passenger_count FROM bus_crowd WHERE bus_id = ?");
    $stmt->execute([$bus_id]);
    $crowd = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($crowd) {
        $passenger_count = (int)$crowd['passenger_count'];

        if ($passenger_count <= 10) {
            $status = "Low";
            $color = "#28a745"; // Green
        } elseif ($passenger_count <= 30) {
            $status = "Moderate";
            $color = "#ffc107"; // Yellow
        } else {
            $status = "High";
            $color = "#dc3545"; // Red
        }

        echo json_encode([
            "success" => true,
            "passenger_count" => $passenger_count,
            "crowd_status" => $status,
            "color" => $color
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "No crowd data available."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>
