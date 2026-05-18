<?php include 'includes/db.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #1e90ff, #ff4fd8);
        }

        .register-box {
            background: white;
            padding: 40px;
            width: 350px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            text-align: center;
        }

        .register-box h2 {
            margin-bottom: 20px;
        }

        .register-box input,
        .register-box select {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
        }

        .register-box button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #1e90ff, #ff4fd8);
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
        }

        .register-box button:hover {
            opacity: 0.85;
        }
    </style>
</head>

<body>

<div class="register-box">

    <h2>Register</h2>

    <form method="POST">

        <input type="text" name="username" placeholder="Username" required>

        <!-- ✅ NEW: Phone number -->
        <input type="text" name="phone" placeholder="Phone Number" required>

        <!-- ✅ NEW: Gender -->
        <select name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="register">Sign Up</button>

    </form>

<?php
if (isset($_POST['register'])) {

    $username = trim($_POST['username']);
    $phone = trim($_POST['phone']);
    $gender = $_POST['gender'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (!in_array($gender, ['Male', 'Female'], true)) {
        echo "Invalid gender selected.";
    } else {
        $stmt = $conn->prepare("
            INSERT INTO users (username, phone, gender, password, role)
            VALUES (?, ?, ?, ?, 'user')
        ");

        $stmt->bind_param("ssss", $username, $phone, $gender, $password);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            echo "Registration failed. Please try another username.";
        }

        $stmt->close();
    }
}
?>

</div>

</body>
</html>
