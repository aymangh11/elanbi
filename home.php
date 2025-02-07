<?php
// Database connection setup
$host = 'localhost';
$db = 'elanbi';
$user = 'ayman';
$pass = 'ayman';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id']) || !isset($_SESSION['email'])) {
    header("Location: 1234567890.php");
    exit();
}
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Check if it's an AJAX request for saving the blog
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title'])) {
    // Sanitize and get the form data
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $content = htmlspecialchars($_POST['content']);
    
    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);
        $imageExtension = strtolower($imageExtension);

        // Check for valid image extensions (e.g., jpg, jpeg, png, gif)
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
        if (in_array($imageExtension, $allowedExtensions)) {
            $newImageName = uniqid('blog_', true) . '.' . $imageExtension;
            $imagePath = 'uploads/' . $newImageName;

            // Move the uploaded image to the 'uploads' folder
            if (move_uploaded_file($imageTmp, $imagePath)) {
                // Insert blog into the database with the image path
                try {
                    $stmt = $pdo->prepare("INSERT INTO blogs (title, description, content, image_url) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$title, $description, $content, $imagePath]);

                    // Fetch the newly inserted blog (to return its data for frontend)
                    $blog_id = $pdo->lastInsertId();
                    $stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = ?");
                    $stmt->execute([$blog_id]);
                    $new_blog = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Respond with success message and the new blog data
                    echo json_encode([ 
                        "status" => "success", 
                        "message" => "Blog saved successfully!", 
                        "blog" => $new_blog 
                    ]);
                } catch (Exception $e) {
                    // In case of error
                    echo json_encode(["status" => "error", "message" => "Error saving the blog."]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Error uploading the image."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid image file type."]);
        }
    } else {
        // No image uploaded, insert blog without image
        try {
            $stmt = $pdo->prepare("INSERT INTO blogs (title, description, content) VALUES (?, ?, ?)");
            $stmt->execute([$title, $description, $content]);

            // Fetch the newly inserted blog (to return its data for frontend)
            $blog_id = $pdo->lastInsertId();
            $stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = ?");
            $stmt->execute([$blog_id]);
            $new_blog = $stmt->fetch(PDO::FETCH_ASSOC);

            // Respond with success message and the new blog data
            echo json_encode([ 
                "status" => "success", 
                "message" => "Blog saved successfully!", 
                "blog" => $new_blog 
            ]);
        } catch (Exception $e) {
            // In case of error
            echo json_encode(["status" => "error", "message" => "Error saving the blog."]);
        }
    }

    exit; // Stop further PHP execution
}

// Fetch all blogs from the database (for initial page load)
$stmt = $pdo->query("SELECT * FROM blogs ORDER BY created_at DESC");
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Admin Panel - Manage Blogs</title>
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

        form input, form textarea, form button {
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

        #blogs-list {
            display: flex;
            flex-wrap: wrap; /* Allow items to wrap to the next line */
            gap: 20px; /* Space between blogs */
            margin: 20px;
        }

        /* Individual blog styling */
        .blog {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            max-width: 400px;
            width: calc(33.33% - 20px); /* Three blogs per row with a gap */
            box-sizing: border-box;
            position: relative;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            min-height: 380px; /* Ensures space for buttons */
            padding-bottom: 70px; /* Creates space at the bottom for buttons */
        }

        /* Hover effect */
        .blog:hover {
            transform: translateY(-5px);
        }

        /* Blog image styling */
        .blog img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            object-fit: cover;
            max-height: 150px;
            margin-bottom: 10px;
        }

        /* Blog title */
        .blog h2 {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin: 10px 0;
            text-align: left;
        }

        /* Buttons fixed at the bottom */
        .blog .buttons {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            width: 100%;
            justify-content: center;
            padding: 10px;
        }

        /* General button styles */
        .blog button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 12px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        /* Edit button */
        .edit-btn {
            background: #28a745;
        }

        .edit-btn:hover {
            background: #218838;
        }

        /* Delete button */
        .delete-btn {
            background:rgb(251, 0, 25);
        }

        .delete-btn:hover {
            background: #b71c1c;
        }

        /* Logout button (placed in the top-right corner) */
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

       /* Success message */
#success-message {
    background-color: #28a745;
    color: white;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 20px;
    display: none;  /* Initially hidden */
    opacity: 0;  /* Initially invisible */
    transition: opacity 0.5s ease-out;  /* Smooth fade-out effect */
}

@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

body {
    font-family: 'Roboto', sans-serif; /* Applying Roboto font */
    margin: 0;
    padding: 0;
    background-color: #f4f4f9;
    color: #333;
}

h1, h2 {
    font-family: 'Roboto', sans-serif;
    font-weight: 500; /* Slightly bolder font for headers */
}

input, select, button, textarea {
    font-family: 'Roboto', sans-serif; /* Ensuring the same font for form elements */
}

/* Adjust button style for better visibility */
button {
    font-family: 'Roboto', sans-serif;
}

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        .container {
            max-width: 700px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form input, form select, form button {
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        form input[type="file"] {
            padding: 5px;
        }

        form button {
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
        form .test {
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .notification {
            display: none;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .notification.success {
            background: #28a745;
            color: white;
        }

        .notification.error {
            background: #dc3545;
            color: white;
        }

        .product-list .item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
        }

        .product-list .item h3 {
            margin: 0;
        }

        .product-list .item button {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 5px;
        }

        .edit-btn {
            background: #ffc107;
            color: white;
        }

        .delete-btn {
            background: #dc3545;
            color: white;
        }

        .toggle-btn {
            background: #17a2b8;
            color: white;
        }

        .spinner {
            display: none;
            margin: 10px auto;
            width: 30px;
            height: 30px;
            border: 4px solid #ddd;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
         /* Disabled button style */
    #save-composition-btn {
        background: gray;
        color: white;
        cursor: not-allowed;
        opacity: 0.5;
        transition: all 0.3s ease-in-out;
    }

    #save-composition-btn.active {
        background: #28a745; /* Green */
        color: white;
        cursor: pointer;
        opacity: 1;
        transform: scale(1);
    }

    /* Add a loading effect */
    .loading {
        pointer-events: none; /* Prevent clicks */
        opacity: 0.7;
    }
    


    .icon-container {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 20px;
        }

        .icon-box {
            width: 150px;
            height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.3s ease;
            color: white;
            font-size: 18px;
            font-weight: bold;
        }

        .icon-box:hover {
            transform: scale(1.05);
        }

        .products-icon {
            background-color: #28a745;
        }

        .blogs-icon {
            background-color: #007bff;
        }

        .icon-box i {
            font-size: 40px;
            margin-bottom: 10px;
        }
        .content-section {
            display: none;
            margin-top: 30px;
        }

        .active {
            display: block;
        }




    

    </style>
</head>
<body>
    <!-- Logout Button -->
    <a href="logout.php" class="logout-btn">Déconnexion</a>

    <!-- Admin Panel Header -->
    <h1>Panneau d'administration</h1>
    <div class="icon-container">
        <div class="icon-box blogs-icon" onclick="showSection('blog-section')">
            <i class="fa-solid fa-newspaper"></i>
            <span>Blog</span>
        </div>
        <div class="icon-box products-icon" onclick="showSection('product-section')">
            <i class="fa-solid fa-box"></i>
            <span>Produit</span>
        </div>
      
    </div>

    <!-- Blog Section (Default Visible) -->
<div id="blog-section" class="container content-section active">
    

    <!-- Blogs Management Section -->
    <div id="blogs" class="content active">
        <h2>Gérer les blogs</h2>
        <form id="blog-form" enctype="multipart/form-data">
            <input type="hidden" id="blog-id">
            <input type="text" id="blog-title" placeholder="Titre" required>
            <textarea id="blog-description" placeholder="Description" required></textarea>
            <textarea id="blog-content" placeholder="Contenu" required></textarea>
            <input type="file" id="blog-image" required>
            <button class="test" type="submit">Enregistrer le blog</button>
        </form>

        <h2>Liste des blogs disponibles</h2>
        <!-- Success Message -->
        <div id="success-message"></div>

        <!-- List of blogs -->
        <div id="blogs-list">
            <?php foreach ($blogs as $blog): ?>
                <div class="blog" id="blog-<?php echo $blog['id']; ?>">
                    <img src="<?php echo htmlspecialchars($blog['image_url']); ?>" alt="Blog Image">
                    <h2><?php echo htmlspecialchars(html_entity_decode($blog['title'])); ?></h2>
                    <!-- Buttons container -->
                    <div class="buttons">
                        <button class="edit-btn" onclick="editBlog(<?php echo $blog['id']; ?>)">Modifier</button>
                        <button class="delete-btn" onclick="deleteBlog(<?php echo $blog['id']; ?>)">Supprimer</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Product Section (Initially Hidden) -->
<div id="product-section" class="container content-section">
    <h2>Gérer les produits</h2>

    <!-- Notification -->
    <div id="notification" class="notification"></div>

    <!-- Product Form -->
    <form id="product-form" enctype="multipart/form-data">
        <input type="hidden" id="product-id">
        <input type="text" id="product-name" placeholder="Nom du produit" style="width: 97.5%;" required>
        <input type="number" id="product-price" placeholder="Prix" step="0.01" style="width: 97.5%;" required>
        <textarea id="composition-text" placeholder="Composition" required rows="4" style="width: 100%;"></textarea>
        <input type="file" id="product-image" accept="image/*" style="width: 99%;" required>
        <input type="text" id="product-link" placeholder="Lien du produit" style="width: 97.5%;" required>
        <select id="product-category" style="width: 100%;" required>
            <option value="">Select Category</option>
            <option value="LIQUID NPK">LIQUID NPK</option>
            <option value="AMINOS ACIDS">AMINOS ACIDS</option>
            <option value="SEAWEED EXTRACTS">SEAWEED EXTRACTS</option>
            <option value="POWDER NPK">POWDER NPK</option>
            <option value="Paste NPK">Paste NPK</option>
            <option value="SPECIAL FERTILIZERS">SPECIAL FERTILIZERS</option>
            <option value="SOIL Ammendement">SOIL Ammendement</option>
            <option value="PGR">PGR</option>
            <option value="Phosphite Fertilizers">Phosphite Fertilizers</option>
        </select>
        <button type="submit" id="save-product-btn">Enregistrer le produit</button>
        <button id="save-composition-btn" disabled>Enregistrer la composition</button>
    </form>

    <!-- Spinner -->
    <div class="spinner" id="spinner"></div>

    <!-- Product List -->
    <h2>Liste des produits disponibles</h2>
    <div id="product-list" class="product-list"></div>
</div>

<script>
    // Handle form submission and save blog
    document.getElementById('blog-form').addEventListener('submit', function (event) {
    event.preventDefault();

    const title = document.getElementById('blog-title').value;
    const description = document.getElementById('blog-description').value;
    const content = document.getElementById('blog-content').value;
    const image = document.getElementById('blog-image').files[0];

    const data = new FormData();
    data.append('title', title);
    data.append('description', description);
    data.append('content', content);
    data.append('image', image);

    // Show loading state
    document.getElementById('success-message').style.display = 'none';

    fetch('home.php', {
        method: 'POST',
        body: data
    })
    .then(response => response.json())
    .then(result => {
        if (result.status === 'success') {
            // Show success message with fade-in effect
            const successMessage = document.getElementById('success-message');
            successMessage.textContent = result.message;
            successMessage.style.display = 'block';
            successMessage.style.opacity = 1;  // Fade in

            // Dynamically add the new blog to the top of the list
            const newBlog = result.blog;
            const blogElement = document.createElement('div');
            blogElement.classList.add('blog');
            blogElement.id = 'blog-' + newBlog.id;

            // Only show image, title, and edit/delete buttons
            blogElement.innerHTML = `
                <img src="${newBlog.image_url}" alt="Blog Image">
                <h2>${decodeHTMLEntities(newBlog.title)}</h2>
                <div class="buttons">
                    <button class="edit-btn" onclick="editBlog(${newBlog.id})">Edit</button>
                    <button class="delete-btn" onclick="deleteBlog(${newBlog.id})">Delete</button>
                </div>
            `;

            // Insert the new blog at the top of the list
            const blogsList = document.getElementById('blogs-list');
            blogsList.insertBefore(blogElement, blogsList.firstChild);

            // Reset the form
            document.getElementById('blog-form').reset();

            // Hide the success message after 3 seconds with fade-out
            setTimeout(() => {
                successMessage.style.opacity = 0;  // Fade out
                setTimeout(() => {
                    successMessage.style.display = 'none';  // Hide the message after the fade-out
                }, 500);  // Wait for the fade-out to complete
            }, 3000);  // 3000ms = 3 seconds

            // Auto-refresh the page after a certain time (e.g., 5 seconds)
            setTimeout(() => {
                location.reload();  // Refresh the page
            }, 5000);  // Refresh after 5 seconds (5000ms)
        } else {
            alert(result.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});



    // Edit blog function
    function editBlog(blogId) {
        // Redirect to edit page or populate form with blog data to edit
        window.location.href = 'edit_blog.php?id=' + blogId;
    }

    // Delete blog function
    function deleteBlog(blogId) {
        if (confirm('Are you sure you want to delete this blog?')) {
            fetch('delete_blog.php?id=' + blogId)
                .then(response => response.json())
                .then(result => {
                    if (result.status === 'success') {
                        document.getElementById('blog-' + blogId).remove();
                    } else {
                        alert(result.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    }

    // Switch Tabs
    function switchTab(tab) {
        document.querySelectorAll('.tab, .content').forEach(element => {
            element.classList.remove('active');
        });

        document.querySelector('.tab[onclick="switchTab(\'' + tab + '\')"]').classList.add('active');
        document.getElementById(tab).classList.add('active');
    }

    // Helper function to decode HTML entities
    function decodeHTMLEntities(text) {
        var element = document.createElement('div');
        if (text) {
            element.innerHTML = text;
            text = element.innerText || element.textContent;
            element = null;
        }
        return text;
    }
    const notification = document.getElementById('notification');
        const spinner = document.getElementById('spinner');
        const productForm = document.getElementById('product-form');
        function openComposition(productId) {
    // Show composition popup
    document.getElementById('composition-popup').style.display = 'block';

    // Store product ID for later use
    window.productIdForComposition = productId;
}

// Close composition input
function closeComposition() {
    // Hide the composition popup
    document.getElementById('composition-popup').style.display = 'none';
}
        function saveComposition() {
    const compositionText = document.getElementById('composition-text').value;
    
    if (!window.productIdForComposition) {
        alert('Error: No product selected.');
        return;
    }

    fetch('save-composition.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ 
            composition: compositionText, 
            productId: window.productIdForComposition 
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Composition saved successfully!');
            closeComposition();
            window.open(data.file, '_blank'); // Open the generated HTML page
        } else {
            alert('Error: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred.');
    });
}


        // Show notification
        function showNotification(message, type = 'success') {
            notification.textContent = message;
            notification.className = `notification ${type}`;
            notification.style.display = 'block';
            setTimeout(() => notification.style.display = 'none', 3000);
        }

        // Fetch Products
        function fetchProducts() {
            fetch('get-products.php')
                .then(response => response.json())
                .then(products => {
                    const productList = document.getElementById('product-list');
                    productList.innerHTML = products.map(product => ` 
                        <div class="item">
                            <h3>${product.name} - $${product.price} ${product.visible ? '' : '[Hidden]'}</h3>
                            <div>
                                <button class="edit-btn" onclick="editProduct(${product.id})">Modifier</button>
                                <button class="delete-btn" onclick="deleteProduct(${product.id})">Supprimer</button>
                                <button class="toggle-btn" onclick="toggleVisibility(${product.id}, ${!product.visible})">${product.visible ? 'Cacher' : 'Montrer'}</button>
                                
                            </div>
                        </div>
                    `).join('');
                })
                .catch(error => console.error('Error fetching products:', error));
        }

        // Save Product (for both adding and editing)
        

        // Edit Product
        function editProduct(id) {
    // Send a request to get the product data
    fetch(`get-product.php?id=${id}`)
        .then((response) => response.json())
        .then((product) => {
            // Check if product is found
            if (product && product.id) {
                // Populate the form with the selected product data
                document.getElementById("product-id").value = product.id;
                document.getElementById("product-name").value = product.name;
                document.getElementById("product-price").value = product.price;
                document.getElementById("composition-text").value = product.composition;
                document.getElementById("product-link").value = product.link;
                document.getElementById("product-category").value = product.category;

                // Reset the file input (image won't be pre-filled for security reasons)
                document.getElementById("product-image").value = ""; 
            } else {
                console.error("Product not found or invalid data.");
                alert('Product not found.');
            }
        })
        .catch((error) => {
            // Log and display error if fetch fails
            console.error("Error fetching product:", error);
            alert('An error occurred while fetching the product details.');
        });
}


        // Delete Product
        function deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                fetch('delete-product.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id }),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('Product deleted successfully!', 'success');
                            fetchProducts(); // Refresh product list
                        } else {
                            showNotification('Failed to delete product.', 'error');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

        // Toggle Visibility
        function toggleVisibility(id, visible) {
            fetch('toggle-visibility.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id, visible }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Visibility updated successfully!', 'success');
                        fetchProducts(); // Refresh product list
                    } else {
                        showNotification('Failed to update visibility: ' + data.error, 'error');
                    }
                })
                .catch(error => {
                    showNotification('An error occurred while updating visibility.', 'error');
                    console.error('Error:', error);
                });
        }
        const saveProductBtn = document.getElementById('save-product-btn');
const saveCompositionBtn = document.getElementById('save-composition-btn');
let savedProductId = null;
let isSubmitting = false; // Prevents multiple submissions

productForm.addEventListener('submit', function (e) {
    e.preventDefault();

    if (isSubmitting) return; // Prevent duplicate submissions
    isSubmitting = true;

    saveProductBtn.classList.add('loading'); // Add loading effect
    saveProductBtn.disabled = true; // Disable the button to prevent multiple clicks

    const formData = new FormData();
    formData.append('name', document.getElementById('product-name').value);
    formData.append('price', document.getElementById('product-price').value);
    formData.append('composition', document.getElementById('composition-text').value);
    formData.append('image', document.getElementById('product-image').files[0]);
    formData.append('link', document.getElementById('product-link').value);
    formData.append('category', document.getElementById('product-category').value);
    formData.append('id', document.getElementById('product-id').value);

    fetch('save-product.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        saveProductBtn.classList.remove('loading');
        saveProductBtn.disabled = false; // Re-enable button
        isSubmitting = false;

        if (data.success) {
            showNotification('Product saved successfully!', 'success');
            savedProductId = data.product.id;
            activateSaveComposition(); // Enable and animate "Save Composition" button
            productForm.reset();
            fetchProducts();
        } else {
            showNotification('Failed to save product: ' + data.error, 'error');
        }
    })
    .catch(error => {
        saveProductBtn.classList.remove('loading');
        saveProductBtn.disabled = false;
        isSubmitting = false;
        showNotification('An error occurred while saving the product.', 'error');
        console.error('Error:', error);
    });
});

// Function to activate the Save Composition button
function activateSaveComposition() {
    saveCompositionBtn.disabled = false;
    saveCompositionBtn.classList.add('active'); // Apply animation styles
}

// Save Composition Click Event
saveCompositionBtn.addEventListener('click', function () {
    if (!savedProductId) {
        alert('Please save the product first.');
        return;
    }

    const compositionText = document.getElementById('composition-text').value;

    fetch('save-composition.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ 
            composition: compositionText, 
            productId: savedProductId 
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Composition saved successfully!');
            closeComposition();
        } else {
            alert('Error: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred.');
    });
});



        // Fetch products on page load
        fetchProducts();
        function showSection(sectionId) {
    // Hide both sections
    document.getElementById('blog-section').style.display = 'none';
    document.getElementById('product-section').style.display = 'none';

    // Show the selected section
    document.getElementById(sectionId).style.display = 'block';
}

// Ensure the blog section is visible on page load
document.addEventListener("DOMContentLoaded", function() {
    showSection('blog-section');
});
</script>
</body>
</html>
