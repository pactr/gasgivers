<?php
session_start();
include 'includes/db.php';

/* INIT CART */
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/* Convert old cart format to new format if needed */
if (!empty($_SESSION['cart'])) {
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
}

/* BUY NOW FIX */
if (isset($_GET['buy'])) {

    $id = intval($_GET['buy']);
    $qty = intval($_GET['qty'] ?? 1);

    if ($qty < 1) {
        $qty = 1;
    }

    if ($id > 0) {
        $stmt = $conn->prepare("SELECT id, name, price FROM products WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if ($product) {
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
    }

    header("Location: cart.php");
    exit();
}

/* REMOVE ITEM */
if (isset($_GET['remove'])) {

    $removeId = intval($_GET['remove']);

    if (isset($_SESSION['cart'][$removeId])) {
        unset($_SESSION['cart'][$removeId]);
    }

    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cart | GasGivers Enterprise</title>

<link rel="stylesheet" href="assets/style.css">
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
.qty-btn{
    padding:5px 10px;
    cursor:pointer;
    border:none;
    background:#ddd;
    font-size:16px;
}
.qty{
    padding:0 10px;
    font-weight:bold;
}
</style>

</head>

<body>

<!-- HEADER (UNCHANGED) -->
<section id="header">

<a href="index.php">
<img src="logo/234846098-removebg-preview.png" class="logo" style="width:90px;">
</a>

<ul id="navbar">

<li><a href="index.php">Home</a></li>
<li><a href="shop.php">Shop</a></li>
<li><a href="about.php">About</a></li>
<li><a href="contact.php">Contact</a></li>

<li id="ig-bag">
<a href="cart.php">
<i class="fa-solid fa-cart-shopping"></i>
<span class="cart-count"><?php echo count($_SESSION['cart']); ?></span>
</a>
</li>

</ul>

</section>

<!-- PAGE HEADER -->
<section id="page-header">
<h2>Your Cart</h2>
<p>Review your selected products</p>
</section>

<!-- CART TABLE -->
<section id="cart" class="section-p1">

<table width="100%">

<thead>
<tr>
<td>Remove</td>
<td>Image</td>
<td>Product</td>
<td>Price</td>
<td>Quantity</td>
<td>Subtotal</td>
</tr>
</thead>

<tbody>

<?php
$total = 0;

if (!empty($_SESSION['cart'])) {

    foreach ($_SESSION['cart'] as $id => $item) {

        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {

            $price = $item['price'];
            $qty = $item['qty'];
            $subtotal = $price * $qty;
            $total += $subtotal;
            $productId = (int)$row['id'];
            $productName = htmlspecialchars($row['name']);
            $productImage = htmlspecialchars($row['image']);
            $safePrice = htmlspecialchars($price);
            $safeQty = (int)$qty;
            $safeSubtotal = htmlspecialchars($subtotal);

            echo "
            <tr data-id='{$productId}' data-price='{$safePrice}'>

                <td>
                    <a href='cart.php?remove={$productId}'>X</a>
                </td>

                <td>
                    <img src='uploads/{$productImage}' width='60' alt='{$productName}'>
                </td>

                <td>{$productName}</td>

                <td>KES {$safePrice}</td>

                <td>
                    <button class='qty-btn minus' data-id='{$productId}'>-</button>
                    <span class='qty' id='qty-{$productId}'>{$safeQty}</span>
                    <button class='qty-btn plus' data-id='{$productId}'>+</button>
                </td>

                <td class='item-total' id='total-{$productId}'>
                    KES {$safeSubtotal}
                </td>

            </tr>
            ";
        }
    }

} else {
    echo "<tr><td colspan='6'>Your cart is empty</td></tr>";
}
?>

</tbody>

</table>

</section>

<!-- TOTAL SECTION (ONLY CHANGE = PAY NOW ADDED) -->
<section id="cart-add" class="section-p1">

<div id="subtotals">

<h3>
Cart Total: Ksh <span id="subtotal"><?php echo $total; ?></span>
</h3>

<!-- ✅ ONLY ADDED BUTTON -->
<a href="buyer_info.php">
    <button class="buy-now-link">
        order now
    </button>
</a>

</div>

</section>

<!-- FOOTER (UNCHANGED EXACTLY AS YOU PROVIDED) -->
 <footer class="section-p1 section-m1">
     
       <div class="col">
         
          
        <img class="logo"
        src="icons/234183792-removebg-preview.png">

        <p>
            <strong>Adress:</strong>
             40601 auditorium Road, street 7, bondo Jooust
        </p>

        <p>
            <strong>Phone:+254-742601781</strong>
        </p>

        <p>
            <strong>opening hours:</strong>
            8:00 -  8pm mon - sun
        </p>
               <h4>follow us</h4>
              <div class="icon">
              <i class="fa-brands fa-facebook"></i>
              <i class="fa-brands fa-whatsapp"></i>
               <i class="fa-brands fa-instagram"></i>
               <i class="fa-brands fa-twitter"></i>
               <i class="fa-brands fa-linkedin"></i>

              </div>
              </div>
          </div>

          <div class ="col">
               <h4>About</h4>
               <a href="#">About us</a>
                <a href="#">Delivery information</a>
                 <a href="#">privacy policy</a>
                  <a href="#">Terms & conditions</a>
                   <a href="#">contact us</a>
          </div>
          
            <div class ="col">
               <h4>Account Information</h4>
               <a href="#">my Account</a>
                <a href="#">sign in</a>
                 <a href="#">view cart</a>
                  <a href="#">track my order</a>
                   <a href="#">help</a>
          </div>
          <div class="col install">
               <h4>Install App</h4>
               <p>From App store or Google play</p>
               <div class="row">
                    <img src="icons/WhatsApp Image 2026-03-10 at 3.01.21 PM.jpeg"alt="">
                        <img src="icons/WhatsApp Image 2026-03-09 at 9.52.57 PM.jpeg"alt="">
               </div>
               <div class ="secured">
               <p>Secured payment gateways</p>
               <img src="icons/Airtel Money Uganda Logo PNG Vector (PDF) Free Download.jpeg"alt="">
               <img src="icons/download.jpeg"alt="">
               <img src="icons/download.png"alt="">
               </div>
          </div>
          
        
<div class="copyright">
               <p>© 2026 lewis patrick.co.ke</p>
          </div>
          
    </footer>

<!-- JS (UNCHANGED) -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    function updateTotal() {

        let sum = 0;

        document.querySelectorAll(".item-total").forEach(el => {
            let val = parseFloat(el.innerText.replace("KES", "")) || 0;
            sum += val;
        });

        document.getElementById("subtotal").innerText = sum;
    }

    document.querySelectorAll(".plus").forEach(btn => {
        btn.addEventListener("click", function () {

            let id = this.dataset.id;
            let row = this.closest("tr");
            let price = parseFloat(row.dataset.price);

            let qtyEl = document.getElementById("qty-" + id);
            let qty = parseInt(qtyEl.innerText);

            qty++;

            qtyEl.innerText = qty;

            document.getElementById("total-" + id).innerText =
                "KES " + (qty * price);

            updateTotal();
        });
    });

    document.querySelectorAll(".minus").forEach(btn => {
        btn.addEventListener("click", function () {

            let id = this.dataset.id;
            let row = this.closest("tr");
            let price = parseFloat(row.dataset.price);

            let qtyEl = document.getElementById("qty-" + id);
            let qty = parseInt(qtyEl.innerText);

            if (qty > 1) qty--;

            qtyEl.innerText = qty;

            document.getElementById("total-" + id).innerText =
                "KES " + (qty * price);

            updateTotal();
        });
    });

});
</script>

</body>
</html>
