<?php include '../includes/db.php';
include 'auth.php';

$categories = [];
$categoryResult = $conn->query("SELECT id, name FROM categories ORDER BY id ASC");

if ($categoryResult) {
    while ($category = $categoryResult->fetch_assoc()) {
        $categories[] = $category;
    }
}
 ?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: Arial, sans-serif;
        }

        body{
            display:flex;
            min-height:100vh;
            background: linear-gradient(135deg, #4facfe, #ff4fd8);
        }

        /* SIDEBAR */
        .sidebar{
            width:250px;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            padding:30px 20px;
            color:white;
            box-shadow:0 0 20px rgba(0,0,0,0.2);
        }

        .sidebar h2{
            text-align:center;
            margin-bottom:40px;
            font-size:30px;
        }

        .sidebar a{
            display:block;
            padding:15px;
            margin-bottom:15px;
            text-decoration:none;
            color:white;
            border-radius:12px;
            transition:0.3s;
            font-weight:bold;
        }

        .sidebar a:hover{
            background:white;
            color:#ff4fd8;
            transform:translateX(5px);
        }

        /* MAIN CONTENT */
        .main{
            flex:1;
            padding:50px;
        }

        .main h1{
            color:white;
            margin-bottom:25px;
            font-size:40px;
            text-shadow:2px 2px 10px rgba(0,0,0,0.3);
        }

        /* CARD */
        .card{
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(12px);
            padding:35px;
            border-radius:20px;
            width:min(100%, 1050px);
            box-shadow:0 8px 25px rgba(0,0,0,0.2);
            color:white;
        }

        .form-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:30px;
            align-items:start;
        }

        .form-side h2{
            margin-bottom:20px;
            font-size:24px;
        }

        .card label{
            font-weight:bold;
            display:block;
            margin-bottom:8px;
            font-size:16px;
        }

        .card input,
        .card textarea,
        .card select{
            width:100%;
            padding:14px;
            border:none;
            border-radius:12px;
            margin-bottom:20px;
            outline:none;
            font-size:15px;
        }

        .card textarea{
            resize:none;
            height:120px;
        }

        .details-textarea{
            height:220px;
        }

        .char-count{
            display:block;
            margin:-14px 0 18px;
            font-size:12px;
            opacity:0.9;
            text-align:right;
        }

        .card input:focus,
        .card textarea:focus,
        .card select:focus{
            box-shadow:0 0 10px #fff;
        }

        /* BUTTON */
        .btn{
            background: linear-gradient(135deg, #00c6ff, #ff4fd8);
            color:white;
            border:none;
            padding:15px 25px;
            border-radius:12px;
            cursor:pointer;
            font-size:16px;
            font-weight:bold;
            transition:0.3s;
            width:100%;
        }

        .btn:hover{
            transform:scale(1.03);
            box-shadow:0 0 15px rgba(255,255,255,0.5);
        }

        /* RESPONSIVE */
        @media(max-width:768px){

            body{
                flex-direction:column;
            }

            .sidebar{
                width:100%;
            }

            .card{
                width:100%;
            }

            .form-grid{
                grid-template-columns:1fr;
            }

            .main{
                padding:20px;
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
    <a href="logout.php">logout</a>
</div>

<div class="main">

    <h1>Add New Product</h1>

    <form method="POST" enctype="multipart/form-data" class="card">

        <div class="form-grid">
            <div class="form-side">
                <h2>Main Product Info</h2>

                <label>Product Name</label>
                <input type="text" name="name" placeholder="Enter product name" required>

                <label>Price</label>
                <input type="number" name="price" placeholder="Enter product price" required>

                <label>Description</label>
                <textarea
                    name="description"
                    id="description"
                    maxlength="160"
                    placeholder="Write product description"
                ></textarea>
                <small class="char-count">
                    <span id="description-count">0</span>/160 characters
                </small>

                <label>Main Product Image</label>
                <input type="file" name="image" accept="image/*" required>

                <label>Display Location (0 = Home, 1 = Shop)</label>
                <select name="display_type" required>
                    <option value="1">Shop Page</option>
                    <option value="0">Home Page</option>
                </select>

                <div id="shop-category-field">
                    <label>Shop Section</label>
                    <select name="category_id" id="category">
                        <option value="">Select shop section</option>
                        <?php foreach ($categories as $category) { ?>
                            <option value="<?php echo $category['id']; ?>">
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-side">
                <h2>Product Details Page</h2>

                <label>More Product Details</label>
                <textarea class="details-textarea" name="product_details" placeholder="Add full product details, features, usage, delivery notes, or extra information"></textarea>

                <label>Sub Image 1</label>
                <input type="file" name="sub_image1" accept="image/*">

                <label>Sub Image 2</label>
                <input type="file" name="sub_image2" accept="image/*">

                <label>Sub Image 3</label>
                <input type="file" name="sub_image3" accept="image/*">
            </div>
        </div>

        <button type="submit" name="add" class="btn">
            Save Product
        </button>

    </form>

</div>

<script>
const displayType = document.querySelector('select[name="display_type"]');
const categoryField = document.getElementById("shop-category-field");
const categorySelect = document.getElementById("category");
const description = document.getElementById("description");
const descriptionCount = document.getElementById("description-count");

function toggleCategoryField() {
    const isShopPage = displayType.value === "1";

    categoryField.style.display = isShopPage ? "block" : "none";
    categorySelect.required = isShopPage;

    if (!isShopPage) {
        categorySelect.value = "";
    }
}

displayType.addEventListener("change", toggleCategoryField);
toggleCategoryField();

function updateDescriptionCount() {
    descriptionCount.innerText = description.value.length;
}

description.addEventListener("input", updateDescriptionCount);
updateDescriptionCount();
</script>

</body>
</html>

<?php

if (isset($_POST['add'])) {

    function uploadProductImage($fieldName) {
        if (empty($_FILES[$fieldName]['name'])) {
            return '';
        }

        $allowedTypes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/gif' => 'gif'
        ];

        if ($_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
            return '';
        }

        if ($_FILES[$fieldName]['size'] > 3 * 1024 * 1024) {
            die("Image is too large. Maximum size is 3MB.");
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($_FILES[$fieldName]['tmp_name']);

        if (!isset($allowedTypes[$mimeType])) {
            die("Only JPG, PNG, WEBP, and GIF images are allowed.");
        }

        $tmpName = $_FILES[$fieldName]['tmp_name'];
        $newImage = time() . "_" . bin2hex(random_bytes(6)) . "_" . $fieldName . "." . $allowedTypes[$mimeType];
        $uploadPath = "../uploads/" . $newImage;

        if (move_uploaded_file($tmpName, $uploadPath)) {
            return $newImage;
        }

        return '';
    }

    // 1. Get form data
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $product_details = $_POST['product_details'] ?? '';

    // ADDED ONLY
    $display_type = intval($_POST['display_type']);
    $category_id = !empty($_POST['category_id']) ? intval($_POST['category_id']) : null;

    if ($display_type === 0) {
        $category_id = null;
    } elseif (!$category_id) {
        die("Please select a valid shop section.");
    }

    $newImage = uploadProductImage('image');
    $subImage1 = uploadProductImage('sub_image1');
    $subImage2 = uploadProductImage('sub_image2');
    $subImage3 = uploadProductImage('sub_image3');

    if ($newImage !== '') {

        // 4. Insert into database (UPDATED ONLY HERE)
        $stmt = $conn->prepare("
            INSERT INTO products
            (name, price, description, product_details, image, sub_image1, sub_image2, sub_image3, display_type, category_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "sdssssssii",
            $name,
            $price,
            $description,
            $product_details,
            $newImage,
            $subImage1,
            $subImage2,
            $subImage3,
            $display_type,
            $category_id
        );

        if ($stmt->execute()) {

            echo "<script>
                alert('Product added successfully');
                window.location.href='add_product.php';
            </script>";

        } else {
            echo "Database error: " . $conn->error;
        }

        $stmt->close();

    } else {
        echo "Image upload failed";
    }
}

?>
