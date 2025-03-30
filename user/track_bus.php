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
    <title>Live Bus Tracking</title>
    <link rel="stylesheet" href="css/user_styles.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initMap" async defer></script>
    <script>
        let map;
        let marker;
        
        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: 20.5937, lng: 78.9629 }, // Default center (India)
                zoom: 5
            });
        }

        function updateBusLocation(busId) {
            fetch(`../api/get_bus_location.php?bus_id=${busId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const { latitude, longitude } = data;
                        const busLocation = new google.maps.LatLng(latitude, longitude);

                        if (!marker) {
                            marker = new google.maps.Marker({
                                position: busLocation,
                                map: map,
                                title: "Bus Location"
                            });
                        } else {
                            marker.setPosition(busLocation);
                        }

                        map.setCenter(busLocation);
                        map.setZoom(14);
                    } else {
                        alert("Failed to fetch bus location.");
                    }
                })
                .catch(error => console.error("Error fetching location:", error));
        }
    </script>
</head>
<body>
    <header>
        <h1>Live Bus Tracking</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="book_seat.php">Book a Seat</a>
            <a href="seat_availability.php">Seat Availability</a>
            <a href="crowd_monitoring.php">Crowd Monitoring</a>
            <a href="feedback.php">Feedback</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <h2>Select a Bus to Track</h2>
        <form>
            <label for="bus_id">Choose Bus:</label>
            <select id="bus_id" onchange="updateBusLocation(this.value)">
                <option value="">-- Select a Bus --</option>
                <?php foreach ($buses as $bus) : ?>
                    <option value="<?= htmlspecialchars($bus['id']) ?>">
                        <?= htmlspecialchars($bus['bus_number']) ?> - <?= htmlspecialchars($bus['route']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <div id="map" style="width: 100%; height: 500px; margin-top: 20px;"></div>
    </main>
</body>
</html>
