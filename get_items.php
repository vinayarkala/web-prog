<?php
require_once 'config.php';

if ($conn->connect_error) {
    die(json_encode([]));
}

$category = $_GET['category'] ?? '';

if ($category) {
    $stmt = $conn->prepare("SELECT * FROM stock WHERE category = ?");
    $stmt->bind_param("s", $category);
} else {
    $stmt = $conn->prepare("SELECT * FROM stock");
}

$stmt->execute();
$result = $stmt->get_result();

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

echo json_encode($items);

$stmt->close();
$conn->close();
?>
