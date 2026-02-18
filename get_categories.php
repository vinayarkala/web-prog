<?php
require_once 'config.php';

if ($conn->connect_error) {
    die(json_encode([]));
}

$sql = "SELECT DISTINCT category FROM stock";
$result = $conn->query($sql);

$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row['category'];
}

echo json_encode($categories);

$conn->close();
?>
