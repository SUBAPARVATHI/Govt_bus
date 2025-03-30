<?php
require '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['user_id'], $data['bus_id'], $data['rating'])) {
        $stmt = $pdo->prepare("INSERT INTO feedback (user_id, bus_id, rating, comments) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$data['user_id'], $data['bus_id'], $data['rating'], $data['comments'] ?? ''])) {
            echo json_encode(["success" => true, "message" => "Feedback submitted successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to submit feedback."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid input data."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
