<?php include '../includes/db.php';
include 'auth.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>

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
            text-shadow:2px 2px 10px rgba(0,0,0,0.3);
        }

        .sidebar a{
            display:block;
            padding:15px;
            margin-bottom:15px;
            border-radius:12px;
            text-decoration:none;
            color:white;
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
            text-shadow:2px 2px 10px rgba(0,0,0,0.3);
        }

        /* TABLE CONTAINER */

        .table-container{
            background:rgba(255,255,255,0.18);
            backdrop-filter:blur(12px);
            border-radius:20px;
            padding:20px;
            box-shadow:0 8px 25px rgba(0,0,0,0.2);
            overflow-x:auto;
        }

        table{
            width:100%;
            border-collapse:collapse;
            color:white;
        }

        table th{
            padding:18px;
            text-align:left;
            font-size:18px;
            background:rgba(255,255,255,0.2);
        }

        table td{
            padding:18px;
            border-bottom:1px solid rgba(255,255,255,0.2);
        }

        table tr:hover{
            background:rgba(255,255,255,0.08);
        }

        /* PRODUCT IMAGE */

        .product-img{
            width:70px;
            height:70px;
            object-fit:cover;
            border-radius:12px;
            border:3px solid white;
            box-shadow:0 5px 15px rgba(0,0,0,0.2);
        }

        /* BUTTONS */

        .btn{
            padding:10px 18px;
            border-radius:10px;
            text-decoration:none;
            color:white;
            font-weight:bold;
            display:inline-block;
            transition:0.3s;
        }

        .btn-edit{
            background:linear-gradient(135deg, #00c6ff, #0072ff);
            margin-right:10px;
        }

        .btn-delete{
            background:linear-gradient(135deg, #ff416c, #ff4fd8);
        }

        .btn:hover{
            transform:scale(1.05);
            box-shadow:0 0 12px rgba(255,255,255,0.5);
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

            table th,
            table td{
                padding:12px;
                font-size:14px;
            }

            .btn{
                margin-bottom:8px;
            }
        }

    </style>

</head>

<body>

<div class="sidebar">

    <h2>Admin</h2>

    <a href="dashboard.php">Dashboard</a>
    <a href="add_product.php">Add Product</a>
    <a href="manage_products.php">Manage Products</a>

</div>

<div class="main">

    <h1>Manage Products</h1>

    <div class="table-container">

        <table>

            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>

            <?php
            $result = $conn->query("SELECT * FROM products");

            while ($row = $result->fetch_assoc()) {
            ?>

            <tr>

                <td>
                    <img 
                        src="../uploads/<?php echo $row['image']; ?>" 
                        class="product-img"
                    >
                </td>

                <td>
                    <?php echo $row['name']; ?>
                </td>

                <td>
                    KES <?php echo $row['price']; ?>
                </td>

                <td>

                    <a 
                        class="btn btn-edit" 
                        href="edit_product.php?id=<?php echo $row['id']; ?>"
                    >
                        Edit
                    </a>

                    <a 
                        class="btn btn-delete"
                        href="delete_product.php?id=<?php echo $row['id']; ?>"
                        onclick="return confirm('Delete this product?')"
                    >
                        Delete
                    </a>

                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>