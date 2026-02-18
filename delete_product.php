<?php
require_once 'config.php';

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? 0;

$stmt = $conn->prepare("DELETE FROM stock WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Product deleted successfully!";
} else {
    echo "Error deleting product.";
}

$stmt->close();
$conn->close();
?>
