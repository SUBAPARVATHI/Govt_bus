<?php
session_start();
require '../config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Fetch available buses
$buses = $pdo->query("SELECT * FROM buses WHERE status = 'Active'")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Crowd Monitoring</title>
    <link rel="stylesheet" href="css/user_styles.css">
    <script>
        function getCrowdStatus(busId) {
            if (!busId) return;
            
            fetch(`../api/get_crowd_status.php?bus_id=${busId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById("crowd_level").innerText = `Crowd Level: ${data.crowd_status} (${data.passenger_count} passengers)`;
                        document.getElementById("crowd_status_box").style.backgroundColor = data.color;
                    } else {
                        document.getElementById("crowd_level").innerText = "No data available.";
                    }
                })
                .catch(error => console.error("Error fetching crowd data:", error));
        }
    </script>
</head>
<body>
    <header>
        <h1>Bus Crowd Monitoring</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="book_seat.php">Book a Seat</a>
            <a href="seat_availability.php">Seat Availability</a>
            <a href="track_bus.php">Live Tracking</a>
            <a href="feedback.php">Feedback</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <h2>Select a Bus to Check Crowd Level</h2>
        <form>
            <label for="bus_id">Choose Bus:</label>
            <select id="bus_id" onchange="getCrowdStatus(this.value)">
                <option value="">-- Select a Bus --</option>
                <?php foreach ($buses as $bus) : ?>
                    <option value="<?= htmlspecialchars($bus['id']) ?>">
                        <?= htmlspecialchars($bus['bus_number']) ?> - <?= htmlspecialchars($bus['route']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <div id="crowd_status_box" style="margin-top: 20px; padding: 20px; background-color: #f0f0f0; text-align: center; font-size: 18px;">
            <span id="crowd_level">Select a bus to view crowd status.</span>
        </div>
    </main>
</body>
</html>
