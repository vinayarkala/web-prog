<?php
require_once 'config.php';

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Database connection failed."]));
}

$data = json_decode(file_get_contents("php://input"), true);
$serviceType = $data['serviceType'];
$grandTotal = $data['grandTotal'];
$billItems = $data['billItems'];

// Insert order details
$stmt = $conn->prepare("INSERT INTO orders (service_type, total_amount) VALUES (?, ?)");
$stmt->bind_param("sd", $serviceType, $grandTotal);
$stmt->execute();
$orderId = $stmt->insert_id;
$stmt->close();

// Insert bill items
$stmt = $conn->prepare("INSERT INTO order_items (order_id, item_name, price, quantity, total) VALUES (?, ?, ?, ?, ?)");
foreach ($billItems as $item) {
    $stmt->bind_param("isdid", $orderId, $item['item'], $item['price'], $item['qty'], $item['total']);
    $stmt->execute();
}
$stmt->close();

echo json_encode(["success" => true, "message" => "Order saved successfully."]);
$conn->close();
?>
