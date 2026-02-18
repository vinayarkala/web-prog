<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: login.html");
    exit;
}

$username = htmlspecialchars($_SESSION['username']);

/* ================= MENU ================= */

$menu = [

    "🍛 Biryani" => [
        "chicken_biryani" => [
            "name"=>"Chicken Biryani",
            "price"=>10.99,
            "image"=>"https://upload.wikimedia.org/wikipedia/commons/thumb/5/5a/%22Hyderabadi_Dum_Biryani%22.jpg/500px-%22Hyderabadi_Dum_Biryani%22.jpg"
        ],
        "mutton_biryani" => [
            "name"=>"Mutton Biryani",
            "price"=>13.99,
            "image"=>"https://upload.wikimedia.org/wikipedia/commons/thumb/7/7c/Hyderabadi_Chicken_Biryani.jpg/500px-Hyderabadi_Chicken_Biryani.jpg"
        ],
        "beef_biryani" => [
            "name"=>"Beef Biryani",
            "price"=>12.99,
            "image"=>"https://upload.wikimedia.org/wikipedia/commons/thumb/5/54/Food-Beef-Biryani-2.jpg/500px-Food-Beef-Biryani-2.jpg"
        ],
        "veg_biryani" => [
            "name"=>"Vegetable Biryani",
            "price"=>8.99,
            "image"=>"https://upload.wikimedia.org/wikipedia/commons/thumb/a/ad/Biriyani.jpg/500px-Biriyani.jpg"
        ],
        "prawn_biryani" => [
            "name"=>"Prawn Biryani",
            "price"=>14.99,
            "image"=>"https://upload.wikimedia.org/wikipedia/commons/thumb/9/9b/Khaomhokkhai.png/500px-Khaomhokkhai.png"
        ],
        "egg_biryani" => [
            "name"=>"Egg Biryani",
            "price"=>7.99,
            "image"=>"https://upload.wikimedia.org/wikipedia/commons/thumb/a/a7/Kyet_Shar_Soon_biryani.jpg/500px-Kyet_Shar_Soon_biryani.jpg"
        ],
        "hyderabadi_biryani" => [
            "name"=>"Hyderabadi Biryani",
            "price"=>11.99,
            "image"=>"https://upload.wikimedia.org/wikipedia/commons/thumb/3/37/Nasi_Kebuli_Jakarta.JPG/500px-Nasi_Kebuli_Jakarta.JPG"
        ],
        "special_house_biryani" => [
            "name"=>"Special House Biryani",
            "price"=>15.99,
            "image"=>"https://upload.wikimedia.org/wikipedia/commons/thumb/2/2d/Mutton_briyani_from_Little_India%2C_Singapore_-_20130719.jpg/500px-Mutton_briyani_from_Little_India%2C_Singapore_-_20130719.jpg"
        ]
    ],

    "🥘 Starters" => [
        "tikka" => [
            "name"=>"Chicken Tikka",
            "price"=>8.99,
            "image"=>"https://upload.wikimedia.org/wikipedia/commons/thumb/b/bd/Tandoorimumbai.jpg/500px-Tandoorimumbai.jpg"
        ],
        "samosa" => [
            "name"=>"Samosa",
            "price"=>2.99,
            "image"=>"https://upload.wikimedia.org/wikipedia/commons/thumb/f/ff/Indian_Samosa_by_clumsy_home_chef.jpg/960px-Indian_Samosa_by_clumsy_home_chef.jpg"
        ],
        "seekh_kebab" => [
            "name"=>"Seekh Kebab",
            "price"=>7.99,
            "image"=>"https://upload.wikimedia.org/wikipedia/commons/thumb/0/0c/Pakistani_Food_Beef_Kabobs.jpg/500px-Pakistani_Food_Beef_Kabobs.jpg"
        ],
        "pakora" => [
            "name"=>"Vegetable Pakora",
            "price"=>4.99,
            "image"=>"https://upload.wikimedia.org/wikipedia/commons/thumb/b/b6/Pakoras_di_verdura.jpg/960px-Pakoras_di_verdura.jpg"
        ],
        "spring_rolls" => [
            "name"=>"Spring Rolls",
            "price"=>5.49,
            "image"=>"https://upload.wikimedia.org/wikipedia/commons/thumb/1/1e/Spring_Rolls_%283357696061%29.jpg/960px-Spring_Rolls_%283357696061%29.jpg"
        ],
        "chicken_wings" => [
            "name"=>"Spicy Chicken Wings",
            "price"=>6.99,
            "image"=>"https://upload.wikimedia.org/wikipedia/commons/thumb/a/a0/Chicken_lollipop_in_Goa.jpg/500px-Chicken_lollipop_in_Goa.jpg"
        ],
        "fish_fingers" => [
            "name"=>"Fish Fingers",
            "price"=>7.49,
            "image"=>"https://upload.wikimedia.org/wikipedia/commons/thumb/6/64/Fishfinger_classic_fried_2.jpg/500px-Fishfinger_classic_fried_2.jpg"
        ],
        "paneer_tikka" => [
            "name"=>"Paneer Tikka",
            "price"=>7.99,
            "image"=>"https://upload.wikimedia.org/wikipedia/commons/thumb/f/f2/Paneer_tikka.jpg/500px-Paneer_tikka.jpg"
        ]
    ],

    "🥤 Drinks" => [
        "lassi" => [
            "name"=>"Sweet Lassi",
            "price"=>3.49,
            "image"=>"https://upload.wikimedia.org/wikipedia/commons/thumb/f/f1/Salt_lassi.jpg/500px-Salt_lassi.jpg"
        ],
        "chai" => [
            "name"=>"Masala Chai",
            "price"=>2.49,
            "image"=>"https://upload.wikimedia.org/wikipedia/commons/thumb/d/d7/Masala_Tea_-_2.jpg/500px-Masala_Tea_-_2.jpg"
        ],
        "mango_lassi" => [
            "name"=>"Mango Lassi",
            "price"=>3.99,
            "image"=>"https://cooked.wiki/imgproxy/unsafe/resizing_type:fill-down/width:250/height:250/enlarge:1/quality:90/YjQ2NzM1MWQtOTBmOS00MTA2LWJiNTAtNzcxNTAwODgyY2M0.jpg"
        ],
        "lemon_soda" => [
            "name"=>"Fresh Lemon Soda",
            "price"=>2.99,
            "image"=>"https://upload.wikimedia.org/wikipedia/commons/thumb/c/cd/Italian_Lemon_Soda.jpg/500px-Italian_Lemon_Soda.jpg"
        ],
        "coca_cola" => [
            "name"=>"Coca Cola",
            "price"=>1.99,
            "image"=>"https://upload.wikimedia.org/wikipedia/commons/thumb/e/e8/15-09-26-RalfR-WLC-0098_-_Coca-Cola_glass_bottle_%28Germany%29.jpg/500px-15-09-26-RalfR-WLC-0098_-_Coca-Cola_glass_bottle_%28Germany%29.jpg"
        ],
        "mineral_water" => [
            "name"=>"Mineral Water",
            "price"=>1.49,
            "image"=>"https://upload.wikimedia.org/wikipedia/commons/0/02/Stilles_Mineralwasser.jpg"
        ],
        "iced_tea" => [
            "name"=>"Iced Tea",
            "price"=>2.79,
            "image"=>"https://upload.wikimedia.org/wikipedia/commons/thumb/e/ef/Iced_Tea_from_flickr.jpg/500px-Iced_Tea_from_flickr.jpg"
        ],
        "falooda" => [
            "name"=>"Royal Falooda",
            "price"=>4.49,
            "image"=>"https://upload.wikimedia.org/wikipedia/commons/thumb/8/85/Faluda.JPG/500px-Faluda.JPG"
        ]
    ]
];



/* ================= FLATTEN MENU ================= */

$flatMenu = [];
foreach($menu as $category){
    foreach($category as $id => $item){
        $flatMenu[$id] = $item;
    }
}

/* ================= CART ================= */

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/* ADD ITEM */
if (isset($_POST['add']) && isset($_POST['item'])) {
    $item = $_POST['item'];

    if (isset($flatMenu[$item])) {
        $_SESSION['cart'][$item] = ($_SESSION['cart'][$item] ?? 0) + 1;
    }
}

/* REMOVE ITEM */
if (isset($_POST['remove']) && isset($_POST['item'])) {
    $item = $_POST['item'];

    if (isset($_SESSION['cart'][$item])) {
        if ($_SESSION['cart'][$item] > 1) {
            $_SESSION['cart'][$item]--;
        } else {
            unset($_SESSION['cart'][$item]);
        }
    }
}

/* TOTAL CALCULATION */

$totalItems = 0;
$totalPrice = 0;

foreach ($_SESSION['cart'] as $id => $qty) {
    if (isset($flatMenu[$id])) {
        $totalItems += $qty;
        $totalPrice += $flatMenu[$id]['price'] * $qty;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Spice Paradise</title>
<link rel="stylesheet" href="user.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

<!-- NAVBAR -->
<header class="navbar">
    <div class="logo">🍽 Spice Paradise</div>
    <nav>
        <a href="#menu">Menu</a>
        <a href="#contact">Contact</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<!-- HERO -->
<section class="hero">
    <div class="hero-text">
        <h1>Fresh Indian Flavors 🌿</h1>
        <p>Simple. Modern. Delicious.</p>
        <a href="#menu" class="primary-btn">Explore Menu 🍛</a>
    </div>
</section>

<!-- MENU -->
<div class="container" id="menu">

    <div class="category-tabs">
        <?php foreach($menu as $categoryName => $items): ?>
            <button onclick="filterCategory('<?php echo md5($categoryName); ?>')">
                <?php echo $categoryName; ?>
            </button>
        <?php endforeach; ?>
        <button onclick="showAll()">✨ All</button>
    </div>

    <?php foreach($menu as $categoryName => $items): ?>
        <div class="menu-section" id="<?php echo md5($categoryName); ?>">
            <h2 class="category-title"><?php echo $categoryName; ?></h2>

            <div class="menu-grid">
                <?php foreach($items as $id => $item): ?>
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($item['image']); ?>">
                        <div class="card-content">
                            <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                            <p>$<?php echo number_format($item['price'],2); ?></p>

                            <form method="POST">
                                <input type="hidden" name="item" value="<?php echo $id; ?>">
                                <button type="submit" name="add" class="add-btn">Add 🛒</button>
                            </form>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>

</div>

<!-- FLOATING CART -->
<div class="floating-cart" onclick="toggleCart()">
    🛒 <?php echo $totalItems; ?>
</div>

<!-- CART -->
<div id="cart" class="cart">
    <div class="cart-header">
        <h2>Your Cart 🛍</h2>
        <span onclick="toggleCart()">✕</span>
    </div>

    <?php if(empty($_SESSION['cart'])): ?>
        <p>Cart is empty</p>
    <?php else: ?>

        <?php foreach($_SESSION['cart'] as $id => $qty): ?>
            <?php if(isset($flatMenu[$id])): ?>
                <div class="cart-item">
                    <span>
                        <?php echo htmlspecialchars($flatMenu[$id]['name']); ?> 
                        x <?php echo $qty; ?>
                    </span>

                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="item" value="<?php echo $id; ?>">
                        <button type="submit" name="remove">Remove</button>
                    </form>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

        <h3>Total $<?php echo number_format($totalPrice,2); ?></h3>

        <!-- CHECKOUT BUTTON -->
        <form method="POST" action="order_process.php">
            <button type="submit" name="checkout" class="primary-btn">
                Checkout 
            </button>
        </form>

    <?php endif; ?>
</div>

<!-- CONTACT -->
<section id="contact" class="contact">
    <h2>Contact Us 📞</h2>
    <p>Email: vinayraj@gmail.com</p>
    <p>Phone: +39 3509002350</p>
    <p>Address: messina , Italy</p>
</section>

<!-- FOOTER -->
<footer class="footer">
    <p>© <?php echo date("Y"); ?> Spice Paradise 🌶 All rights reserved.</p>
</footer>

<script>
function toggleCart(){
    document.getElementById("cart").classList.toggle("show");
}

function filterCategory(id){
    document.querySelectorAll(".menu-section").forEach(sec => {
        sec.style.display = "none";
    });
    document.getElementById(id).style.display = "block";
}

function showAll(){
    document.querySelectorAll(".menu-section").forEach(sec => {
        sec.style.display = "block";
    });
}
</script>

</body>
</html>
