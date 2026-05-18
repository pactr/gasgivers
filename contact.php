<?php
session_start();
include 'includes/db.php';

$page = 'contact';

/* CART COUNT FIX */
$count = 0;
if (isset($_SESSION['cart'])) {
    $count = count($_SESSION['cart']);
}

/* FORM SUBMISSION */
if (isset($_POST['send'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Please enter a valid email address');</script>";
    } else {
        $stmt = $conn->prepare("
            INSERT INTO contact_messages (name, email, subject, message)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        if ($stmt->execute()) {
            echo "<script>alert('Message sent successfully');</script>";
        } else {
            echo "<script>alert('Message could not be sent. Please try again.');</script>";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>

    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

<!-- HEADER -->
<section id="header">

    <a href="#">
        <img src="logo/234846098-removebg-preview.png" class="logo" style="width:90px;">
    </a>

    <div>
        <ul id="navbar">

            <li><a class="<?php if($page=='home') echo 'active'; ?>" href="index.php">Home</a></li>
            <li><a class="<?php if($page=='shop') echo 'active'; ?>" href="shop.php">Shop</a></li>
            <li><a class="<?php if($page=='about') echo 'active'; ?>" href="about.php">About</a></li>
            <li><a class="<?php if($page=='contact') echo 'active'; ?>" href="contact.php">Contact</a></li>

            <!-- CART -->
            <li id="ig-bag">
                <a href="cart.php">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="cart-count"><?php echo $count; ?></span>
                </a>
            </li>

            <!-- CLOSE ICON -->
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
    <h2>#Let's talk.</h2>
    <p>LEAVE A MESSAGE, we would love to hear from you.</p>
</section>

<!-- CONTACT DETAILS -->
<section id="contact-details" class="section-p1">

    <div class="details">
        <h2>GET IN TOUCH</h2>
        <p>Visit one of our locations or contact us today</p>

        <li><i class="fa-solid fa-map"></i> 40600 Bondo, auditorium street</li>
        <li><i class="fa-solid fa-phone"></i> +254 742601781</li>
        <li><i class="fa-solid fa-envelope"></i> davymogaka221@gmail.com</li>
    </div>

    <div class="map">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d543.3125939723778!2d34.259518605192234!3d-0.09557443564596807!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19d55b0014cf8007%3A0x637b317212d9914a!2sgas%20givers%20enterprises%20shop!5e1!3m2!1sen!2ske!4v1777968754384!5m2!1sen!2ske"
            width="600"
            height="450"
            style="border:0;"
            allowfullscreen=""
            loading="eager">
        </iframe>
    </div>

</section>

<!-- FORM -->
<section id="form-details">

    <form action="contact.php" method="POST">

        <span>LEAVE A MESSAGE</span>
        <h2>We love to hear from you</h2>

        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="text" name="subject" placeholder="Subject">

        <textarea name="message" rows="10" placeholder="Your Message" required></textarea>

        <button type="submit" name="send">Submit</button>

    </form>

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
