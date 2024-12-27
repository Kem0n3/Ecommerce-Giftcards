<?php
require_once 'db.php';

// Rename to checkout.php
class CheckoutSystem {
    private $conn;
    private $orderId;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function createOrder($cartItems, $customerInfo) {
        // Start transaction
        $this->conn->begin_transaction();
        
        try {
            // First create or get customer
            $customerId = $this->createCustomer($customerInfo);
            
            // Create order record
            $sql = "INSERT INTO orders (customer_id, order_date, status) 
                   VALUES (?, NOW(), 'pending')";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $customerId);
            $stmt->execute();
            
            $this->orderId = $this->conn->insert_id;
            
            // Insert order items
            foreach ($cartItems as $item) {
                $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                       VALUES (?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("iiid", $this->orderId, $item['id'], $item['quantity'], $item['value']);
                $stmt->execute();
            }
            
            $this->conn->commit();
            return $this->orderId;
            
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }
    
    private function createCustomer($customerInfo) {
        $sql = "INSERT INTO customers (email, full_name, address, created_at) 
                VALUES (?, ?, ?, NOW())
                ON DUPLICATE KEY UPDATE 
                full_name = VALUES(full_name),
                address = VALUES(address)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", 
            $customerInfo['email'],
            $customerInfo['name'],
            $customerInfo['address']
        );
        $stmt->execute();
        
        return $stmt->insert_id ?: $this->getCustomerIdByEmail($customerInfo['email']);
    }
    
    private function getCustomerIdByEmail($email) {
        $sql = "SELECT customer_id FROM customers WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $customer = $result->fetch_assoc();
        return $customer['customer_id'];
    }
}

// Checkout page handler
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    // Get cart data from POST request (sent from JavaScript)
    $cartData = json_decode(file_get_contents('php://input'), true);
    
    if (!$cartData || empty($cartData['items'])) {
        http_response_code(400);
        echo json_encode(['error' => 'No cart items provided']);
        exit;
    }
    
    try {
        $checkout = new CheckoutSystem($conn);
        $orderId = $checkout->createOrder(
            $cartData['items'],
            $cartData['customerInfo']
        );
        
        echo json_encode([
            'success' => true,
            'orderId' => $orderId,
            'message' => 'Order created successfully'
        ]);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'error' => 'Failed to process order',
            'message' => $e->getMessage()
        ]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Checkout - GenCards</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="product-pg.css">
    <link rel="stylesheet" href="checkout.css">
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

    <div class="checkout-container">
        <div class="checkout-form">
            <h2>Checkout</h2>
            <form id="payment-form">
                <div class="form-section">
                    <h3>Billing Information</h3>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" required>
                    </div>
                </div>
                
                <div class="form-section">
                    <h3>Payment Details</h3>
                    <div class="form-group">
                        <label for="card-number">Card Number</label>
                        <input type="text" id="card-number" name="cardNumber" 
                               pattern="\d{15,16}" maxlength="16" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="expiry">Expiry Date</label>
                            <div class="expiry-inputs">
                                <select id="expiry-month" name="expiryMonth" required></select>
                                <select id="expiry-year" name="expiryYear" required></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cvv">CVV</label>
                            <input type="text" id="cvv" name="cvv" 
                                   pattern="\d{3,4}" maxlength="4" required>
                        </div>
                    </div>
                </div>
                
                <div class="order-summary">
                    <h3>Order Summary</h3>
                    <div id="order-items"></div>
                    <div class="order-total">
                        <strong>Total:</strong>
                        <strong id="order-total-amount"></strong>
                    </div>
                </div>
                
                <button type="submit" class="checkout-button">Complete Purchase</button>
            </form>
        </div>
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

    <script>
        // Populate expiry date dropdowns
        const monthSelect = document.getElementById('expiry-month');
        const yearSelect = document.getElementById('expiry-year');
        
        for (let i = 1; i <= 12; i++) {
            const option = document.createElement('option');
            option.value = i.toString().padStart(2, '0');
            option.textContent = i.toString().padStart(2, '0');
            monthSelect.appendChild(option);
        }
        
        const currentYear = new Date().getFullYear();
        for (let i = currentYear; i <= currentYear + 10; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = i;
            yearSelect.appendChild(option);
        }

        // Load and display cart items
        function loadCartItems() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const orderItems = document.getElementById('order-items');
            const totalElement = document.getElementById('order-total-amount');
            
            orderItems.innerHTML = '';
            let total = 0;
            
            cart.forEach(item => {
                const itemTotal = item.value * item.quantity;
                total += itemTotal;
                
                const itemDiv = document.createElement('div');
                itemDiv.className = 'order-item';
                itemDiv.innerHTML = `
                    <span>${item.name} x ${item.quantity}</span>
                    <span>$${itemTotal.toFixed(2)}</span>
                `;
                orderItems.appendChild(itemDiv);
            });
            
            totalElement.textContent = `$${total.toFixed(2)}`;
            
            if (cart.length === 0) {
                window.location.href = 'shop.php';
            }
        }

        // Handle form submission
        document.getElementById('payment-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const button = e.target.querySelector('button[type="submit"]');
            button.classList.add('loading');
            button.disabled = true;
            
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            if (cart.length === 0) {
                alert('Your cart is empty');
                return;
            }
            
            try {
                const response = await fetch('checkout.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        items: cart,
                        customerInfo: {
                            email: document.getElementById('email').value,
                            name: document.getElementById('name').value,
                            address: document.getElementById('address').value
                        }
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    localStorage.removeItem('cart');
                    window.location.href = `order-confirmation.php?id=${data.orderId}`;
                } else {
                    throw new Error(data.message || 'Failed to process order');
                }
                
            } catch (error) {
                alert('Error processing your order: ' + error.message);
            } finally {
                button.classList.remove('loading');
                button.disabled = false;
            }
        });

        // Load cart items when page loads
        loadCartItems();
    </script>
</body>
</html>