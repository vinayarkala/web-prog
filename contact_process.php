<?php
// Start session (optional but good practice)
session_start();

// Database credentials
require_once 'config.php';

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize inputs
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Basic validation
    if (empty($name) || empty($email) || empty($message)) {
        die("All fields are required.");
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Prepare SQL statement
    $sql = "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sss", $name, $email, $message);

    // Execute and redirect
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();

        // IMPORTANT: No echo before header
        header("Location: thank_you.html");
        exit();
    } else {
        echo "Error saving message: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
