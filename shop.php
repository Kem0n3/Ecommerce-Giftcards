<?php
include 'db.php';

$sql = "SELECT * FROM card_info";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Shop</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="shop.css">
    <link rel="stylesheet" href="cart.css">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
</head>
<body>
    <nav>
        <a href="homepage.php" class="site-title-link">
            <h1>GenCards</h1>
        </a>
        <ul>
            <li><a href="homepage.php">Home</a></li>
            <li><a href="shop.php">Shop</a></li>
            <li><a href="">FAQs</a></li>
            <li>
                <a href="#" id="cartIcon">
                    <i class="fi fi-rr-shopping-cart"></i>
                    <span id="cartCount" class="cart-count"></span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="content">
        <h2>Shop Gift Cards</h2>
        <div class="cards">
            <?php while ($product = $result->fetch_assoc()): ?>
                <a href="product.php?id=<?php echo $product['card_id']; ?>" class="card-link">
                    <div class="card">
                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['card_name']; ?>">
                        <h4><?php echo $product['card_name']; ?></h4>
                    </div>
                </a>
            <?php endwhile; ?>
        </div>
    </div>

    <div class="cart-sidebar">
        <div class="cart-header">
            <h2>Shopping Cart</h2>
            <button class="cart-close" onclick="toggleCart()">×</button>
        </div>
        <div class="cart-items"></div>
        <div class="cart-total"></div>
    </div>


    <footer>
        <div class="footer-container">
            <div class="footer-support">
                <h4>Customer Support</h4>
                <p>Phone: +1 234 567 890</p>
                <p>Email: support@gencards.com</p>
            </div>
            <div class="footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Shop</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-social">
                <h4>Follow Us</h4>
                <ul>
                    <li><a href="#"><i class="fi fi-brands-facebook"></i></a></li>
                    <li><a href="#"><i class="fi fi-brands-twitter"></i></a></li>
                    <li><a href="#"><i class="fi fi-brands-instagram"></i></a></li>
                    <li><a href="#"><i class="fi fi-brands-linkedin"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 GenCards. All rights reserved.</p>
        </div>
    </footer>

    <script src="addToCart.js"></script>
</body>
</html>