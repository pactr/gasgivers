<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Cart is empty");
}

// Convert old cart format to new format if needed
$new_cart = [];
foreach ($_SESSION['cart'] as $key => $item) {
    if (is_int($item)) {
        // Old format: item is just an ID, need to fetch product data
        $stmt = $conn->prepare("SELECT id, name, price FROM products WHERE id=?");
        $stmt->bind_param("i", $item);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        
        if ($product) {
            $new_cart[$item] = [
                "name" => $product['name'],
                "price" => (float)$product['price'],
                "qty" => 1
            ];
        }
    } else if (is_array($item)) {
        // New format: already an array
        $new_cart[$key] = $item;
    }
}
$_SESSION['cart'] = $new_cart;

$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>

<style>
body {
    margin:0;
    font-family:Arial;
    background:linear-gradient(135deg,#4facfe,#ff4ecd);
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.box {
    width:95%;
    max-width:900px;
    background:white;
    padding:25px;
    border-radius:15px;
}

table {
    width:100%;
    border-collapse:collapse;
}

th {
    background:#4facfe;
    color:white;
    padding:10px;
}

td {
    text-align:center;
    padding:10px;
    border-bottom:1px solid #ddd;
}

.total {
    text-align:right;
    font-weight:bold;
    margin-top:10px;
    color:#ff4ecd;
}

button {
    width:100%;
    padding:12px;
    background:#ff4ecd;
    border:none;
    color:white;
    margin-top:15px;
}
</style>
</head>

<body>

<div class="box">

<h2>Checkout</h2>

<table>
<tr>
    <th>Product</th>
    <th>Price</th>
    <th>Qty</th>
    <th>Subtotal</th>
</tr>

<?php foreach($_SESSION['cart'] as $id => $item):

$subtotal = $item['price'] * $item['qty'];
$total += $subtotal;

?>

<tr>
    <td><?= $item['name'] ?></td>
    <td><?= $item['price'] ?></td>
    <td><?= $item['qty'] ?></td>
    <td><?= $subtotal ?></td>
</tr>

<?php endforeach; ?>

</table>

<div class="total">
Grand Total: KES <?= $total ?>
</div>

<form action="save_order.php" method="POST">
    <input type="hidden" name="firstname" value="<?= htmlspecialchars($_POST['firstname'] ?? '') ?>">
    <input type="hidden" name="lastname" value="<?= htmlspecialchars($_POST['lastname'] ?? '') ?>">
    <input type="hidden" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
    <input type="hidden" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
    <input type="hidden" name="location" value="<?= htmlspecialchars($_POST['location'] ?? '') ?>">
    <button type="submit">Submit Order</button>
</form>

</div>

</body>
</html>