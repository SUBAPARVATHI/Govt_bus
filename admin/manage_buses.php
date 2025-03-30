<?php
session_start();
include '../config.php';
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Add Bus
if (isset($_POST['add_bus'])) {
    $bus_number = $_POST['bus_number'];
    $route = $_POST['route'];
    $capacity = $_POST['capacity'];
    
    $query = $pdo->prepare("INSERT INTO buses (bus_number, route, capacity) VALUES (?, ?, ?)");
    $query->execute([$bus_number, $route, $capacity]);
}

// Delete Bus
if (isset($_GET['delete'])) {
    $bus_id = $_GET['delete'];
    $query = $pdo->prepare("DELETE FROM buses WHERE id = ?");
    $query->execute([$bus_id]);
    header("Location: manage_buses.php");
}

// Fetch Buses
$query = $pdo->query("SELECT * FROM buses");
$buses = $query->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Buses</title>
    <link rel="stylesheet" href="css/admin_styles.css">
</head>
<body>
    <h2>Manage Buses</h2>
    <form method="post">
        <input type="text" name="bus_number" placeholder="Bus Number" required>
        <input type="text" name="route" placeholder="Route" required>
        <input type="number" name="capacity" placeholder="Capacity" required>
        <button type="submit" name="add_bus">Add Bus</button>
    </form>

    <h3>Bus List</h3>
    <table border="1">
        <tr>
            <th>Bus Number</th>
            <th>Route</th>
            <th>Capacity</th>
            <th>Action</th>
        </tr>
        <?php foreach ($buses as $bus): ?>
            <tr>
                <td><?= $bus['bus_number'] ?></td>
                <td><?= $bus['route'] ?></td>
                <td><?= $bus['capacity'] ?></td>
                <td>
                    <a href="?delete=<?= $bus['id'] ?>" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
