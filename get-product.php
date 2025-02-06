<?php
header('Content-Type: application/json');

// Database connection
$conn = new mysqli('localhost', 'ayman', 'ayman', 'elanbi');

// Check for database connection error
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Get the product ID from the query string
$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($productId <= 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid product ID']);
    exit();
}

// Fetch the product details from the database
$sql = "SELECT id, name, price, composition , image, link, category FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $productId);
$stmt->execute();
$result = $stmt->get_result();

$product = $result->fetch_assoc();

if ($product) {
    // Return product data as JSON
    echo json_encode($product);
} else {
    echo json_encode(['success' => false, 'error' => 'Product not found']);
}

$conn->close();
?>
