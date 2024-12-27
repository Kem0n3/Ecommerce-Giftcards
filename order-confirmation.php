<?php
require_once 'db.php';

// Get order ID from URL
$orderId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$orderId) {
    header('Location: shop.php');
    exit;
}

// Fetch order details
$sql = "SELECT o.*, c.full_name, c.email, c.address 
        FROM orders o 
        JOIN customers c ON o.customer_id = c.customer_id 
        WHERE o.order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $orderId);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

// Fetch order items
$sql = "SELECT oi.*, ci.card_name 
        FROM order_items oi 
        JOIN card_info ci ON oi.product_id = ci.card_id 
        WHERE oi.order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $orderId);
$stmt->execute();
$items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Confirmation - GenCards</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="checkout.css">
    <style>
        *{
            font-family: Montserrat, sans-serif;
        }

        .confirmation-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            background: #f3f4f6;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .success-message {
            text-align: center;
            color: #2E4156;
            margin-bottom: 30px;
        }
        
        .success-message i {
            font-size: 48px;
            margin-bottom: 15px;
        }
        
        .order-details {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .order-number {
            font-size: 18px;
            color: #2E4156;
            margin-bottom: 15px;
        }
        
        .customer-info {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .item-list {
            margin-bottom: 20px;
        }
        
        .total {
            text-align: right;
            font-weight: bold;
            font-size: 18px;
            margin-top: 20px;
        }
        
        .continue-shopping {
            display: block;
            text-align: center;
            margin-top: 30px;
            padding: 12px 24px;
            background: #2E4156;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        
        .continue-shopping:hover {
            background: #3a4f68;
        }
    </style>
</head>
<body>
    <?php if ($order): ?>
    <div class="confirmation-container">
        <div class="success-message">
            <i class="fi fi-rr-checkbox"></i>
            <h2>Thank You for Your Order!</h2>
            <p>Your order has been successfully placed.</p>
        </div>
        
        <div class="order-details">
            <div class="order-number">
                Order #<?php echo $orderId; ?>
            </div>
            
            <div class="customer-info">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($order['full_name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
            </div>
            
            <div class="item-list">
                <?php 
                $total = 0;
                foreach ($items as $item): 
                    $itemTotal = $item['price'] * $item['quantity'];
                    $total += $itemTotal;
                ?>
                <div class="order-item">
                    <span><?php echo htmlspecialchars($item['card_name']); ?> x <?php echo $item['quantity']; ?></span>
                    <span>$<?php echo number_format($itemTotal, 2); ?></span>
                </div>
                <?php endforeach; ?>
                
                <div class="total">
                    Total: $<?php echo number_format($total, 2); ?>
                </div>
            </div>
        </div>
        
        <a href="shop.php" class="continue-shopping">Continue Shopping</a>
    </div>
    <?php endif; ?>
</body>
</html>