<?php
session_start();
require '../config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Government Bus Management - Home</title>
    <link rel="stylesheet" href="css/user_styles.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initMap" async defer></script>
</head>
<body>
    <header>
        <h1>Government Bus Management System</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="book_seat.php">Book a Seat</a>
            <a href="track_bus.php">Live Tracking</a>
            <a href="crowd_monitoring.php">Crowd Monitoring</a>
            <a href="feedback.php">Feedback</a>
            <?php if (isset($_SESSION['user'])): ?>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <section id="search-buses">
            <h2>Find Your Bus</h2>
            <form action="seat_availability.php" method="GET">
                <label for="route">Select Route:</label>
                <select name="route" id="route">
                    <?php
                    $stmt = $pdo->query("SELECT DISTINCT route FROM buses WHERE status='Active'");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . htmlspecialchars($row['route']) . "'>" . htmlspecialchars($row['route']) . "</option>";
                    }
                    ?>
                </select>
                <button type="submit">Check Availability</button>
            </form>
        </section>

        <section id="live-tracking">
            <h2>Live Bus Tracking</h2>
            <div id="map" style="width: 100%; height: 400px;"></div>
        </section>

        <section id="crowd-monitoring">
            <h2>Live Crowd Monitoring</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>Bus Number</th>
                        <th>Current Passengers</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="crowd-data">
                    <!-- Data will be filled via JavaScript -->
                </tbody>
            </table>
        </section>
    </main>

    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 6,
                center: {lat: 20.5937, lng: 78.9629}
            });

            fetch('../api/get_bus_location.php')
                .then(response => response.json())
                .then(data => {
                    data.forEach(bus => {
                        new google.maps.Marker({
                            position: {lat: parseFloat(bus.latitude), lng: parseFloat(bus.longitude)},
                            map: map,
                            title: bus.bus_number
                        });
                    });
                });
        }

        function loadCrowdMonitoring() {
            fetch('../api/get_crowd_status.php')
                .then(response => response.json())
                .then(data => {
                    let tableBody = document.getElementById("crowd-data");
                    tableBody.innerHTML = "";
                    data.forEach(bus => {
                        let status = bus.passengers_count > 40 ? 'Crowded' : 'Normal';
                        let row = `<tr>
                            <td>${bus.bus_number}</td>
                            <td>${bus.passengers_count}</td>
                            <td>${status}</td>
                        </tr>`;
                        tableBody.innerHTML += row;
                    });
                });
        }

        document.addEventListener("DOMContentLoaded", function () {
            loadCrowdMonitoring();
        });
    </script>
</body>
</html>
