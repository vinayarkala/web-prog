<?php
require_once 'config.php';

$result = $conn->query("SELECT id, name, price, image_path FROM stock");

$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);

$conn->close();
?>
