 <?php
session_start();

/* 1. CHECK IF USER IS LOGGED IN */
if (!isset($_SESSION['user_id'])) {

    header("Location: ../login.php");
    exit();
}

/* 2. CHECK IF USER IS ADMIN */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {

    header("Location: ../shop.php");
    exit();
}
?>