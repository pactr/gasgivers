<<<<<<< HEAD
<?php
session_start();

/* CLEAR CART AFTER SUCCESSFUL ORDER */
unset($_SESSION['cart']);



/* GET DATA FROM FORM */
$firstname = $_POST['firstname'] ?? 'Customer';
$lastname  = $_POST['lastname'] ?? '';

$fullName = $firstname . " " . $lastname;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thank You</title>

    <style>
        body {
            margin: 0;
            font-family: Arial;
            height: 100vh;

            /* SAME GRADIENT AS BUYER PAGE */
            background: linear-gradient(135deg, #4facfe, #ff4ecd);

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .box {
            background: white;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        h1 {
            color: #333;
        }

        p {
            color: #555;
        }

        .status {
            margin-top: 20px;
            text-align: left;
        }

        .step {
            padding: 8px;
            margin: 5px 0;
            border-left: 4px solid #4facfe;
            background: #f5f5f5;
            border-radius: 5px;
        }

        .active {
            border-left: 4px solid #ff4ecd;
            font-weight: bold;
        }

        .btn {
            margin-top: 20px;
            display: inline-block;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            color: white;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        @media (min-width: 480px) {
            .btn {
                width: auto;
                margin-bottom: 0;
                margin-right: 10px;
            }
        }

        .home {
            background: #4facfe;
        }

        .shop {
            background: #ff4ecd;
        }
    </style>
</head>

<body>

<div class="box">

    <h1>Thank you <?php echo $fullName; ?> 🎉</h1>

    <p>We have received your order successfully.</p>

    <!-- ORDER STATUS -->
    <div class="status">
        <div class="step active">✔ Order Received</div>
        <div class="step">⏳ In Shipment</div>
        <div class="step">📦 Out for Delivery</div>
        <div class="step">🏁 Delivered</div>
    </div>

    <!-- BUTTONS -->
    <a href="index.php" class="btn home">Back to Home</a>
    <a href="shop.php" class="btn shop">Continue Shopping</a>
    <a href="cancel_order.php" class="btn" style="background: #ff4444;">Cancel Order</a>

</div>

</body>
=======
<?php
session_start();

/* CLEAR CART AFTER SUCCESSFUL ORDER */
unset($_SESSION['cart']);



/* GET DATA FROM FORM */
$firstname = $_POST['firstname'] ?? 'Customer';
$lastname  = $_POST['lastname'] ?? '';

$fullName = $firstname . " " . $lastname;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thank You</title>

    <style>
        body {
            margin: 0;
            font-family: Arial;
            height: 100vh;

            /* SAME GRADIENT AS BUYER PAGE */
            background: linear-gradient(135deg, #4facfe, #ff4ecd);

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .box {
            background: white;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        h1 {
            color: #333;
        }

        p {
            color: #555;
        }

        .status {
            margin-top: 20px;
            text-align: left;
        }

        .step {
            padding: 8px;
            margin: 5px 0;
            border-left: 4px solid #4facfe;
            background: #f5f5f5;
            border-radius: 5px;
        }

        .active {
            border-left: 4px solid #ff4ecd;
            font-weight: bold;
        }

        .btn {
            margin-top: 20px;
            display: inline-block;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            color: white;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        @media (min-width: 480px) {
            .btn {
                width: auto;
                margin-bottom: 0;
                margin-right: 10px;
            }
        }

        .home {
            background: #4facfe;
        }

        .shop {
            background: #ff4ecd;
        }
    </style>
</head>

<body>

<div class="box">

    <h1>Thank you <?php echo $fullName; ?> 🎉</h1>

    <p>We have received your order successfully.</p>

    <!-- ORDER STATUS -->
    <div class="status">
        <div class="step active">✔ Order Received</div>
        <div class="step">⏳ In Shipment</div>
        <div class="step">📦 Out for Delivery</div>
        <div class="step">🏁 Delivered</div>
    </div>

    <!-- BUTTONS -->
    <a href="index.php" class="btn home">Back to Home</a>
    <a href="shop.php" class="btn shop">Continue Shopping</a>
    <a href="cancel_order.php" class="btn" style="background: #ff4444;">Cancel Order</a>

</div>

</body>
>>>>>>> aeab546 (Updated deployment configuration)
</html>