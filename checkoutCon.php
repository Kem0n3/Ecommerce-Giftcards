<?php
session_start();
require_once 'db.php';

class CheckoutSystem {
    private $conn;
    private $orderId;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function createOrder($cartItems, $customerId) {
        // Start transaction
        $this->conn->begin_transaction();
        
        try {
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
    
    public function processPayment($paymentDetails) {
        // Validate payment details
        if (!$this->validatePaymentDetails($paymentDetails)) {
            throw new Exception("Invalid payment details");
        }
        
        try {
            // In a real system, integrate with payment gateway here
            // For this example, we'll simulate payment processing
            
            // Update order status
            $sql = "UPDATE orders SET 
                   status = 'paid',
                   payment_method = ?,
                   payment_date = NOW()
                   WHERE order_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("si", $paymentDetails['method'], $this->orderId);
            $stmt->execute();
            
            return true;
            
        } catch (Exception $e) {
            // Handle payment failure
            $this->markOrderFailed();
            throw $e;
        }
    }
    
    private function validatePaymentDetails($details) {
        // Basic validation
        if (empty($details['cardNumber']) || strlen($details['cardNumber']) < 15) {
            return false;
        }
        if (empty($details['expiryMonth']) || empty($details['expiryYear'])) {
            return false;
        }
        if (empty($details['cvv']) || strlen($details['cvv']) < 3) {
            return false;
        }
        return true;
    }
    
    private function markOrderFailed() {
        $sql = "UPDATE orders SET status = 'failed' WHERE order_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->orderId);
        $stmt->execute();
    }
}