<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}
require '../config.php';

// Fetch live bus locations from API or database
$stmt = $pdo->query("SELECT bus_id, latitude, longitude, last_updated FROM live_tracking");
$buses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Tracking</title>
    <link rel="stylesheet" href="css/admin_styles.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initMap" async defer></script>
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: { lat: 12.9716, lng: 77.5946 } // Default center
            });

            var buses = <?php echo json_encode($buses); ?>;
            buses.forEach(bus => {
                new google.maps.Marker({
                    position: { lat: parseFloat(bus.latitude), lng: parseFloat(bus.longitude) },
                    map: map,
                    title: `Bus ID: ${bus.bus_id}\nLast Updated: ${bus.last_updated}`
                });
            });
        }
    </script>
</head>
<body>
    <h2>Live Bus Tracking</h2>
    <div id="map" style="width: 100%; height: 500px;"></div>
</body>
</html>
