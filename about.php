<?php
session_start();

$page = 'about';

/* CART COUNT */
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$count = count($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

    <title>About</title>

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
        alt=""
        style="width: 90px; height: auto;">

    </a>

    <div>

        <ul id="navbar">

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

            <!-- CLOSE BUTTON -->
            <a href="#" id="close">

                <i class="fa-solid fa-xmark"></i>

            </a>

        </ul>

    </div>

    <!-- MOBILE -->
    <div id="mobile">

        <a href="cart.php">
            <i class="fa-solid fa-cart-shopping"></i>
        </a>

        <i id="bar" class="fas fa-bars"></i>

    </div>

</section>

<!-- PAGE HEADER -->
<section id="page-header">

    <h2>#know more</h2>

    <p>Learn more about us and our products!</p>

</section>

<!-- ABOUT -->
<section id="About-head" class="section-p1">

    <img src="assets/about-us-support-help-ask-question-concept.jpg" alt="">

    <div>

        <h2>Who We Are</h2>

        <p>
            We are a leading online retailer dedicated to providing our
            customers with a wide range of high-quality products at
            competitive prices. Our mission is to make shopping easy,
            convenient, and enjoyable for everyone.
        </p>

        <abbr title="we">
            Our products are original and reliable. We deliver countrywide.
        </abbr>

        <br><br>

        <marquee bgColor="lightgreen"
        loop="1"
        scrollAmount="5"
        width="100%">

            Our products are original and reliable. We deliver countrywide.

        </marquee>

    </div>

</section>

<!-- FOOTER -->
<footer class="section-p1 section-m1">

    <div class="col">

        <img class="logo"
        src="logo/234846098-removebg-preview.png">

        <p><strong>Adress:</strong> 60200 Meru Road, street 7, meru town</p>
        <p><strong>Phone:+254-</strong>115072559</p>
        <p><strong>opening hours:</strong> 8:00 - 16:50 mon - sat</p>

        <div class="follow">

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

<!-- MOBILE NAVBAR FIX -->
<script>

document.addEventListener("DOMContentLoaded", function () {

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
