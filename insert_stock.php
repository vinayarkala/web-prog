<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

require_once 'config.php';   // uses your DB connection

// Validate POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Get form values
$category = trim($_POST['category'] ?? '');
$name     = trim($_POST['name'] ?? '');
$price    = $_POST['price'] ?? '';
$image    = $_FILES['image'] ?? null;

// Basic validation
if (!$category || !$name || !$price || !$image) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

// Validate price
if (!is_numeric($price)) {
    echo json_encode(['success' => false, 'message' => 'Invalid price value.']);
    exit;
}

// Check upload error
if ($image['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Image upload error: ' . $image['error']]);
    exit;
}

// Allowed file types
$allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
if (!in_array($image['type'], $allowedTypes)) {
    echo json_encode(['success' => false, 'message' => 'Only JPG, PNG, WEBP allowed.']);
    exit;
}

// Ensure uploads folder exists
$uploadsDir = __DIR__ . '/uploads/';
if (!is_dir($uploadsDir)) {
    mkdir($uploadsDir, 0777, true);
}

// Rename file to avoid conflicts
$fileName = time() . '_' . preg_replace("/[^a-zA-Z0-9\._-]/", "", $image['name']);
$imagePath = $uploadsDir . $fileName;

// Move file
if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
    echo json_encode(['success' => false, 'message' => 'Failed to upload image.']);
    exit;
}

// Store relative path in DB
$imageRelativePath = 'uploads/' . $fileName;

// Insert into database
$stmt = $conn->prepare("INSERT INTO stock (category, name, price, image_path) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssds", $category, $name, $price, $imageRelativePath);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Product added successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
