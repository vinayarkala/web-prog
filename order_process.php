<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: login.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: user_dashboard.php");
    exit;
}

if (empty($_SESSION['cart'])) {
    die("Your cart is empty.");
}

require_once 'config.php';

$username = $_SESSION['username'];

/* SAME MENU (IMPORTANT) */
$menu = [
    "🍛 Biryani" => [
        "chicken_biryani" => ["name"=>"Chicken Biryani","price"=>10.99],
        "mutton_biryani" => ["name"=>"Mutton Biryani","price"=>13.99]
    ],
    "🥘 Starters" => [
        "tikka" => ["name"=>"Chicken Tikka","price"=>8.99],
        "samosa" => ["name"=>"Samosa","price"=>2.99]
    ],
    "🥤 Drinks" => [
        "lassi" => ["name"=>"Sweet Lassi","price"=>3.49],
        "chai" => ["name"=>"Masala Chai","price"=>2.49]
    ]
];

$flatMenu = [];
foreach($menu as $category){
    foreach($category as $id => $item){
        $flatMenu[$id] = $item;
    }
}

$sql = "INSERT INTO order_process 
(username, food_item, quantity, unit_price, total_price) 
VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$totalOrderAmount = 0;

foreach ($_SESSION['cart'] as $id => $quantity) {

    if (!isset($flatMenu[$id])) continue;

    $unit_price = $flatMenu[$id]['price'];
    $total_price = $unit_price * $quantity;
    $totalOrderAmount += $total_price;

    $stmt->bind_param(
        "ssidd",
        $username,
        $flatMenu[$id]['name'],
        $quantity,
        $unit_price,
        $total_price
    );

    $stmt->execute();
}

$stmt->close();
unset($_SESSION['cart']);
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
<title>Order Confirmation</title>
<style>
body{font-family:Arial;text-align:center;padding-top:100px;background:#f5f5f5;}
.card{background:white;padding:40px;border-radius:15px;display:inline-block;}
</style>
</head>
<body>

<div class="card">
<h1>✅ Order Placed Successfully!</h1>
<p>Thank you, <?php echo htmlspecialchars($username); ?>.</p>

<a href="user_dashboard.php">Back to Menu</a>
</div>

</body>
</html>
