<?php
header("Content-Type: application/json");

// Database connection
$host = "localhost";
$dbname = "elanbi";
$username = "ayman";
$password = "ayman";

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Database connection failed"]);
    exit();
}


// Get JSON data from request
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['productId'])) {
    echo json_encode(["success" => false, "error" => "Missing required fields"]);
    exit();
}

$productId = intval($data['productId']); // Ensure it's an integer

// Fetch product details from the database
$sql = "SELECT name, link, image, price, composition FROM products WHERE id = ? ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "error" => "Product not found"]);
    exit();
}

$product = $result->fetch_assoc();
$productName = htmlspecialchars($product['name']);
$productLink = preg_replace('/[^a-zA-Z0-9_-]/', '', $product['link']);
$productImage = htmlspecialchars($product['image']);
$productPrice = number_format($product['price'], 2);
$composition = nl2br(htmlspecialchars($product['composition']));

// Fetch related products (limit to 4)
$sql_related = "SELECT name, link, image, price FROM products WHERE id != ? ORDER BY RAND() LIMIT 4";
$stmt_related = $conn->prepare($sql_related);
$stmt_related->bind_param("i", $productId);
$stmt_related->execute();
$result_related = $stmt_related->get_result();

// Store related products in an array
$relatedProducts = [];
while ($row = $result_related->fetch_assoc()) {
    $relatedProducts[] = $row;
}

// Define the file path
$filePath = $productLink ;

// Generate HTML content
$htmlContent = "
<!DOCTYPE html>
<html lang='en'>
<!-- Basic -->

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>$productName</title>
    <meta name='keywords' content=''>
    <meta name='description' content=''>
    <meta name='author' content=''>

    <!-- Site Icons -->
    <link rel='shortcut icon' href='images/banner.png' type='image/x-icon'>
    <link rel='apple-touch-icon' href='images/apple-touch-icon.png'>

    <!-- Bootstrap CSS -->
    <link rel='stylesheet' href='css/bootstrap.min.css'>
    <!-- Site CSS -->
    <link rel='stylesheet' href='css/style.css'>
    <!-- Responsive CSS -->
    <link rel='stylesheet' href='css/responsive.css'>
    <!-- Custom CSS -->
    <link rel='stylesheet' href='css/custom.css'>

    <!--[if lt IE 9]>
      <script src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js'></script>
      <script src='https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js'></script>
    <![endif]-->
</head>

<body>
    <!-- Start Main Top -->
    <div class='main-top'>
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'>
                    <div class='custom-select-box'>
                        <select id='basic' class='selectpicker show-tick form-control' data-placeholder='$ USD'>
                            <option>MAD</option>
                            <option>USD</option>
                        </select>
                    </div>
                    <div class='right-phone-box'>
                        <p>Tél : <a href='#'> +212524335145</a></p>
                    </div>
                    <div class='our-link'>
                        <ul>
                            <li><a href='#contact'><i class='fas fa-location-arrow'></i> Localisation</a></li>
                            <li><a href='#contact'><i class='fas fa-headset'></i> Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main Top -->

    <!-- Start Main Top -->
    <header class='main-header'>
        <!-- Start Navigation -->
        <nav class='navbar navbar-expand-lg navbar-light bg-light navbar-default bootsnav'>
            <div class='container'>
                <!-- Start Header Navigation -->
                <div class='navbar-header'>
                    <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbar-menu' aria-controls='navbars-rs-food' aria-expanded='false' aria-label='Toggle navigation'>
                        <i class='fa fa-bars'></i>
                    </button>
                    <a class='navbar-brand' href='index.html'><img src='images/ilogo.svg' class='logo' alt=''></a>
                </div>
                <!-- End Header Navigation -->

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class='collapse navbar-collapse' id='navbar-menu'>
                    <ul class='nav navbar-nav ml-auto' data-in='fadeInDown' data-out='fadeOutUp'>
                        <li class='nav-item'><a class='nav-link' href='index.html'>Acceuil</a></li>
                        <li class='nav-item'><a class='nav-link' href='about.html'>À Propos De Nous</a></li>
                        <li class='nav-item active'><a class='nav-link' href='shop-detail.html'>Boutique</a></li>
                        <li class='nav-item'><a class='nav-link' href='blog.html'>Blog</a></li>
                        <li class='nav-item'><a class='nav-link' href='contact-us.html'>Contact</a></li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->

                <!-- Start Atribute Navigation -->
                <div class='attr-nav'>
                    <ul>
                        <li class='search'><a href='#'><i class='fa fa-search'></i></a></li>
                        <li class='side-menu'>
                            <a href='cart.html'>
                                <i class='fa fa-shopping-bag'></i>
                                <span class='badge'>0</span>
                                <p>Panier</p>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- End Atribute Navigation -->
            </div>
        </nav>
        <!-- End Navigation -->
    </header>
    <!-- End Main Top -->

    <!-- Start Top Search -->
    <div class='top-search'>
        <div class='container'>
            <div class='input-group'>
                <span class='input-group-addon'><i class='fa fa-search'></i></span>
                <input type='text' class='form-control' placeholder='Search'>
                <span class='input-group-addon close-search'><i class='fa fa-times'></i></span>
            </div>
        </div>
    </div>
    <!-- End Top Search -->

    <!-- Start All Title Box -->
    <div class='all-title-box'>
        <div class='container'>
            <div class='row'>
                <div class='col-lg-12'>
                    <h2>Detail De Produit</h2>
                    <ul class='breadcrumb'>
                        <li class='breadcrumb-item'><a href='shop-detail.html'>Boutique</a></li>
                        <li class='breadcrumb-item active'>Details De Produits</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End All Title Box -->

    <!-- Start Shop Detail  -->
    <div class='shop-detail-box-main'>
        <div class='container'>
            <div class='row'>
                <div class='col-xl-5 col-lg-5 col-md-6'>
                    <div id='carousel-example-1' class='single-product-slider carousel slide' data-ride='carousel'>
                        <div class='carousel-inner' role='listbox'>
                            <div class='carousel-item active'>
                                <img class='d-block w-100' src='$productImage' alt='$productName'>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='col-xl-7 col-lg-7 col-md-6'>
                    <div class='single-product-details'>
                        <h2>$productName</h2>
                        <h4>Composition:</h4>
                        <p>$composition</p>
                        <div class='price-box-bar'>
                            <div class='cart-and-bay-btn'>
                                <a class='btn hvr-hover' href='#' onclick=\"addToCart({ id: $productId, name: '$productName', price: $productPrice, image: '$productImage' })\">Ajouter Au Panier</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class='row my-5'>
                <div class='col-lg-12'>
                    <div class='title-all text-center'>
                        <h1>Produits Associés</h1>
                    </div>
                    <div class='row special-list'>";

// Loop through related products and add them dynamically
foreach ($relatedProducts as $related) {
    $relatedName = htmlspecialchars($related['name']);
    $relatedLink = preg_replace('/[^a-zA-Z0-9_-]/', '', $related['link']);
    $relatedImage = htmlspecialchars($related['image']);
    $relatedPrice = number_format($related['price'], 2);

    $htmlContent .= "
                        <div class='col-lg-3 col-md-6 special-grid best-seller'>
                            <div class='products-single fix'>
                                <a href='$relatedLink.html' class='product-link'>
                                    <div class='box-img-hover'>
                                        <img src='$relatedImage' class='img-fluid' alt='$relatedName'>
                                    </div>
                                    <div class='why-text'>
                                        <h4>$relatedName</h4>
                                        <h5>\$$relatedPrice</h5>
                                    </div>
                                </a>
                            </div>
                        </div>";
}

$htmlContent .= "
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Shop Detail  -->

    <!-- Start Footer  -->
    <footer>
        <div class='footer-main'>
            <div class='container'>
                <div class='row'>
                    <div class='col-lg-4 col-md-12 col-sm-12'>
                        <div class='footer-widget'>
                            <h4>À propos de Irrifertil</h4>
                            <p>IRRIFERTIL est une jeune entreprise spécialisée dans l’innovation agricole qui permet d’accompagner les évolutions de l’agriculture en proposant des solutions innovantes.</p>
                            <p>IRRIFERTIL est un partenaire et distributeur idéal qui souhaite et s’engage à conseiller et commercialiser des solutions adaptées aux besoins de nos clients.</p>
                        </div>
                    </div>
                    <div class='col-lg-4 col-md-12 col-sm-12' id='contact'>
                        <div class='footer-link-contact'>
                            <h4>Contact</h4>
                            <ul>
                                <li>
                                    <p><i class='fas fa-map-marker-alt'></i>Localisation: 213 Lot IZDIHAR <br>route de Marrakech<br> MAROC</p>
                                </li>
                                <li>
                                    <p><i class='fas fa-phone-square'></i>Tél: <a href='MOROCCO'>+212524335145</a></p>
                                </li>
                                <li>
                                    <p><i class='fas fa-envelope'></i>Email: <a href='mailto:contactinfo@gmail.com'>irrifertil@gmail.com</a></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class='col-lg-4 col-md-12 col-sm-12'>
                        <div class='footer-link'>
                            <h4>Information</h4>
                            <ul>
                                <li><a href='#'>Terms &amp; Conditions</a></li>
                                <li><a href='#'>Privacy Policy</a></li>
                                <li><a href='#'>Delivery Information</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer  -->

    <!-- Start copyright  -->
    <div class='footer-copyright'>
        <p class='footer-company'>All Rights Reserved. &copy; 2025 <a href='#'>Irrifertil</a></p>
    </div>
    <!-- End copyright  -->

    <a href='#' id='back-to-top' title='Back to top' style='display: none;'>&uarr;</a>

    <!-- ALL JS FILES -->
    <script src='js/jquery-3.2.1.min.js'></script>
    <script src='js/popper.min.js'></script>
    <script src='js/bootstrap.min.js'></script>
    <!-- ALL PLUGINS -->
    <script src='js/jquery.superslides.min.js'></script>
    <script src='js/bootstrap-select.js'></script>
    <script src='js/inewsticker.js'></script>
    <script src='js/bootsnav.js'></script>
    <script src='js/images-loded.min.js'></script>
    <script src='js/isotope.min.js'></script>
    <script src='js/owl.carousel.min.js'></script>
    <script src='js/baguetteBox.min.js'></script>
    <script src='js/form-validator.min.js'></script>
    <script src='js/contact-form-script.js'></script>
    <script src='js/custom.js'></script>
    <script src='js/cart.js'></script>
</body>

</html>";

// Write content to the file
if (file_put_contents($filePath, $htmlContent) !== false) {
    echo json_encode(["success" => true, "file" => $filePath]);
} else {
    echo json_encode(["success" => false, "error" => "Failed to save file"]);
}

// Close database connection
$stmt->close();
$stmt_related->close();
$conn->close();
?>