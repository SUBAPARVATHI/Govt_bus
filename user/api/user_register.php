<?php
require '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['name'], $data['email'], $data['password'])) {
        $hashed_password = password_hash($data['password'], PASSWORD_BCRYPT);

        try {
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$data['name'], $data['email'], $hashed_password]);

            echo json_encode(["success" => true, "message" => "Registration successful!"]);
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Unique constraint violation
                echo json_encode(["success" => false, "message" => "Email already exists."]);
            } else {
                echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
            }
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid input data."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
