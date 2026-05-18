<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$count = count($_SESSION['cart']);
$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    header("Location: shop.php");
    exit();
}

$stmt = $conn->prepare("
    SELECT p.*, c.name AS category_name
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    header("Location: shop.php");
    exit();
}

$image = "uploads/" . $product['image'];
$subImages = [];

foreach (['sub_image1', 'sub_image2', 'sub_image3'] as $subImageField) {
    if (!empty($product[$subImageField])) {
        $subImages[] = "uploads/" . $product[$subImageField];
    }
}

while (count($subImages) < 3) {
    $subImages[] = $image;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($product['name']); ?> | GasGivers</title>

    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .product-detail{
            display:grid;
            grid-template-columns:minmax(280px, 1fr) minmax(280px, 1fr);
            gap:40px;
            align-items:start;
        }

        .product-gallery{
            display:flex;
            flex-direction:column;
            gap:14px;
        }

        .main-product-image{
            width:100%;
            height:430px;
            object-fit:contain;
            border-radius:8px;
            border:1px solid lightblue;
            background:white;
        }

        .thumb-row{
            display:grid;
            grid-template-columns:repeat(3, 1fr);
            gap:12px;
        }

        .thumb-row img{
            width:100%;
            height:120px;
            object-fit:contain;
            border-radius:8px;
            cursor:pointer;
            border:2px solid transparent;
            background:white;
        }

        .thumb-row img.active,
        .thumb-row img:hover{
            border-color:hotpink;
        }

        .product-info{
            text-align:left;
        }

        .product-info h2{
            color:#1a1a1a;
            margin-bottom:12px;
        }

        .product-info h3{
            color:#1e6fff;
            margin:15px 0;
            font-size:26px;
        }

        .detail-meta{
            margin:8px 0;
            color:#465b52;
        }

        .detail-description{
            line-height:1.7;
            margin:18px 0;
        }

        .quantity-box{
            display:flex;
            align-items:center;
            gap:10px;
            margin:20px 0;
        }

        .quantity-box button,
        .quantity-box input{
            width:44px;
            height:42px;
            border:1px solid lightblue;
            border-radius:6px;
            text-align:center;
            font-weight:bold;
            background:white;
        }

        .quantity-box button{
            cursor:pointer;
            background:#E3E6f3;
        }

        .detail-actions{
            display:flex;
            gap:12px;
            flex-wrap:wrap;
        }

        .detail-actions button,
        .detail-actions a{
            min-width:150px;
            padding:12px 16px;
            border:none;
            border-radius:6px;
            cursor:pointer;
            font-weight:bold;
            text-decoration:none;
            text-align:center;
        }

        .detail-actions .add-cart{
            flex:0;
        }

        .detail-actions .buy-now-link{
            background:#1e6fff;
            color:white;
        }

        @media (max-width:799px){
            .product-detail{
                grid-template-columns:1fr;
                gap:24px;
            }

            .main-product-image{
                height:320px;
            }

            .thumb-row img{
                height:90px;
            }

            .detail-actions{
                flex-direction:column;
            }

            .detail-actions button,
            .detail-actions a{
                width:100%;
            }
        }

        @media (max-width:477px){
            .main-product-image{
                height:260px;
            }

            .thumb-row{
                gap:8px;
            }

            .thumb-row img{
                height:78px;
            }
        }
    </style>
</head>

<body>

<section id="header">

    <a href="index.php">
        <img src="logo/234846098-removebg-preview.png"
        class="logo"
        style="width:90px; height:auto;">
    </a>

    <ul id="navbar">

        <form action="shop.php#product1" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search products...">
            <button type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <li><a href="index.php">Home</a></li>
        <li><a class="active" href="shop.php">Shop</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>

        <li id="ig-bag">
            <a href="cart.php">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="cart-count"><?php echo $count; ?></span>
            </a>
        </li>

        <a href="#" id="close">
            <i class="fa-solid fa-xmark"></i>
        </a>

    </ul>

    <div id="mobile">
        <a href="cart.php">
            <i class="fa-solid fa-cart-shopping"></i>
        </a>
        <i id="bar" class="fas fa-bars"></i>
    </div>

</section>

<section id="page-header">
    <h2><?php echo htmlspecialchars($product['name']); ?></h2>
    <p>Product details and ordering options</p>
</section>

<section class="product-detail section-p1">

    <div class="product-gallery">
        <img id="main-product-image"
        class="main-product-image"
        src="<?php echo htmlspecialchars($image); ?>"
        alt="<?php echo htmlspecialchars($product['name']); ?>">

        <div class="thumb-row">
            <?php foreach ($subImages as $index => $subImage) { ?>
                <img class="<?php if ($index === 0) echo 'active'; ?>"
                src="<?php echo htmlspecialchars($subImage); ?>"
                alt="<?php echo htmlspecialchars($product['name']); ?>">
            <?php } ?>
        </div>
    </div>

    <div class="product-info">
        <p class="detail-meta">
            Category:
            <?php echo htmlspecialchars($product['category_name'] ?? 'General Product'); ?>
        </p>

        <h2><?php echo htmlspecialchars($product['name']); ?></h2>
        <h3>KES <?php echo htmlspecialchars($product['price']); ?></h3>

        <p class="detail-description">
            <?php echo nl2br(htmlspecialchars($product['description'] ?: 'More information about this product will be added soon.')); ?>
        </p>

        <?php if (!empty($product['product_details'])) { ?>
            <p class="detail-description">
                <?php echo nl2br(htmlspecialchars($product['product_details'])); ?>
            </p>
        <?php } ?>

        <p class="detail-meta">Availability: In stock</p>
        <p class="detail-meta">Delivery: Available after order confirmation</p>

        <div class="quantity-box">
            <button type="button" id="qty-minus">-</button>
            <input type="number" id="qty" value="1" min="1">
            <button type="button" id="qty-plus">+</button>
        </div>

        <div class="detail-actions">
            <button class="add-cart" id="detail-add-cart" data-id="<?php echo $product['id']; ?>">
                Add to Cart
            </button>

            <a class="buy-now-link" id="detail-buy-now" href="cart.php?buy=<?php echo $product['id']; ?>&qty=1">
                Buy Now
            </a>
        </div>
    </div>

</section>

<footer class="section-p1 section-m1">
    <div class="col">
        <img class="logo" src="icons/234183792-removebg-preview.png">
        <p><strong>Adress:</strong> 60200 Meru Road, street 7, meru town</p>
        <p><strong>Phone:+254-</strong>115072559</p>
        <p><strong>opening hours:</strong>8:00 - 16:50 mon - sat</p>
    </div>

    <div class="col">
        <h4>About</h4>
        <a href="about.php">About us</a>
        <a href="contact.php">contact us</a>
    </div>

    <div class="col">
        <h4>Account Information</h4>
        <a href="login.php">my Account</a>
        <a href="cart.php">view cart</a>
        <a href="contact.php">help</a>
    </div>

    <div class="copyright">
        <p>© 2026 Gasgivers online market.all rights reserved</p>
    </div>
</footer>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const mainImage = document.getElementById("main-product-image");
    const qtyInput = document.getElementById("qty");
    const buyNow = document.getElementById("detail-buy-now");
    const addCart = document.getElementById("detail-add-cart");
    const productId = addCart.dataset.id;

    function cleanQty() {
        let qty = parseInt(qtyInput.value, 10);

        if (Number.isNaN(qty) || qty < 1) {
            qty = 1;
        }

        qtyInput.value = qty;
        buyNow.href = "cart.php?buy=" + encodeURIComponent(productId) + "&qty=" + encodeURIComponent(qty);

        return qty;
    }

    document.querySelectorAll(".thumb-row img").forEach(thumb => {
        thumb.addEventListener("click", function () {
            document.querySelectorAll(".thumb-row img").forEach(img => img.classList.remove("active"));
            this.classList.add("active");
            mainImage.src = this.src;
        });
    });

    document.getElementById("qty-minus").addEventListener("click", function () {
        qtyInput.value = Math.max(1, cleanQty() - 1);
        cleanQty();
    });

    document.getElementById("qty-plus").addEventListener("click", function () {
        qtyInput.value = cleanQty() + 1;
        cleanQty();
    });

    qtyInput.addEventListener("change", cleanQty);
    qtyInput.addEventListener("keyup", cleanQty);

    addCart.addEventListener("click", function () {
        fetch("add_to_cart.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "id=" + encodeURIComponent(productId) + "&qty=" + encodeURIComponent(cleanQty())
        })
        .then(res => res.text())
        .then(count => {
            document.querySelectorAll(".cart-count").forEach(el => {
                el.innerText = count;
            });
        });
    });

    const bar = document.getElementById("bar");
    const navbar = document.getElementById("navbar");
    const close = document.getElementById("close");

    if (bar && navbar) {
        bar.addEventListener("click", () => {
            navbar.classList.add("active");
        });
    }

    if (close && navbar) {
        close.addEventListener("click", (e) => {
            e.preventDefault();
            navbar.classList.remove("active");
        });
    }
});
</script>

</body>
</html>
