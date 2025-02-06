<?php
header('Content-Type: application/json');

$conn = new mysqli('localhost', 'ayman', 'ayman', 'elanbi');

// Check for connection errors
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed!']);
    exit();
}

// Get the data from the request
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    $id = $data['id'];

    $sql = "DELETE FROM products WHERE id='$id'";

    if ($conn->query($sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input!']);
}

$conn->close();
?>
