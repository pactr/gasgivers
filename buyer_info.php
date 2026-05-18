<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buyer Information</title>

    <style>
        body {
            margin: 0;
            font-family: Arial;
            height: 100vh;

            /* BLUE + PINK GRADIENT */
            background: linear-gradient(135deg, #4facfe, #ff4ecd);

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-box {
            background: white;
            padding: 30px;
            border-radius: 15px;
            width: 350px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #4facfe;
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background: #ff4ecd;
        }
    </style>
</head>

<body>

<div class="form-box">

    <h2>Buyer Information</h2>

    <!-- FIXED FORM -->
    <form action="check_out.php" method="POST">

        <input type="text" name="firstname" placeholder="First Name" required>

        <input type="text" name="lastname" placeholder="Last Name" required>

        <input type="email" name="email" placeholder="Email Address" required>

        <input type="text" name="phone" placeholder="Phone Number" required>

        <input type="text" name="location" placeholder="Hostel / Delivery Place" required>

        <button type="submit">Submit Order</button>

    </form>

</div>

</body>
</html>