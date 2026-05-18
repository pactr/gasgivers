<?php
session_start();
include 'includes/db.php';

$page = 'shop';

$count = 0;

if (isset($_SESSION['cart'])) {
    $count = count($_SESSION['cart']);
}

$categories = [];
$categoryResult = $conn->query("SELECT slug, name, image, description FROM categories ORDER BY id ASC");

if ($categoryResult) {
    while ($category = $categoryResult->fetch_assoc()) {
        $categories[$category['slug']] = $category;
    }
}

$selectedCategory = $_GET['category'] ?? '';
$selectedCategoryData = $categories[$selectedCategory] ?? null;
$search = trim($_GET['search'] ?? '');

if ($search !== '') {
    $searchTerm = "%" . $search . "%";
    $stmt = $conn->prepare("
        SELECT *
        FROM products
        WHERE name LIKE ? OR description LIKE ?
        ORDER BY id DESC
    ");
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result || $result->num_rows === 0) {
        header("Location: shop.php");
        exit();
    }
} elseif ($selectedCategoryData) {
    $stmt = $conn->prepare("
        SELECT p.*
        FROM products p
        JOIN categories c ON p.category_id = c.id
        WHERE p.display_type = 1
        AND c.slug = ?
        ORDER BY p.id DESC
    ");
    $stmt->bind_param("s", $selectedCategory);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("
        SELECT *
        FROM products
        WHERE display_type = 1
        ORDER BY id DESC
    ");
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>

    <link rel="stylesheet" href="assets/style.css">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

<!-- HEADER -->
<section id="header">

    <a href="#">
        <img src="logo/234846098-removebg-preview.png"
        class="logo"
        style="width: 90px; height: auto;">
    </a>

    <ul id="navbar">

        <form action="shop.php#product1" method="GET" class="search-form">

            <input
                type="text"
                name="search"
                placeholder="Search products..."
                value="<?php echo htmlspecialchars($search); ?>"
            >

            <button type="submit">
                <i class="fas fa-search"></i>
            </button>

        </form>

        <li>
            <a class="<?php if($page=='home') echo 'active'; ?>"
            href="index.php">Home</a>
        </li>

        <li>
            <a class="<?php if($page=='shop') echo 'active'; ?>"
            href="shop.php">Shop</a>
        </li>

        <li>
            <a class="<?php if($page=='about') echo 'active'; ?>"
            href="about.php">About</a>
        </li>

        <li>
            <a class="<?php if($page=='contact') echo 'active'; ?>"
            href="contact.php">Contact</a>
        </li>

        <!-- CART -->
        <li id="ig-bag">
            <a href="cart.php">
                <i class="fa-solid fa-cart-shopping"></i>

                <span class="cart-count">
                    <?php echo $count; ?>
                </span>
            </a>
        </li>

        <!-- CLOSE -->
        <a href="#" id="close">
            <i class="fa-solid fa-xmark"></i>
        </a>

    </ul>

    <!-- mobile -->
    <div id="mobile">

        <a href="cart.php">
            <i class="fa-solid fa-cart-shopping"></i>
        </a>

        <i id="bar" class="fas fa-bars"></i>

    </div>

</section>

<!-- PAGE HEADER -->
<section id="page-header">

    <h2>
        <?php
        if ($search !== '') {
            echo 'Search Results';
        } elseif ($selectedCategoryData) {
            echo htmlspecialchars($selectedCategoryData['name']);
        } else {
            echo 'Shop Products';
        }
        ?>
    </h2>

    <p>
        <?php
        if ($search !== '') {
            echo 'Showing products matching "' . htmlspecialchars($search) . '"';
        } elseif ($selectedCategoryData) {
            echo htmlspecialchars($selectedCategoryData['description']);
        } else {
            echo 'Choose a category and discover our products';
        }
        ?>
    </p>

</section>

<!-- PRODUCTS -->
<section id="product1" class="section-p1">

    <h2>
        <?php
        if ($search !== '') {
            echo 'Search: ' . htmlspecialchars($search);
        } elseif ($selectedCategoryData) {
            echo htmlspecialchars($selectedCategoryData['name']);
        } else {
            echo 'All Shop Products';
        }
        ?>
    </h2>

    <div class="pro-container">

    <?php

    if ($result && $result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
    ?>

        <div class="pro">

            <a href="product_details.php?id=<?php echo (int)$row['id']; ?>">
                <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
            </a>

            <div class="des">

                <a href="product_details.php?id=<?php echo (int)$row['id']; ?>">
                    <span><?php echo htmlspecialchars($row['name']); ?></span>

                    <h5><?php echo htmlspecialchars($row['description']); ?></h5>
                </a>

                <h4>KES <?php echo htmlspecialchars($row['price']); ?></h4>

            </div>

            <div class="buttons">

                <!-- ADD TO CART -->
                <button class="add-cart"
                data-id="<?php echo (int)$row['id']; ?>">

                    Add to Cart

                </button>

                <!-- BUY NOW -->
                <a href="cart.php?buy=<?php echo (int)$row['id']; ?>">

                    <button class="buy-now">

                        Buy Now

                    </button>

                </a>

            </div>

        </div>

    <?php
        }

    } else {

        echo "<p>No products available in this category at the moment.</p>";
    }
    ?>

    </div>

</section>

<!-- FOOTER -->
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

        <div class="follow">

            <h4>follow us</h4>

            <div class="icon">

                <i class="fa-brands fa-facebook"><a href=""></a></i>
                <i class="fa-brands fa-whatsapp"></i>
                <i class="fa-brands fa-tiktok"></i>
                <i class="fa-brands fa-twitter"></i>
                <i class="fa-brands fa-linkedin"></i>

            </div>

        </div>

    </div>

    <div class="col">

        <h4>About</h4>

        <a href="about.php">About us</a>
        <a href="about.php">Delivery information</a>
        <a href="#">privacy policy</a>
        <a href="#">Terms & conditions</a>
        <a href="contact.php">contact us</a>

    </div>

    <div class="col">

        <h4>Account Information</h4>

        <a href="login.php">my Account</a>
        <a href="register.php">sign in</a>
        <a href="cart.php">view cart</a>
        <a href="cart.php">track my order</a>
        <a href="contact.php">help</a>

    </div>

    <div class="col install">

        <h4>Install App</h4>

        <p>From App store or Google play</p>

        <div class="row">

            <img src="icons/WhatsApp Image 2026-03-10 at 3.01.21 PM.jpeg" alt="">

            <img src="icons/WhatsApp Image 2026-03-09 at 9.52.57 PM.jpeg" alt="">

        </div>

        <div class="secured">

            <p>Secured payment gateways</p>

            <img src="icons/Airtel Money Uganda Logo PNG Vector (PDF) Free Download.jpeg" alt="">

            <img src="icons/download.jpeg" alt="">

            <img src="icons/download.png" alt="">

        </div>

    </div>

    <div class="copyright">

            <p>© 2026 Gasgivers online market.all rights reserved</p>

    </div>

</footer>

<!-- JS -->
<script>

document.addEventListener("DOMContentLoaded", function () {

    <?php if ($search !== '') { ?>
    const productSection = document.getElementById("product1");

    if (productSection) {
        productSection.scrollIntoView({
            behavior: "smooth",
            block: "start"
        });
    }
    <?php } ?>

    /* ADD TO CART */

    document.querySelectorAll(".add-cart").forEach(button => {

        button.addEventListener("click", function (e) {

            e.preventDefault();

            let id = this.dataset.id;

            fetch("add_to_cart.php", {

                method: "POST",

                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },

                body: "id=" + encodeURIComponent(id)

            })

            .then(res => res.text())

            .then(count => {

                document.querySelectorAll(".cart-count").forEach(el => {

                    el.innerText = count;

                });

            })

            .catch(err => console.error("Cart error:", err));

        });

    });

    /* MOBILE NAVBAR */

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
