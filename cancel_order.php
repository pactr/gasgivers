<?php
session_start();
include 'includes/db.php';

// Get the last order ID from the current session
if (isset($_SESSION['customer_name'])) {
    // Get the most recent order for this customer
    $customer_name = $_SESSION['customer_name'];
    
    $stmt = $conn->prepare("SELECT id, firstname, lastname, email FROM orders WHERE firstname = ? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("s", $customer_name);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
        $order_id = $order['id'];
        $firstname = $order['firstname'];
        $lastname = $order['lastname'];
        $email = $order['email'];
        
        // Update order status to cancelled (add status column if needed)
        $update_stmt = $conn->prepare("UPDATE orders SET status = 'cancelled' WHERE id = ?");
        $update_stmt->bind_param("i", $order_id);
        $update_stmt->execute();
        
        // Send cancellation email
        if (!empty($email)) {
            $to = $email;
            $subject = "Order Cancellation - GasGivers Enterprise";
            
            $message = "
            <html>
            <head>
            <title>Order Cancellation</title>
            </head>
            <body style='font-family: Arial, sans-serif;'>
            <h2>Order Cancellation Confirmation</h2>
            <p>Dear $firstname $lastname,</p>
            <p>Your order #$order_id has been successfully cancelled as per your request.</p>
            <p>We are sorry to see you go. If you have any feedback or would like to place a new order, please feel free to contact us.</p>
            <p>If you did not request this cancellation, please contact us immediately.</p>
            <p>Best regards,<br>GasGivers Enterprise Team</p>
            </body>
            </html>
            ";
            
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8\r\n";
            $headers .= "From: GasGivers Enterprise <noreply@gasgivers.com>\r\n";
            
            mail($to, $subject, $message, $headers);
        }
        
        // Redirect to home page with cancellation message
        header("Location: index.php?cancelled=true");
        exit();
    } else {
        // No order found, redirect to home
        header("Location: index.php");
        exit();
    }
} else {
    // No customer session, redirect to home
    header("Location: index.php");
    exit();
}
?>
