<?php
include 'includes/db.php';

// Add status column to orders table
$sql = "ALTER TABLE orders ADD COLUMN status VARCHAR(50) DEFAULT 'pending' AFTER location";

if ($conn->query($sql) === TRUE) {
    echo "Status column added successfully to orders table.<br>";
} else {
    echo "Error adding status column: " . $conn->error . "<br>";
}

// Check if column exists
$result = $conn->query("DESCRIBE orders");
$columnExists = false;

while ($row = $result->fetch_assoc()) {
    if ($row['Field'] == 'status') {
        $columnExists = true;
        break;
    }
}

if ($columnExists) {
    echo "Status column exists in orders table.<br>";
} else {
    echo "Status column does not exist in orders table.<br>";
}

echo "<br><a href='index.php'>Go to Home Page</a>";
?>
