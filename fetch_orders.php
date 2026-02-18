<?php
header('Content-Type: application/json');

require_once 'config.php';

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed']));
}

// Query to count orders
$sql = "SELECT COUNT(*) as total_orders FROM orders";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['total_orders' => $row['total_orders']]);
} else {
    echo json_encode(['total_orders' => 0]);
}

$conn->close();
?>
