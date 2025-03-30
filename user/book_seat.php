<?php
session_start();
require '../config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $bus_id = $_POST['bus_id'];
    $seat_number = $_POST['seat_number'];

    // Check seat availability
    $stmt = $pdo->prepare("SELECT * FROM bookings WHERE bus_id = ? AND seat_number = ?");
    $stmt->execute([$bus_id, $seat_number]);
    if ($stmt->rowCount() > 0) {
        $message = "Seat already booked. Please choose another seat.";
    } else {
        // Book the seat
        $stmt = $pdo->prepare("INSERT INTO bookings (user_id, bus_id, seat_number, status) VALUES (?, ?, ?, 'Booked')");
        if ($stmt->execute([$user_id, $bus_id, $seat_number])) {
            $message = "Seat successfully booked!";
        } else {
            $message = "Booking failed. Please try again.";
        }
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
    <title>Book a Seat</title>
    <link rel="stylesheet" href="css/user_styles.css">
</head>
<body>
    <header>
        <h1>Book a Seat</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="track_bus.php">Live Tracking</a>
            <a href="crowd_monitoring.php">Crowd Monitoring</a>
            <a href="feedback.php">Feedback</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <h2>Select Your Bus and Seat</h2>
        <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>

        <form action="book_seat.php" method="POST">
            <label for="bus_id">Select Bus:</label>
            <select name="bus_id" id="bus_id" required>
                <option value="">-- Select a Bus --</option>
                <?php foreach ($buses as $bus) : ?>
                    <option value="<?= htmlspecialchars($bus['id']) ?>">
                        <?= htmlspecialchars($bus['bus_number']) ?> - <?= htmlspecialchars($bus['route']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="seat_number">Select Seat Number:</label>
            <input type="number" name="seat_number" id="seat_number" min="1" max="50" required>

            <button type="submit">Book Seat</button>
        </form>
    </main>
</body>
</html>
