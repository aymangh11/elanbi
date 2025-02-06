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

// Fetch the blog to edit
if (isset($_GET['id'])) {
    $blog_id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = ?");
    $stmt->execute([$blog_id]);
    $blog = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$blog) {
        die("Blog not found.");
    }
}

// Handle form submission for editing the blog
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title'])) {
    // Sanitize and get the form data
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $content = htmlspecialchars($_POST['content']);
    $image = htmlspecialchars($_POST['image']);

    try {
        // Update the blog in the database
        $stmt = $pdo->prepare("UPDATE blogs SET title = ?, description = ?, content = ?, image_url = ? WHERE id = ?");
        $stmt->execute([$title, $description, $content, $image, $blog_id]);

        // Redirect to the admin panel or success page
        header("Location: home.php");
        exit;
    } catch (Exception $e) {
        echo "Error updating blog: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input, textarea {
            margin-bottom: 15px;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
            width: 100%;
        }
        input[type="text"] {
            height: 45px;
        }
        textarea {
            min-height: 120px;
            resize: vertical;
        }
        input:focus, textarea:focus {
            outline: none;
            border-color: #007bff;
        }
        button {
            padding: 14px;
            background-color: #007bff;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Edit Blog Post</h1>

    <form method="POST">
        <div class="form-group">
            <input type="text" name="title" value="<?php echo htmlspecialchars(html_entity_decode($blog['title'])); ?>" placeholder="Enter blog title" required>
        </div>

        <div class="form-group">
            <textarea name="description" placeholder="Enter a short description" required><?php echo htmlspecialchars(html_entity_decode($blog['description'])); ?></textarea>
        </div>

        <div class="form-group">
            <textarea name="content" placeholder="Enter the full content" required><?php echo htmlspecialchars(html_entity_decode($blog['content'])); ?></textarea>
        </div>

        <div class="form-group">
            <input type="text" name="image" value="<?php echo htmlspecialchars(html_entity_decode($blog['image_url'])); ?>" placeholder="Enter image URL (optional)">
        </div>

        <button type="submit">Update Blog</button>
    </form>
</div>

</body>
</html>
