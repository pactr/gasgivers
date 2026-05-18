<?php
include '../includes/db.php';
include 'auth.php';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: manage_products.php');
    exit();
}

$stmt = $conn->prepare('SELECT image FROM products WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $imagePath = '../uploads/' . $row['image'];
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
    $deleteStmt = $conn->prepare('DELETE FROM products WHERE id = ?');
    $deleteStmt->bind_param('i', $id);
    $deleteStmt->execute();
    $deleteStmt->close();
}
$stmt->close();

header('Location: manage_products.php');
exit();
