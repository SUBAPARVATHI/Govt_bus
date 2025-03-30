<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

include '../config.php';

// Fetch total buses, bookings, revenue, and user feedback count
$total_buses = $pdo->query("SELECT COUNT(*) FROM buses")->fetchColumn();
$total_bookings = $pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
$total_revenue = $pdo->query("SELECT SUM(fare) FROM bookings")->fetchColumn();
$total_feedback = $pdo->query("SELECT COUNT(*) FROM feedback")->fetchColumn();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin_styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header>
        <h2>Government Bus Management - Admin Dashboard</h2>
        <a href="admin_logout.php">Logout</a>
    </header>
    <div class="dashboard-container">
        <div class="card">
            <h3>Total Buses</h3>
            <p><?php echo $total_buses; ?></p>
        </div>
        <div class="card">
            <h3>Total Bookings</h3>
            <p><?php echo $total_bookings; ?></p>
        </div>
        <div class="card">
            <h3>Total Revenue</h3>
            <p>₹<?php echo number_format($total_revenue, 2); ?></p>
        </div>
        <div class="card">
            <h3>User Feedback</h3>
            <p><?php echo $total_feedback; ?></p>
        </div>
    </div>

    <section class="charts-container">
        <canvas id="revenueChart"></canvas>
    </section>

    <script>
        // Fetch revenue data via API
        fetch('../api/get_revenue_reports.php')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('revenueChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Revenue',
                            data: data.values,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
    </script>
</body>
</html>
