<?php
session_start();
require '../config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$message = "";

// Fetch available buses
$buses = $pdo->query("SELECT * FROM buses WHERE status = 'Active'")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bus_id = $_POST['bus_id'];

    // Fetch total seats and booked seats
    $stmt = $pdo->prepare("SELECT total_seats FROM buses WHERE id = ?");
    $stmt->execute([$bus_id]);
    $bus = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($bus) {
        $total_seats = $bus['total_seats'];

        // Get booked seats
        $stmt = $pdo->prepare("SELECT seat_number FROM bookings WHERE bus_id = ?");
        $stmt->execute([$bus_id]);
        $booked_seats = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Calculate available seats
        $available_seats = array_diff(range(1, $total_seats), $booked_seats);
    } else {
        $message = "Invalid bus selection.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Seat Availability</title>
    <link rel="stylesheet" href="css/user_styles.css">
</head>
<body>
    <header>
        <h1>Check Seat Availability</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="book_seat.php">Book a Seat</a>
            <a href="track_bus.php">Live Tracking</a>
            <a href="crowd_monitoring.php">Crowd Monitoring</a>
            <a href="feedback.php">Feedback</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <h2>Select Bus to Check Available Seats</h2>
        <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>

        <form action="seat_availability.php" method="POST">
            <label for="bus_id">Select Bus:</label>
            <select name="bus_id" id="bus_id" required>
                <option value="">-- Select a Bus --</option>
                <?php foreach ($buses as $bus) : ?>
                    <option value="<?= htmlspecialchars($bus['id']) ?>">
                        <?= htmlspecialchars($bus['bus_number']) ?> - <?= htmlspecialchars($bus['route']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Check Availability</button>
        </form>

        <?php if (isset($available_seats)) : ?>
            <h3>Available Seats:</h3>
            <?php if (!empty($available_seats)) : ?>
                <p><?= implode(', ', $available_seats); ?></p>
            <?php else : ?>
                <p>No available seats for this bus.</p>
            <?php endif; ?>
        <?php endif; ?>
    </main>
</body>
</html>
