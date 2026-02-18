<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once "config.php";


/* =========================
   AUTH CHECK
========================= */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: login.html");
    exit;
}

if (empty($_SESSION['cart'])) {
    header("Location: user_dashboard.php");
    exit;
}

$user_id = $_SESSION['user_id']; // make sure this exists in login
$cart = $_SESSION['cart'];

/* =========================
   MENU DATA (same as dashboard)
========================= */
$menu = [
    "biryani" => ["name"=>"Chicken Biryani","price"=>10.99],
    "tikka"   => ["name"=>"Chicken Tikka","price"=>8.99],
    "samosa"  => ["name"=>"Samosa","price"=>2.99],
    "lassi"   => ["name"=>"Sweet Lassi","price"=>3.49],
];

/* =========================
   CALCULATE TOTAL
========================= */
$total = 0;

foreach ($cart as $id => $qty) {
    $total += $menu[$id]['price'] * $qty;
}

/* =========================
   INSERT INTO ORDERS
========================= */
$stmt = $conn->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
$stmt->bind_param("id", $user_id, $total);
$stmt->execute();

$order_id = $stmt->insert_id;

/* =========================
   INSERT ORDER ITEMS
========================= */
$itemStmt = $conn->prepare("INSERT INTO order_items (order_id, item_name, price, quantity) VALUES (?, ?, ?, ?)");

foreach ($cart as $id => $qty) {
    $name = $menu[$id]['name'];
    $price = $menu[$id]['price'];

    $itemStmt->bind_param("isdi", $order_id, $name, $price, $qty);
    $itemStmt->execute();
}

/* =========================
   CLEAR CART
========================= */
unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html>
<head>
<title>Order Successful</title>
<link rel="stylesheet" href="user.css">
</head>
<body class="success-page">

<div class="success-box">
    <h1>🎉 Order Placed Successfully!</h1>
    <p>Your order ID: <strong>#<?php echo $order_id; ?></strong></p>
    <a href="user_dashboard.php" class="btn-primary">Back to Dashboard</a>
</div>

</body>
</html>
