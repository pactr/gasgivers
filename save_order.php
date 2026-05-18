<?php
session_start();
include 'includes/db.php';

/* CHECK IF FORM SUBMITTED */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstname = trim($_POST['firstname']);
    $lastname  = trim($_POST['lastname']);
    $email     = trim($_POST['email']);
    $phone     = trim($_POST['phone']);
    $location  = trim($_POST['location']);

    /* SAVE NAME FOR THANK YOU PAGE */
    $_SESSION['customer_name'] = $firstname;

    /* INSERT INTO DATABASE */
    $stmt = $conn->prepare("
        INSERT INTO orders
        (firstname, lastname, email, phone, location)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "sssss",
        $firstname,
        $lastname,
        $email,
        $phone,
        $location
    );

    $stmt->execute();

    /* GET THE ORDER ID */
    $order_id = $conn->insert_id;

    /* SAVE CART ITEMS TO ORDER_ITEMS TABLE */
    $order_details = [];
    $total = 0;

    if (!empty($_SESSION['cart'])) {
        $item_stmt = $conn->prepare("
            INSERT INTO order_items
            (order_id, product_id, product_name, price, qty)
            VALUES (?, ?, ?, ?, ?)
        ");

        if (!$item_stmt) {
            die("Prepare failed: " . $conn->error);
        }

        foreach ($_SESSION['cart'] as $product_id => $item) {
            $name = $item['name'];
            $price = $item['price'];
            $qty = $item['qty'];
            $subtotal = $price * $qty;
            $total += $subtotal;

            $order_details[] = [
                'name' => $name,
                'price' => $price,
                'qty' => $qty,
                'subtotal' => $subtotal
            ];

            $item_stmt->bind_param(
                "iisdi",
                $order_id,
                $product_id,
                $name,
                $price,
                $qty
            );

            if (!$item_stmt->execute()) {
                die("Execute failed: " . $item_stmt->error);
            }
        }
        $item_stmt->close();
    }

    /* SEND ORDER CONFIRMATION EMAIL */
    if (!empty($email)) {
        $to = $email;
        $subject = "Order Confirmation - GasGivers Enterprise";

        $message = "
        <html>
        <head>
        <title>Order Confirmation</title>
        </head>
        <body style='font-family: Arial, sans-serif;'>
        <h2>Order Confirmation</h2>
        <p>Dear $firstname $lastname,</p>
        <p>We are in receipt of your order #$order_id. Thank you for shopping with GasGivers Enterprise!</p>
        <h3>Order Details:</h3>
        <table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse; width: 100%;'>
        <tr style='background-color: #4facfe; color: white;'>
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
        </tr>";

        foreach ($order_details as $item) {
            $message .= "
        <tr>
        <td>{$item['name']}</td>
        <td>KES {$item['price']}</td>
        <td>{$item['qty']}</td>
        <td>KES {$item['subtotal']}</td>
        </tr>";
        }

        $message .= "
        </table>
        <h3 style='color: #ff4ecd;'>Grand Total: KES $total</h3>
        <p><strong>Delivery Address:</strong> $location</p>
        <p><strong>Phone:</strong> $phone</p>
        <p>Your order will be delivered to your specified location. You will be contacted via phone for delivery arrangements.</p>
        <p>If you have any questions, please contact us.</p>
        <p>Best regards,<br>GasGivers Enterprise Team</p>
        </body>
        </html>
        ";

        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: GasGivers Enterprise <noreply@gasgivers.com>\r\n";

        mail($to, $subject, $message, $headers);
    }

    /* CLEAR CART */
    $_SESSION['cart'] = [];

    /* REDIRECT */
    header("Location: thank_you.php");
    exit();
}
?>