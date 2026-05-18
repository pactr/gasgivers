<?php

$host = "sql108.infinityfree.com";
$user = "if0_41900616";
$password = "xW1!aP2#bQ3@cR4";
$database = "if0_41900616_gasgivers";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");

?>
