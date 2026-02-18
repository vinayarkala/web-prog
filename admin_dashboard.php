<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit;
}

/* FETCH ALL ORDERS */
$sql = "SELECT * FROM order_process ORDER BY order_date DESC";
$result = $conn->query($sql);

$totalRevenue = 0;
$totalOrders = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body{
    background:linear-gradient(135deg,#667eea,#764ba2);
    display:flex;
}

/* SIDEBAR */
.sidebar{
    width:250px;
    background:#1e1e2f;
    min-height:100vh;
    padding:20px;
    color:white;
}

.sidebar h2{
    text-align:center;
    margin-bottom:30px;
    letter-spacing:1px;
}

.sidebar a{
    display:block;
    padding:12px;
    margin:10px 0;
    color:white;
    text-decoration:none;
    border-radius:6px;
    transition:0.3s;
}

.sidebar a:hover{
    background:#667eea;
}

/* MAIN CONTENT */
.main{
    flex:1;
    padding:30px;
    background:#f4f6f9;
    min-height:100vh;
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.header h1{
    color:#333;
}

/* CARDS */
.cards{
    display:flex;
    gap:20px;
    margin-bottom:30px;
}

.card{
    flex:1;
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
}

.card h3{
    margin-bottom:10px;
    color:#555;
}

.card p{
    font-size:22px;
    font-weight:bold;
    color:#333;
}

/* TABLE */
.table-container{
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
}

table{
    width:100%;
    border-collapse:collapse;
}

th, td{
    padding:12px;
    text-align:center;
}

th{
    background:#667eea;
    color:white;
}

tr:nth-child(even){
    background:#f2f2f2;
}

tr:hover{
    background:#e6ecff;
    transition:0.2s;
}

/* RESPONSIVE */
@media(max-width:900px){
    .cards{
        flex-direction:column;
    }

    .sidebar{
        display:none;
    }

    body{
        flex-direction:column;
    }
}
</style>

</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Spice Paradise</h2>
    <a href="#">Dashboard</a>
    <a href="billing.html">POS</a>
    <a href="index.html">Insert Product</a>
    <a href="delete.html">Delete Product</a>
    
    <a href="logout.php">Logout</a>
</div>

<!-- MAIN CONTENT -->
<div class="main">

<div class="header">
    <h1>Admin Dashboard</h1>
    <h3>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> 👋</h3>
</div>

<?php if ($result && $result->num_rows > 0): ?>
<?php while($row = $result->fetch_assoc()): 
    $totalRevenue += $row['total_price'];
    $totalOrders++;
endwhile; 

// Re-run query for table display
$result = $conn->query($sql);
?>

<!-- SUMMARY CARDS -->
<div class="cards">
    <div class="card">
        <h3>Total Orders</h3>
        <p><?php echo $totalOrders; ?></p>
    </div>

    <div class="card">
        <h3>Total Revenue</h3>
        <p>$<?php echo number_format($totalRevenue,2); ?></p>
    </div>
</div>

<!-- TABLE -->
<div class="table-container">
    <h2>Recent Orders</h2>
    <br>

    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Food Item</th>
            <th>Qty</th>
            <th>Unit ($)</th>
            <th>Total ($)</th>
            <th>Date</th>
        </tr>

        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['username']); ?></td>
            <td><?php echo htmlspecialchars($row['food_item']); ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td><?php echo number_format($row['unit_price'],2); ?></td>
            <td><?php echo number_format($row['total_price'],2); ?></td>
            <td><?php echo $row['order_date']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php else: ?>
<div class="card">
    <h3>No Orders Found</h3>
    <p>There are currently no orders in the system.</p>
</div>
<?php endif; ?>

</div>

</body>
</html>

<?php $conn->close(); ?>
