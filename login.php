
<?php
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();
include 'includes/db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

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

        .login-box {
            background: white;
            padding: 40px;
            width: 320px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            text-align: center;
        }

        .login-box h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .login-box input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
            box-sizing: border-box;
        }

        .login-box button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #1e90ff, #ff4fd8);
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-box button:hover {
            opacity: 0.85;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        .register-link {
            margin-top: 15px;
        }

        .register-link a {
            color: #ff4fd8;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="login-box">

    <h2>Login</h2>

    <form method="POST">

        <input 
            type="text" 
            name="username" 
            placeholder="Username" 
            required
        >

        <input 
            type="password" 
            name="password" 
            placeholder="Password" 
            required
        >

        <button type="submit" name="login">
            Login
        </button>

    </form>

<?php


if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows == 1) {

        $user = $result->fetch_assoc();
        $storedPassword = $user['password'];

        if (password_verify($password, $storedPassword)) {

            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: shop.php");
            }
            exit();

        } else {
            echo "Invalid username or password";
        }

    } else {
        echo "Invalid username or password";
    }

    $stmt->close();
}
?>
<div class="register-link">
    <p>
        Don't have an account?
        <a href="register.php">
            Register
        </a>
    </p>
</div>

</div>

</body>
</html>
