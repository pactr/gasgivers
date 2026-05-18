<?php
include '../includes/db.php';
include 'auth.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* DATABASE CONNECTION */
$conn = new mysqli("localhost", "root", "", "gasgivers_enterprise");

/* CHECK CONNECTION */
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/* CHECK ADMIN */
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

/* TOTAL PRODUCTS */
$result = $conn->query("SELECT COUNT(*) AS total FROM products");
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, sans-serif;
        }

        body{
            display:flex;
            min-height:100vh;
            background:linear-gradient(135deg, #4facfe, #ff4fd8);
        }

        /* SIDEBAR */
        .sidebar{
            width:260px;
            height:100vh;
            position:fixed;
            padding:30px 20px;
            background:rgba(255,255,255,0.15);
            backdrop-filter:blur(12px);
            box-shadow:0 0 20px rgba(0,0,0,0.2);
        }

        .sidebar h2{
            color:white;
            text-align:center;
            margin-bottom:40px;
            font-size:32px;
        }

        .sidebar a{
            display:block;
            color:white;
            text-decoration:none;
            padding:15px;
            margin-bottom:15px;
            border-radius:12px;
            font-weight:bold;
            transition:0.3s;
        }

        .sidebar a:hover{
            background:white;
            color:#ff4fd8;
            transform:translateX(5px);
        }

        /* MAIN */
        .main{
            margin-left:260px;
            width:100%;
            padding:40px;
        }

        .main h1{
            color:white;
            font-size:42px;
            margin-bottom:30px;
        }

        /* CARD */
        .card{
            width:280px;
            padding:30px;
            border-radius:20px;
            background:rgba(255,255,255,0.2);
            backdrop-filter:blur(12px);
            box-shadow:0 8px 25px rgba(0,0,0,0.2);
            color:white;
            transition:0.3s;
        }

        .card:hover{
            transform:translateY(-5px);
        }

        .card h3{
            margin-bottom:10px;
        }

        .card p{
            font-size:50px;
            font-weight:bold;
        }

        /* GRID */
        .grid{
            display:flex;
            gap:20px;
        }

        /* RESPONSIVE */
        @media(max-width:768px){
            body{
                flex-direction:column;
            }

            .sidebar{
                width:100%;
                height:auto;
                position:relative;
            }

            .main{
                margin-left:0;
                padding:20px;
            }

            .grid{
                flex-direction:column;
            }
        }

    </style>
</head>

<body>

<div class="sidebar">
    <h2>Admin Panel</h2>

    <a href="dashboard.php">Dashboard</a>
    <a href="add_product.php">Add Product</a>
    <a href="manage_products.php">Manage Products</a>
     <a href="delete_product.php">Delete Product</a>
      <a href="edit_product.php">Edit Product</a>
    <a href="logout.php">Logout</a>
   
</div>

<div class="main">

    <h1>Dashboard</h1>

    <div class="grid">

        <div class="card">
            <h3>Total Products</h3>
            <p><?php echo $row['total']; ?></p>
        </div>

    </div>

</div>

</body>
</html>