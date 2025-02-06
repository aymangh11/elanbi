<?php
header('Content-Type: application/json');

// Database connection
$conn = new mysqli('localhost', 'ayman', 'ayman', 'elanbi');

// Check for database connection error
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Fetch products from the database
$sql = "SELECT id, name, price, image, link, category, visible FROM products";
$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'price' => $row['price'],
            'image' => $row['image'],
            'link' => $row['link'],
            'category' => $row['category'],
            'visible' => (bool)$row['visible'], // Convert to boolean for clarity
        ];
    }
}

// Return products as JSON
echo json_encode($products);

$conn->close();
?>
