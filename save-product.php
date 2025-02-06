<?php
// save-product.php

// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id']) || !isset($_SESSION['email'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in.']);
    exit();
}

// Include the database connection
require_once 'db_conn.php';  // Ensure correct path to db_conn.php

// Get form data
$name = $_POST['name'] ?? '';
$price = $_POST['price'] ?? '';
$image = $_FILES['image'] ?? null;
$link = $_POST['link'] ?? '';
$category = $_POST['category'] ?? '';
$composition = $_POST['composition'] ?? '';  // Get composition
$productId = $_POST['id'] ?? null; // Get product ID to check if it's an update

// Validate the form data
if (empty($name) || empty($price) || empty($link) || empty($category) || empty($composition)) {  // Check for composition
    echo json_encode(['success' => false, 'error' => 'All fields are required.']);
    exit();
}

// Process image upload (if a new image is uploaded)
$imagePath = null;
if ($image && $image['error'] === 0) {
    $uploadDir = 'uploads/';
    $imagePath = $uploadDir . basename($image['name']);
    if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
        echo json_encode(['success' => false, 'error' => 'Failed to upload image.']);
        exit();
    }
}

// Check if it's an edit or insert
if ($productId) {
    // Update existing product
    $sql = "UPDATE products SET name = ?, price = ?, image = ?, link = ?, category = ?, composition = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $name, $price, $imagePath ?: '', $link, $category, $composition, $productId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'product' => [
            'id' => $productId,
            'name' => $name,
            'price' => $price,
            'image' => $imagePath ?: '', // Keep old image if none is uploaded
            'link' => $link,
            'category' => $category,
            'composition' => $composition, // Include composition in the response
            'visible' => 1 // Keep visible flag or update as necessary
        ]]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update product.']);
    }
} else {
    // Insert new product
    if (!$imagePath) {
        echo json_encode(['success' => false, 'error' => 'Image is required.']);
        exit();
    }

    $sql = "INSERT INTO products (name, price, image, link, category, composition) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $price, $imagePath, $link, $category, $composition);

    if ($stmt->execute()) {
        // Return success response with new product data
        $newProduct = [
            'id' => $stmt->insert_id,
            'name' => $name,
            'price' => $price,
            'image' => $imagePath,
            'link' => $link,
            'category' => $category,
            'composition' => $composition, // Include composition for the new product
            'visible' => 1  // Set default visibility to 1 (visible)
        ];
        echo json_encode(['success' => true, 'product' => $newProduct]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to save product to the database.']);
    }
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
