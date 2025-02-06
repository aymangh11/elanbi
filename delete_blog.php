<?php
// Database connection setup
$host = 'localhost';
$db = 'elanbi';
$user = 'ayman';
$pass = 'ayman';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

if (isset($_GET['id'])) {
    $blogId = (int)$_GET['id'];

    // Delete blog from the database
    try {
        $stmt = $pdo->prepare("DELETE FROM blogs WHERE id = ?");
        $stmt->execute([$blogId]);

        echo json_encode(["status" => "success", "message" => "Blog deleted successfully."]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Error deleting the blog."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
