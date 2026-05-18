<?php
include '../includes/db.php';
include 'auth.php';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: manage_products.php');
    exit();
}

if (isset($_POST['update'])) {
    $name = $conn->real_escape_string($_POST['name'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $desc = $conn->real_escape_string($_POST['description'] ?? '');

    if (!empty($_FILES['image']['name'])) {
        $allowedTypes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/gif' => 'gif'
        ];

        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            die('Image upload failed.');
        }

        if ($_FILES['image']['size'] > 3 * 1024 * 1024) {
            die('Image is too large. Maximum size is 3MB.');
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($_FILES['image']['tmp_name']);

        if (!isset($allowedTypes[$mimeType])) {
            die('Only JPG, PNG, WEBP, and GIF images are allowed.');
        }

        $image = time() . '_' . bin2hex(random_bytes(6)) . '_image.' . $allowedTypes[$mimeType];
        $tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp, '../uploads/' . $image);

        $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, description = ?, image = ? WHERE id = ?");
        $stmt->bind_param('sdssi', $name, $price, $desc, $image, $id);
    } else {
        $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, description = ? WHERE id = ?");
        $stmt->bind_param('sdsi', $name, $price, $desc, $id);
    }

    $stmt->execute();
    $stmt->close();

    header('Location: manage_products.php');
    exit();
}

$stmt = $conn->prepare('SELECT * FROM products WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    header('Location: manage_products.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, sans-serif;
        }

        body{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background:linear-gradient(135deg, #4facfe, #ff4fd8);
            padding:30px;
        }

        .main{
            width:100%;
            max-width:600px;
        }

        .card{
            background:rgba(255,255,255,0.2);
            backdrop-filter:blur(12px);
            padding:35px;
            border-radius:25px;
            box-shadow:0 8px 25px rgba(0,0,0,0.2);
            color:white;
            animation:fadeIn 0.7s ease;
        }

        h1{
            text-align:center;
            margin-bottom:25px;
            color:white;
            font-size:40px;
            text-shadow:2px 2px 10px rgba(0,0,0,0.3);
        }

        .card input,
        .card textarea{
            width:100%;
            padding:15px;
            border:none;
            border-radius:12px;
            margin-bottom:20px;
            font-size:16px;
            outline:none;
        }

        .card textarea{
            height:120px;
            resize:none;
        }

        .card input:focus,
        .card textarea:focus{
            box-shadow:0 0 10px white;
        }

        .image-box{
            text-align:center;
            margin-bottom:20px;
        }

        .image-box p{
            margin-bottom:10px;
            font-size:18px;
            font-weight:bold;
        }

        .image-box img{
            width:140px;
            height:140px;
            object-fit:cover;
            border-radius:15px;
            border:4px solid white;
            box-shadow:0 5px 15px rgba(0,0,0,0.2);
        }

        .btn{
            width:100%;
            padding:15px;
            border:none;
            border-radius:12px;
            background:linear-gradient(135deg, #00c6ff, #ff4fd8);
            color:white;
            font-size:18px;
            font-weight:bold;
            cursor:pointer;
            transition:0.3s;
        }

        .btn:hover{
            transform:scale(1.03);
            box-shadow:0 0 15px rgba(255,255,255,0.5);
        }

        @keyframes fadeIn{
            from{
                opacity:0;
                transform:translateY(20px);
            }
            to{
                opacity:1;
                transform:translateY(0);
            }
        }

        @media(max-width:768px){
            h1{
                font-size:30px;
            }

            .card{
                padding:25px;
            }
        }
    </style>
</head>
<body>
<div class="main">
    <h1>Edit Product</h1>
    <form method="POST" enctype="multipart/form-data" class="card">
        <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        <input type="number" name="price" step="0.01" value="<?php echo htmlspecialchars($product['price']); ?>" required>
        <textarea name="description"><?php echo htmlspecialchars($product['description']); ?></textarea>
        <div class="image-box">
            <p>Current Image</p>
            <img src="../uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image">
        </div>
        <input type="file" name="image" accept="image/*">
        <button type="submit" name="update" class="btn">Update Product</button>
    </form>
</div>
</body>
</html>
