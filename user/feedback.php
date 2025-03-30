<?php
session_start();
require '../config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $bus_id = $_POST['bus_id'];
    $rating = $_POST['rating'];
    $comments = trim($_POST['comments']);

    if (!empty($bus_id) && !empty($rating)) {
        $stmt = $pdo->prepare("INSERT INTO feedback (user_id, bus_id, rating, comments) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$user_id, $bus_id, $rating, $comments])) {
            $success_message = "Thank you for your feedback!";
        } else {
            $error_message = "Failed to submit feedback. Try again.";
        }
    } else {
        $error_message = "Please select a bus and provide a rating.";
    }
}

// Fetch available buses
$buses = $pdo->query("SELECT * FROM buses WHERE status = 'Active'")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link rel="stylesheet" href="css/user_styles.css">
</head>
<body>
    <header>
        <h1>Bus Feedback</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="book_seat.php">Book a Seat</a>
            <a href="seat_availability.php">Seat Availability</a>
            <a href="track_bus.php">Live Tracking</a>
            <a href="crowd_monitoring.php">Crowd Monitoring</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <h2>Submit Your Feedback</h2>
        <?php if (isset($success_message)) : ?>
            <p style="color: green;"><?= htmlspecialchars($success_message) ?></p>
        <?php elseif (isset($error_message)) : ?>
            <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="bus_id">Bus:</label>
            <select name="bus_id" required>
                <option value="">-- Select Bus --</option>
                <?php foreach ($buses as $bus) : ?>
                    <option value="<?= htmlspecialchars($bus['id']) ?>">
                        <?= htmlspecialchars($bus['bus_number']) ?> - <?= htmlspecialchars($bus['route']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="rating">Rating:</label>
            <select name="rating" required>
                <option value="">-- Select Rating --</option>
                <option value="1">1 - Poor</option>
                <option value="2">2 - Fair</option>
                <option value="3">3 - Good</option>
                <option value="4">4 - Very Good</option>
                <option value="5">5 - Excellent</option>
            </select>

            <label for="comments">Comments (Optional):</label>
            <textarea name="comments" rows="4" placeholder="Share your experience..."></textarea>

            <button type="submit">Submit Feedback</button>
        </form>
    </main>
</body>
</html>
