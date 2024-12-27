<?php
include 'db.php';

$sql = "SELECT * FROM card_info";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html>
    <head>
        <title>GenCards</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/home.css">
        <link rel="stylesheet" href="css/cart.css">
        <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    </head>
    <body>
        <header>
            <nav>
                <a href="homepage.php" class="site-title-link">
                    <h1>GenCards</h1>
                </a>
                <ul>
                    <li><a href="">About us</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a href="">FAQs</a></li>
                </ul>
            </nav>

            <div class="content">
                <div class="cont">
                    <h1>Fast, Easy, and Instant - Your Go-To Gift Card Store</h1>
                    <p>Explore a wide selection of digital gift cards and subscriptions from top brands like Amazon, Netflix, Spotify, and more. </p>
                    <a href="shop.php" class="button-link">Shop Now</a>

                </div>

                <div class="why-icon">
                    <h4></h4>

                    <div class="cards">

                        <div class="card">
                            <img src = "icons/fast.png" alt="fast">
                            <h4>Quick delivery</h4>
                        </div>
                        <div class="card">
                            <img src = "icons/refund.png" alt="">
                            <h4>Easy Refunds</h4>
                        </div>
                        <div class="card">
                            <img src = "icons/affordable.png" alt="">
                            <h4>Affordable Price</h4>
                        </div>
                        <div class="card">
                            <img src = "icons/trusted.png" alt="">
                            <h4>Trust Guaranteed</h4>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <div class="top-picks">
            <h2>Best Selling Cards</h2>

            <div class="cards">
                <div class="card">
                    <img src ="img/robux.png" alt="">
                    <h4>Roblox Gift Card</h4>
                </div>
                <div class="card">
                    <img src ="img/disc.png" alt="">
                    <h4>Discord Gift Card</h4>
                </div>
                <div class="card">
                    <img src ="img/spotify.jpg" alt="">
                    <h4>Spotify Gift Card</h4>
                </div>
                <div class="card">
                    <img src ="img/val.jpg" alt="">
                    <h4>Valorant Gift Card</h4>
                </div>
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



        <script src="js/addToCart.js" async defer></script>
    </body>
</html>