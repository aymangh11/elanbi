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

// Fetch all blogs from the database
$stmt = $pdo->query("SELECT * FROM blogs ORDER BY created_at DESC");
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<!-- Basic -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Site Metas -->
    <title>IRRIFERTIL</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Site Icons -->
    <link rel="shortcut icon" href="images/banner.png" type="image/x-icon">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Site CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/custom.css">

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <!-- Start Main Top -->
    <div class="main-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="custom-select-box">
                        <select id="basic" class="selectpicker show-tick form-control" data-placeholder="$ USD">
							<option>MAD</option>
							<option>USD</option>
							
						</select>
                    </div>
                    <div class="right-phone-box">
                        <p>Tél : <a href="#"> +212524335145</a></p>
                    </div>
                    <div class="our-link">
                        <ul>
                            
                            <li><a href="#contact"><i class="fas fa-location-arrow"></i> Localisation</a></li>
                            <li><a href="#contact"><i class="fas fa-headset"></i> Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					
                    <!-- <div class="text-slid-box">
                        <div id="offer-box" class="carouselTicker">
                            <ul class="offer-box">
                                <li>
                                    <i class="fab fa-opencart"></i> 20% off Entire Purchase Promo code: offT80
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> 50% - 80% off on Vegetables
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> Off 10%! Shop Vegetables
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> Off 50%! Shop Now
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> Off 10%! Shop Vegetables
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> 50% - 80% off on Vegetables
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> 20% off Entire Purchase Promo code: offT30
                                </li>
                                <li>
                                    <i class="fab fa-opencart"></i> Off 50%! Shop Now 
                                </li>
                            </ul>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Main Top -->

    <!-- Start Main Top -->
    <header class="main-header">
        <!-- Start Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-default bootsnav" style="height: 90px; padding: 5px 0;">
        <div class="container">
            <!-- Start Header Navigation -->
            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu" 
                    aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="index.html">
                    <img src="images/ilogo.png" class="logo" alt="" style="height: 60px;">
                </a>
            </div>
            <!-- End Header Navigation -->

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav ml-auto" data-in="fadeInDown" data-out="fadeOutUp">
                    <li class="nav-item "><a class="nav-link" href="index.html">Acceuil</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.html">À Propos De Nous</a></li>
                    <li class="nav-item"><a class="nav-link" href="shop-detail.html">Boutique</a></li>
                    <li class="nav-item active"><a class="nav-link" href="blog.php">Programme Culture</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact-us.html">Contact</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->

               <!-- Start Atribute Navigation -->
               <div class="attr-nav">
                    <ul>
                        
                        <li class="nav-link ">
                            <a href="cart.html">
                                <i class="fa fa-shopping-bag"></i>
                                <span class="badge">0</span>
                                
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
    <div class="top-search">
        <div class="container">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search">
                <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
            </div>
        </div>
    </div>
    <!-- End Top Search -->
    
     <!-- Start All Title Box -->
     <div class="all-title-box">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Programme culture</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Acceuil</a></li>
                        <li class="breadcrumb-item active">Programme culture</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End All Title Box -->

    <!-- Start Gallery  -->

    <div class="latest-blog">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="title-all text-center">
                    <h1>Dernier blog</h1>
                    <p>Découvrez nos derniers articles pour rester informé et inspiré au quotidien.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <?php if (count($blogs) > 0): ?>
                <?php foreach ($blogs as $index => $blog): ?>
                    <div class="col-md-6 col-lg-4 col-xl-4">
                        <div class="blog-box">
                            <div class="blog-img">
                                <img class="img-fluid" src="<?php echo htmlspecialchars($blog['image_url']); ?>" alt="Blog Image" />
                            </div>
                            <div class="blog-content">
                                <div class="title-blog">
                                    <h3><?php echo htmlspecialchars_decode(htmlspecialchars($blog['title'])); ?></h3>
                                    <p><?php echo nl2br(htmlspecialchars_decode(htmlspecialchars($blog['description']))); ?> ...</p>
                                    <div class="button-container">
                                        <label for="modal-toggle-<?php echo $index; ?>" class="btn-read-more">En savoir plus</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Section -->
                    <input type="checkbox" id="modal-toggle-<?php echo $index; ?>" class="modal-toggle" />
                    <div class="modal-overlay" id="modal-overlay-<?php echo $index; ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2><strong><?php echo htmlspecialchars_decode(htmlspecialchars($blog['title'])); ?></strong></h2>
                                <label for="modal-toggle-<?php echo $index; ?>" class="close-btn">&times;</label>
                            </div>
                            <div class="modal-body">
                                <img class="img-fluid" src="<?php echo htmlspecialchars($blog['image_url']); ?>" alt="Blog Image" />
                                <div class="modal-text">
                                    <?php echo htmlspecialchars_decode(htmlspecialchars($blog['content'])); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun blog trouvé.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Ajouter l'écouteur d'événements pour fermer le modal lorsqu'on clique en dehors
    document.querySelectorAll('.modal-overlay').forEach(function(modalOverlay, index) {
        modalOverlay.addEventListener('click', function(event) {
            if (event.target === modalOverlay) {
                document.getElementById('modal-toggle-' + index).checked = false;
            }
        });
    });
    // Handle modal open and close state
document.querySelectorAll('.modal-toggle').forEach(function(modalToggle, index) {
    modalToggle.addEventListener('change', function() {
        if (modalToggle.checked) {
            // Prevent background scroll when modal is open
            document.body.classList.add('modal-open');
        } else {
            // Allow background scroll when modal is closed
            document.body.classList.remove('modal-open');
        }
    });
});

</script>

<style>
    /* Style for the blog container */
.latest-blog .container {
    padding: 20px;
}

.blog-box {
    display: flex;
    flex-direction: column;
    height: 100%;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px; /* Add space between blog boxes */
}

/* Add margin to columns for spacing */
.latest-blog .row .col-md-6,
.latest-blog .row .col-lg-4,
.latest-blog .row .col-xl-4 {
    margin-bottom: 20px; /* Add space between columns */
}

.blog-img {
    width: 100%;
    height: 200px; /* Fixed height for the image */
    overflow: hidden;
}

.blog-img img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Ensures the image covers the area without stretching */
}

.blog-content {
    flex-grow: 1; /* Takes up remaining space */
    padding: 15px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.title-blog h3 {
    font-size: 1.2em;
    font-weight: bold;
    margin-bottom: 10px;
    line-height: 1.4;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap; /* Ensures long titles don't overflow */
}

.title-blog p {
    font-size: 0.9em;
    color: #555;
    line-height: 1.5;
    height: 60px; /* Fixed height for the description */
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 3; /* Limits to 3 lines */
    -webkit-box-orient: vertical;
}

.button-container {
    margin-top: auto; /* Pushes the button to the bottom */
}

.btn-read-more {
    display: inline-block;
    background-color: #b0b435;
    color: #fff;
    padding: 8px 15px;
    border-radius: 5px;
    text-align: center;
    cursor: pointer;
    text-decoration: none;
}

/* Style for the modal overlay to cover the whole screen */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: none;
    justify-content: center;
    align-items: center;
    overflow: hidden; /* Prevent page scroll when modal is open */
}

/* Display modal when checkbox is checked */
.modal-toggle:checked + .modal-overlay {
    display: flex;
}

/* Style for the modal content */
.modal-content {
    background: white;
    padding: 20px;
    border-radius: 5px;
    max-width: 800px;
    margin: 0 20px;
    max-height: 90vh; /* Limit the height of the modal */
    overflow-y: auto; /* Allow scrolling within the modal */
}

/* Prevent body scroll when the modal is open */
body.modal-open {
    overflow: hidden;
}

/* Additional styling for close button */
.modal-header h2 {
    margin: 0;
}

.close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
    font-size: 20px;
}


</style>

<!-- Start Instagram Feed  -->
<div class="instagram-box">
        <div class="main-instagram owl-carousel owl-theme">
            <div class="item">
                <div class="ins-inner-box">
                    <img src="images/instagram-img-01.svg" alt="" />
                    <div class="hov-in">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="ins-inner-box">
                    <img src="images/instagram-img-02.svg" alt="" />
                    <div class="hov-in">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="ins-inner-box">
                    <img src="images/instagram-img-03.svg" alt="" />
                    <div class="hov-in">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="ins-inner-box">
                    <img src="images/instagram-img-04.svg" alt="" />
                    <div class="hov-in">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="ins-inner-box">
                    <img src="images/instagram-img-11.svg" alt="" />
                    <div class="hov-in">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="ins-inner-box">
                    <img src="images/instagram-img-06.svg" alt="" />
                    <div class="hov-in">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="ins-inner-box">
                    <img src="images/instagram-img-07.svg" alt="" />
                    <div class="hov-in">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="ins-inner-box">
                    <img src="images/instagram-img-08.svg" alt="" />
                    <div class="hov-in">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="ins-inner-box">
                    <img src="images/instagram-img-09.svg" alt="" />
                    <div class="hov-in">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="ins-inner-box">
                    <img src="images/instagram-img-10.svg" alt="" />
                    <div class="hov-in">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Instagram Feed  -->



<!-- Start Footer  -->
<footer>
        <div class="footer-main">
            <div class="container">
				
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="footer-widget">
                            <h4>À propos de Irrifertil                            </h4>
                            <p>IRRIFERTIL est une jeune entreprise spécialisée dans l’innovation agricole qui permet
                                d’accompagner les évolutions de l’agriculture en proposant des solutions innovantes.</p> 
							<p>IRRIFERTIL est un patenaire et distributeur idéal qui souhaite et s’engage à conseiller
                                et commercialiser des solutions adaptées aux besoins de nos clients </p> 							
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-12 col-sm-12" id="contact">
                        <div class="footer-link-contact">
                            <h4>Contact</h4>
                            <ul>
                                <li>
                                    <p><i class="fas fa-map-marker-alt"></i>Localisation: 213 Lot IZDIHAR <br>route de Marrakech<br> MAROC</p>
                                </li>
                                <li>
                                    <p><i class="fas fa-phone-square"></i>Tél: <a href="MOROCCO">+212524335145</a></p>
                                </li>
                                <li>
                                    <p><i class="fas fa-envelope"></i>Email: <a href="mailto:contactinfo@gmail.com">irrifertil@gmail.com</a></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="footer-link">
                            <h4>Information</h4>
                            <ul>
                               
                                <li><a href="#"> Terms &amp; Conditions</a></li>
                                <li><a href="#"> Privacy Policy</a></li>
                                <li><a href="#"> Delivery Information</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    
                    <div class="col-lg-4 col-md-12 col-sm-12">
						<div class="footer-top-box">
							<h3>Réseaux Sociaux                            </h3>
							<p> Suivez-nous sur les réseaux sociaux pour découvrir nos produits, bénéficier de conseils agricoles, et rester informés des dernières actualités. </p>
							<ul>
                                <li><a href="#"><i class="fab fa-facebook" aria-hidden="true"></i></a></li>
                                
                                <li><a href="#"><i class="fab fa-linkedin" aria-hidden="true"></i></a></li>
                                
                                
                                <li><a href="#"><i class="fab fa-whatsapp" aria-hidden="true"></i></a></li>
                            </ul>
						</div>
					</div>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer  -->

    <!-- Start copyright  -->
    <div class="footer-copyright">
        <p class="footer-company">All Rights Reserved. &copy; 2025 <a href="#">Irrifertil</a> 
           
    </div>
    <!-- End copyright  -->

    <a href="#" id="back-to-top" title="Back to top" style="display: none;">&uarr;</a>

    <!-- ALL JS FILES -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- ALL PLUGINS -->
    <script src="js/jquery.superslides.min.js"></script>
    <script src="js/bootstrap-select.js"></script>
    <script src="js/inewsticker.js"></script>
    <script src="js/bootsnav.js."></script>
    <script src="js/images-loded.min.js"></script>
    <script src="js/isotope.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/baguetteBox.min.js"></script>
    <script src="js/form-validator.min.js"></script>
    <script src="js/contact-form-script.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/cart.js"></script>
    <script>
      // Cibler tous les boutons et overlays de modals
const modalToggles = document.querySelectorAll('.modal-toggle');
const modalOverlays = document.querySelectorAll('.modal-overlay');
const body = document.body;

// Lors de l'ouverture de la modal, bloquer le scroll de la page principale
modalToggles.forEach(toggle => {
    toggle.addEventListener('change', function() {
        if (this.checked) {
            // Bloquer le scroll de la page principale lorsque la modal est ouverte
            body.style.overflow = 'hidden';
        } else {
            // Réactiver le scroll de la page principale lorsque la modal est fermée
            body.style.overflow = 'auto';
        }
    });
});

// Optionnel: si l'utilisateur clique en dehors du contenu de la modal (dans l'overlay), fermer la modal
modalOverlays.forEach(overlay => {
    overlay.addEventListener('click', function() {
        // Trouver la checkbox associée à cet overlay
        const relatedCheckbox = this.previousElementSibling;
        // Décocher la checkbox pour fermer la modal
        relatedCheckbox.checked = false;
        // Réactiver le scroll de la page principale
        body.style.overflow = 'auto';
    });
});

// En cas de fermeture manuelle de la modal via le bouton de fermeture
const closeButtons = document.querySelectorAll('.close-btn');
closeButtons.forEach(button => {
    button.addEventListener('click', function() {
        // Trouver la checkbox associée au bouton de fermeture
        const relatedCheckbox = this.closest('.modal-header').previousElementSibling;
        // Fermer la modal en décochant la checkbox
        relatedCheckbox.checked = false;
        // Réactiver le scroll de la page principale
        body.style.overflow = 'auto';
    });
});

// Empêcher la fermeture de la modal si l'on clique à l'intérieur du contenu
const modalContents = document.querySelectorAll('.modal-content');
modalContents.forEach(content => {
    content.addEventListener('click', function(event) {
        // Empêcher la propagation de l'événement de clic pour ne pas fermer la modal
        event.stopPropagation();
    });
});
    </script> 
</body>

</html>
