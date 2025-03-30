<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}
require '../config.php';

// Fetch user feedback from the database
$stmt = $pdo->query("SELECT user_id, feedback_text, rating, submitted_at FROM feedback ORDER BY submitted_at DESC");
$feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedback</title>
    <link rel="stylesheet" href="css/admin_styles.css">
</head>
<body>
    <h2>User Feedback</h2>
    <table border="1">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Feedback</th>
                <th>Rating</th>
                <th>Submitted At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($feedbacks as $feedback) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($feedback['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($feedback['feedback_text']); ?></td>
                    <td><?php echo htmlspecialchars($feedback['rating']); ?>/5</td>
                    <td><?php echo htmlspecialchars($feedback['submitted_at']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
