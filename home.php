<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id']) || !isset($_SESSION['email'])) {
    header("Location: 1234567890.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manage Blogs and Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .tabs {
            display: flex;
            border-bottom: 2px solid #ddd;
        }

        .tab {
            flex: 1;
            text-align: center;
            padding: 15px;
            cursor: pointer;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-bottom: none;
        }

        .tab.active {
            background: #007bff;
            color: white;
        }

        .content {
            display: none;
        }

        .content.active {
            display: block;
        }

        form {
            margin-bottom: 20px;
        }

        form input, form textarea, form select, form button {
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        form button {
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .item {
            border: 1px solid #ddd;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            background: #f9f9f9;
        }

        .item h3 {
            margin: 0 0 10px;
        }

        .item button {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        .edit-btn {
            background: #28a745;
            color: white;
        }

        .delete-btn {
            background: #dc3545;
            color: white;
        }

        .logout-btn {
            position: absolute;
            top: 10px;
            right: 20px;
            background-color: #dc3545;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #b71c1c;
        }
    </style>
</head>
<body>
    <!-- Logout Button -->
    <a href="logout.php" class="logout-btn">Logout</a>

    <!-- Admin Panel Header -->
    <h1>Admin Panel</h1>
    <div class="container">
        <div class="tabs">
            <div class="tab active" onclick="switchTab('blogs')">Manage Blogs</div>
            <div class="tab" onclick="switchTab('products')">Manage Products</div>
        </div>

        <!-- Blogs Management Section -->
        <div id="blogs" class="content active">
            <h2>Manage Blogs</h2>
            <form id="blog-form">
                <input type="hidden" id="blog-id">
                <input type="text" id="blog-title" placeholder="Title" required>
                <textarea id="blog-description" placeholder="Short Description" required></textarea>
                <textarea id="blog-content" placeholder="Content" required></textarea>
                <input type="text" id="blog-image" placeholder="Image URL" required>
                <button type="submit">Save Blog</button>
            </form>
            <div id="blog-list"></div>
        </div>

        <!-- Products Management Section -->
        <div id="products" class="content">
            <h2>Manage Products</h2>
            <form id="product-form">
                <input type="hidden" id="product-id">
                <input type="text" id="product-name" placeholder="Product Name" required>
                <input type="number" id="product-price" placeholder="Price" step="0.01" required>
                <input type="text" id="product-image" placeholder="Image URL" required>
                <input type="text" id="product-link" placeholder="Product Page Link" required>
                <select id="product-category" required>
                    <option value="">Select Category</option>
                    <option value="LIQUID NPK">LIQUID NPK</option>
                    <option value="AMINOS ACIDS">AMINOS ACIDS</option>
                    <option value="SEAWEED EXTRACTS">SEAWEED EXTRACTS</option>
                </select>
                <button type="submit">Save Product</button>
            </form>
            <div id="product-list"></div>
        </div>
    </div>

    <script>
        let blogs = [];
        let products = [];

        // Switch Tabs
        function switchTab(tab) {
            document.querySelectorAll('.tab, .content').forEach(element => {
                element.classList.remove('active');
            });
            document.querySelector(`.tab[onclick="switchTab('${tab}')"]`).classList.add('active');
            document.getElementById(tab).classList.add('active');
        }

        // Example JS for managing blogs/products (adjust based on your backend)
        function renderBlogs() {
            const blogList = document.getElementById('blog-list');
            blogList.innerHTML = blogs.map(blog => `
                <div class="item">
                    <h3>${blog.title}</h3>
                    <p>${blog.description}</p>
                </div>
            `).join('');
        }

        function renderProducts() {
            const productList = document.getElementById('product-list');
            productList.innerHTML = products.map(product => `
                <div class="item">
                    <h3>${product.name}</h3>
                    <p>Price: $${product.price}</p>
                </div>
            `).join('');
        }
    </script>
</body>
</html>
