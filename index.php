<<<<<<< HEAD
<?php
session_start();
include 'includes/db.php';

$page = 'home';

/* INIT CART SAFETY */
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$count = count($_SESSION['cart']);
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>GasGivers Enterprise</title>

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
        style="width:110px; height:auto;">
    </a>

    <div>

        <!-- SEARCH BAR - Moved outside navbar to stay on top -->
        <form action="shop.php#product1" method="GET" class="search-form">

            <input
                type="text"
                name="search"
                placeholder="Search products..."
            >

            <button type="submit">
                <i class="fas fa-search"></i>
            </button>

        </form>

        <ul id="navbar">

            <li><a class="<?php if($page=='home') echo 'active'; ?>" href="index.php">Home</a></li>
            <li><a class="<?php if($page=='shop') echo 'active'; ?>" href="shop.php">Shop</a></li>
            <li><a class="<?php if($page=='about') echo 'active'; ?>" href="about.php">About</a></li>
            <li><a class="<?php if($page=='contact') echo 'active'; ?>" href="contact.php">Contact</a></li>


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

    </div>

    <div id="mobile">

        <a href="cart.php">
            <i class="fa-solid fa-cart-shopping"></i>
        </a>

        <i id="bar" class="fas fa-bars"></i>

    </div>

</section>

<!-- HERO -->
<section id="hero">

    <h4>Best offer</h4>
    <h2>Super value deals</h2>
    <h1>On all products</h1>
    <p>Save more with coupons & up to 50% off!</p>

    <button>
        <a href="login.php">register Now</a>
    </button>

</section>

<!-- FEATURES -->
<section class="categories">



  <div class="category-card" onclick="goToCategory('Cleaning-products')">
    <img src="assets/download (9).jpeg" alt="Cleaning products">
    <p>Cleaning products</p>
  </div>

  <div class="category-card" onclick="goToCategory('General-products')">
    <img src="assets/download (8).jpeg" alt="General shop products">
    <p>General shop products</p>
  </div>
   <div class="category-card" onclick="goToCategory('school-stationaries')">
    <img src="assets/download (7).jpeg" alt="school stationaries">
    <p>school stationaries </p>
  </div>

  <div class="category-card" onclick="goToCategory('Drinks-Beverages')">
    <img src="assets/download (6).jpeg" alt="Drinks and Beverages">
    <p>Drinks and Beverages</p>
  </div>

  <div class="category-card" onclick="goToCategory('Beauty-products')">
    <img src="assets/download (5).jpeg" alt="Beauty products">
    <p>Beauty products</p>
  </div>

  <div class="category-card" onclick="goToCategory('Grains-cereals')">
    <img src="assets/download (4).jpeg" alt="Grains and cereals">
    <p>Grains and cereals</p>
  </div>
   <div class="category-card" onclick="goToCategory('Electronics')">
    <img src="assets/download (3).jpeg" alt="Electronics">
    <p>Electronics</p>
  </div>

  <div class="category-card" onclick="goToCategory('accessories')">
    <img src="assets/download (2).jpeg" alt="Accessories">
    <p>Accessories</p>
  </div>
   <div class="category-card" onclick="goToCategory('fashion')">
    <img src="assets/download (1).jpeg" alt="Fashion">
    <p>Fashion</p>
  </div>

  <div class="category-card" onclick="goToCategory('cooking-appliances')">
    <img src="assets/download.jpeg" alt="gas and cooking appliances">
    <p>gas and cooking appliances</p>
  </div>

</section>

<!-- BANNER -->
<section id="banner" class="section-m1">
    <h4>BEST GAS PRODUCTS</h4>
    <p>Up to <span>70% off</span> - All accessories</p>
    <button><a href="shop.php">Shop Now</a></button>
</section>

<!-- PRODUCTS -->
<section id="product1" class="section-p1">

    <div class="pro-container">

<?php

$result = $conn->query("
SELECT * FROM products
WHERE display_type = 0
ORDER BY id DESC
");

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
                <button class="add-cart" data-id="<?php echo (int)$row['id']; ?>">
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
    echo "<p>No products available at the moment.</p>";
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
               <a href="about.php">About us</a>
                <a href="about.php">Delivery information</a>
                 <a href="#">privacy policy</a>
                  <a href="#">Terms & conditions</a>
                   <a href="contact.php">contact us</a>
          </div>
          
            <div class ="col">
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
               <p>© 2026 Gasgivers online market.all rights reserved</p>
          </div>
          
    </footer>

<!-- ✅ FIX: SAME AJAX AS SHOP PAGE -->
<script>
function goToCategory(category) {
    window.location.href = "shop.php?category=" + encodeURIComponent(category);
}

document.addEventListener("DOMContentLoaded", function () {

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

            });

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
=======
<?php
session_start();
include 'includes/db.php';

$page = 'home';

/* INIT CART SAFETY */
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$count = count($_SESSION['cart']);
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>GasGivers Enterprise</title>

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
        style="width:110px; height:auto;">
    </a>

    <div>

        <!-- SEARCH BAR - Moved outside navbar to stay on top -->
        <form action="shop.php#product1" method="GET" class="search-form">

            <input
                type="text"
                name="search"
                placeholder="Search products..."
            >

            <button type="submit">
                <i class="fas fa-search"></i>
            </button>

        </form>

        <ul id="navbar">

            <li><a class="<?php if($page=='home') echo 'active'; ?>" href="index.php">Home</a></li>
            <li><a class="<?php if($page=='shop') echo 'active'; ?>" href="shop.php">Shop</a></li>
            <li><a class="<?php if($page=='about') echo 'active'; ?>" href="about.php">About</a></li>
            <li><a class="<?php if($page=='contact') echo 'active'; ?>" href="contact.php">Contact</a></li>


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

    </div>

    <div id="mobile">

        <a href="cart.php">
            <i class="fa-solid fa-cart-shopping"></i>
        </a>

        <i id="bar" class="fas fa-bars"></i>

    </div>

</section>

<!-- HERO -->
<section id="hero">

    <h4>Best offer</h4>
    <h2>Super value deals</h2>
    <h1>On all products</h1>
    <p>Save more with coupons & up to 50% off!</p>

    <button>
        <a href="login.php">register Now</a>
    </button>

</section>

<!-- FEATURES -->
<section class="categories">



  <div class="category-card" onclick="goToCategory('Cleaning-products')">
    <img src="assets/download (9).jpeg" alt="Cleaning products">
    <p>Cleaning products</p>
  </div>

  <div class="category-card" onclick="goToCategory('General-products')">
    <img src="assets/download (8).jpeg" alt="General shop products">
    <p>General shop products</p>
  </div>
   <div class="category-card" onclick="goToCategory('school-stationaries')">
    <img src="assets/download (7).jpeg" alt="school stationaries">
    <p>school stationaries </p>
  </div>

  <div class="category-card" onclick="goToCategory('Drinks-Beverages')">
    <img src="assets/download (6).jpeg" alt="Drinks and Beverages">
    <p>Drinks and Beverages</p>
  </div>

  <div class="category-card" onclick="goToCategory('Beauty-products')">
    <img src="assets/download (5).jpeg" alt="Beauty products">
    <p>Beauty products</p>
  </div>

  <div class="category-card" onclick="goToCategory('Grains-cereals')">
    <img src="assets/download (4).jpeg" alt="Grains and cereals">
    <p>Grains and cereals</p>
  </div>
   <div class="category-card" onclick="goToCategory('Electronics')">
    <img src="assets/download (3).jpeg" alt="Electronics">
    <p>Electronics</p>
  </div>

  <div class="category-card" onclick="goToCategory('accessories')">
    <img src="assets/download (2).jpeg" alt="Accessories">
    <p>Accessories</p>
  </div>
   <div class="category-card" onclick="goToCategory('fashion')">
    <img src="assets/download (1).jpeg" alt="Fashion">
    <p>Fashion</p>
  </div>

  <div class="category-card" onclick="goToCategory('cooking-appliances')">
    <img src="assets/download.jpeg" alt="gas and cooking appliances">
    <p>gas and cooking appliances</p>
  </div>

</section>

<!-- BANNER -->
<section id="banner" class="section-m1">
    <h4>BEST GAS PRODUCTS</h4>
    <p>Up to <span>70% off</span> - All accessories</p>
    <button><a href="shop.php">Shop Now</a></button>
</section>

<!-- PRODUCTS -->
<section id="product1" class="section-p1">

    <div class="pro-container">

<?php

$result = $conn->query("
SELECT * FROM products
WHERE display_type = 0
ORDER BY id DESC
");

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
                <button class="add-cart" data-id="<?php echo (int)$row['id']; ?>">
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
    echo "<p>No products available at the moment.</p>";
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
               <a href="about.php">About us</a>
                <a href="about.php">Delivery information</a>
                 <a href="#">privacy policy</a>
                  <a href="#">Terms & conditions</a>
                   <a href="contact.php">contact us</a>
          </div>
          
            <div class ="col">
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
               <p>© 2026 Gasgivers online market.all rights reserved</p>
          </div>
          
    </footer>

<!-- ✅ FIX: SAME AJAX AS SHOP PAGE -->
<script>
function goToCategory(category) {
    window.location.href = "shop.php?category=" + encodeURIComponent(category);
}

document.addEventListener("DOMContentLoaded", function () {

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

            });

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
>>>>>>> aeab546 (Updated deployment configuration)
