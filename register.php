<?php
session_start();

// Database configuration
require_once 'config.php';

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get and sanitize input
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'user';

    // Basic validation
    if (empty($username) || empty($password) || empty($role)) {
        die("All fields are required.");
    }

    // Check if username already exists
    $checkSql = "SELECT id FROM users WHERE username = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        die("Username already exists. Please choose another.");
    }
    $checkStmt->close();

    // Hash password securely
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert user
    $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sss", $username, $hashedPassword, $role);

    if ($stmt->execute()) {
        echo "<script>
                alert('Registration successful!');
                window.location.href = 'login.html';
              </script>";
    } else {
        echo "Registration failed: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
