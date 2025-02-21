<?php
include 'db.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $sql = "SELECT * FROM card_info WHERE card_id = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $prices = json_decode($product['card_value']);
    } else {
        echo "Product not found.";
        exit;
    }
} else {
    echo "No product ID provided.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $product['card_name']; ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/product-pg.css">
    <link rel="stylesheet" href="css/cart.css">
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

    <div class="product-template">
        <div class="product-image">
            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['card_name']; ?>">
        </div>
        <div class="product-detail">
            <h1><?php echo $product['card_name']; ?></h1>
            <form action="cart.php">
                <p>Select Card Value: </p>
                <div class="value-selector">
                    <?php foreach ($prices as $price): ?>
                        <input type="radio" id="price<?php echo $price; ?>" name="price" value="<?php echo $price; ?>" <?php echo $price == 10 ? 'checked' : ''; ?>>
                        <label for="price<?php echo $price; ?>">$<?php echo $price; ?></label>
                    <?php endforeach; ?>
                </div>
                <input type="hidden" name="id" value="<?php echo $product['card_id']; ?>">
                
                <p>Number of Cards: </p>
                <div class="quantity-selector">
                    <button id="decrease">-</button>
                    <input type="text" id="item-count" value="0" readonly />
                    <button id="increase">+</button>
                </div>

                <button type="button" id="addToCartBtn" class="button-link">Add to Cart</button>
            </form>
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
    <script src="js/itemCount.js"></script>
    <script src="js/addToCart.js"></script>
</body>
</html>