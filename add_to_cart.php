<<<<<<< HEAD
<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

=======
<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

>>>>>>> aeab546 (Updated deployment configuration)
$id = intval($_POST['id'] ?? $_GET['id'] ?? 0);
$qty = intval($_POST['qty'] ?? $_GET['qty'] ?? 1);

if ($qty < 1) {
    $qty = 1;
}

if ($id > 0) {
<<<<<<< HEAD

    $stmt = $conn->prepare("SELECT id, name, price FROM products WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {

=======

    $stmt = $conn->prepare("SELECT id, name, price FROM products WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {

>>>>>>> aeab546 (Updated deployment configuration)
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['qty'] += $qty;
        } else {
            $_SESSION['cart'][$id] = [
                "name" => $product['name'],
                "price" => (float)$product['price'],
                "qty" => $qty
            ];
        }
    }
<<<<<<< HEAD
}

=======
}

>>>>>>> aeab546 (Updated deployment configuration)
echo count($_SESSION['cart']);
