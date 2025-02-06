<?php
header('Content-Type: application/json');

// Database connection
$conn = new mysqli('localhost', 'ayman', 'ayman', 'elanbi');

// Check for database connection error
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Get the product ID and visibility status
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];
$visible = $data['visible'] ? 1 : 0; // Convert visibility to 1 (visible) or 0 (hidden)

// Update the product visibility
$sql = "UPDATE products SET visible = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $visible, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to update visibility']);
}

$stmt->close();
$conn->close();
?>
