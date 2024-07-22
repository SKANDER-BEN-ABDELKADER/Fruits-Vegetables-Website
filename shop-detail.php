<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Fruitables - Vegetable Website Template</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body>

        <!-- Spinner Start -->
        <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" role="status"></div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar start -->
        <div class="container-fluid fixed-top">
            <div class="container topbar bg-primary d-none d-lg-block">
                <div class="d-flex justify-content-between">
                    <div class="top-info ps-2">
                        <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="https://getbootstrap.com/docs/4.0/components/forms/" class="text-white">123 Street, New York</a></small>
                        <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">Email@Example.com</a></small>
                    </div>
                    <div class="top-link pe-2">
                        <a href="#" class="text-white"><small class="text-white mx-2">Privacy Policy</small>/</a>
                        <a href="#" class="text-white"><small class="text-white mx-2">Terms of Use</small>/</a>
                        <a href="#" class="text-white"><small class="text-white ms-2">Sales and Refunds</small></a>
                    </div>
                </div>
            </div>
            <div class="container px-0">
                <nav class="navbar navbar-light bg-white navbar-expand-xl">
                    <a href="index.php" class="navbar-brand"><h1 class="text-primary display-6">Fruitables</h1></a>
                    <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                    <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                        <div class="navbar-nav mx-auto">
                            <a href="index.php" class="nav-item nav-link ">Home</a>
                            <a href="shop.php" class="nav-item nav-link">Shop</a>
                            <a href="testimonial.php" class="nav-item nav-link">Testimonial</a>
                            <a href="contact.php" class="nav-item nav-link">Contact</a>
                        </div>

                        <?php
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // User is logged in, show dropdown menu
        echo '<div class="d-flex m-3 me-0">
                <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search text-primary"></i></button>
                <a href="cart.php" class="position-relative me-4 my-auto">
                    <i class="fa fa-shopping-bag fa-2x"></i>
                </a>
            </div>
            <div class="dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-2x"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
            </div>';
    } else {
        // User is not logged in, show login link
        echo '<a href="login.php" class="my-auto">
             <i class="fas fa-user fa-2x"></i>
            </a>';
                }
?>

                    </div>
                </nav>
            </div>
        </div>
        <!-- Navbar End -->


        <!-- Modal Search Start -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center">
                        <div class="input-group w-75 mx-auto d-flex">
                            <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                            <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Search End -->


        <!-- Single Page Header start -->
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Shop Detail</h1>
        </div>
        <!-- Single Page Header End -->



        
        


<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "fruits";

try {
    
    // Create a PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the product ID is provided in the URL
    $productId = isset($_GET['id']) ? $_GET['id'] : '';

    // SQL query to retrieve product details by ID
    $sql = "SELECT * FROM products WHERE id = :productId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':productId', $productId);
    $stmt->execute();

    // Check if product exists
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $name = $row['name'];
        $type = $row['type'];
        $price = $row['price'];
        $descr = $row['descr'];
        $image = $row['image'];
        $addToCartUrl='';
        
        // Check if form is submitted for adding to cart
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_to_cart"])) {
            // Check if user is logged in
            if (isset($_SESSION['loggedin']) && isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id']; // Use session user_id
                $product_id = $row['id']; // Use product ID from database
                $quantity = isset($row['quantity']) ? $row['quantity'] : 1;
                $addToCartUrl='cart.php';

                // Insert the product into the cart
                $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':product_id', $product_id);
                $stmt->bindParam(':quantity', $quantity);
                if ($stmt->execute()) {
                    echo "<script>alert('New product added to cart successfully');</script>";
                } else {
                    echo "<script>alert('Error: Unable to add new product to cart');</script>";
                }
            } else {
                // Redirect to login page if user is not logged in
                $addToCartUrl='login.php';
                exit();
            }
        }
    } else {
        echo "<script>alert('Product not found');</script>";
    }
} catch (PDOException $e) {
    echo "<script>alert('Connection failed: " . $e->getMessage() . "');</script>";
}





echo '<div class="container-fluid py-5 mt-5">
<div class="container py-5">
    <div class="row g-4 mb-5">
        <div class="col-lg-8 col-xl-9">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="border rounded">
                        <a href="##">
                            <img src="'.$image.'" class="img-fluid rounded" alt="Image" >
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h4 class="fw-bold mb-3"> '.$name.'</h4>
                    <p class="mb-3">Category:  '.$type.'</p>
                    <h5 class="fw-bold mb-3"> '.$price.'$</h5>
                    <div class="d-flex mb-4">
                        <i class="fa fa-star text-secondary"></i>
                        <i class="fa fa-star text-secondary"></i>
                        <i class="fa fa-star text-secondary"></i>
                        <i class="fa fa-star text-secondary"></i>
                        <i class="fa fa-star"></i>
                </div>
                    <form action="'.$addToCartUrl.'" method="post">
                        <input type="hidden" name="user_id" value="'. (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '') .'">
                        <input type="hidden" name="quantity" value="1">
                        
                        <button type="submit" class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary" name="add_to_cart">
                            <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart
                        </button>
                    </form>                    
                </div>
                
                <div class="col-lg-12">
                    <nav>
                        <div class="nav nav-tabs mb-3">
                            <button class="nav-link active border-white border-bottom-0" type="button" role="tab"
                                id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                aria-controls="nav-about" aria-selected="true">Description</button>
                        </div>
                    </nav>
                    <div class="tab-content mb-5">
                        <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                            <p>'.$descr.'</p>
                        </div>
                    </div>
                </div>
            </div>
</div>';
?>


        <?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "fruits";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fetch only the first four products for each category
    $fruitsQuery = "SELECT id, name, type, price, descr, image FROM products WHERE type='fruits' LIMIT 4";
    $vegetablesQuery = "SELECT id, name, type, price, descr, image FROM products WHERE type='vegetables' LIMIT 4";
    
    $fruitsResult = $conn->query($fruitsQuery);
    $vegetablesResult = $conn->query($vegetablesQuery);
} catch(PDOException $e) {
    echo "<script>alert('Connection failed: " . $e->getMessage() . "');</script>";
}
?>

<div class="col-lg-4 col-xl-3">
    <div class="row g-4 fruite">
        <div class="col-lg-12">
            <div class="input-group w-100 mx-auto d-flex mb-4">
                <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
            </div>
            <div class="mb-4">
                <h4>Categories</h4>
                <ul class="list-unstyled fruite-categorie">
                    <li>
                        <div class="d-flex justify-content-between fruite-name">
                            <a href="#"><i class="fas fa-apple-alt me-2"></i>Fruits</a>
                            <span>(<?php echo $fruitsResult->rowCount(); ?>)</span>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex justify-content-between fruite-name">
                            <a href="#"><i class="fas fa-apple-alt me-2"></i>Vegetables</a>
                            <span>(<?php echo $vegetablesResult->rowCount(); ?>)</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<h1 class="fw-bold mb-0">Related products</h1>
<div class="vesitable">
    <div class="owl-carousel vegetable-carousel justify-content-center">
        <?php foreach ($fruitsResult as $row) : ?>
            <div class="border border-primary rounded position-relative vesitable-item">
                <div class="vesitable-img">
                    <img src="<?php echo $row['image']; ?>" class="img-fluid w-100 rounded-top" alt="" style="width: 200px; height: 200px;">
                </div>
                <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;"><?php echo $row['type']; ?></div>
                <div class="p-4 pb-0 rounded-bottom">
                    <h4><?php echo $row['name']; ?></h4>
                    <p><?php echo substr($row['descr'], 0, 25) . '...'; ?></p>
                    <div class="d-flex justify-content-between flex-lg-wrap">
                        <p class="text-dark fs-5 fw-bold">$<?php echo $row['price']; ?> / kg</p>
                        <a href="shop-detail.php?id=<?php echo $row['id']; ?>" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php foreach ($vegetablesResult as $row) : ?>
            <div class="border border-primary rounded position-relative vesitable-item">
                <div class="vesitable-img">
                    <img src="<?php echo $row['image']; ?>" class="img-fluid w-100 rounded-top" alt="" style="width: 200px; height: 200px;">
                </div>
                <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;"><?php echo $row['type']; ?></div>
                <div class="p-4 pb-0 rounded-bottom">
                    <h4><?php echo $row['name']; ?></h4>
                    <p><?php echo substr($row['descr'], 0, 25) . '...'; ?></p>
                    <div class="d-flex justify-content-between flex-lg-wrap">
                        <p class="text-dark fs-5 fw-bold">$<?php echo $row['price']; ?> / kg</p>
                        <a href="shop-detail.php?id=<?php echo $row['id']; ?>" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</div>
</div>
</div>

<?php $conn = null; ?>


                    
                   
        <!-- Single Product End -->
    

        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
            <div class="container py-5">
                <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
                    <div class="row g-4">
                        <div class="col-lg-3">
                            <a href="#">
                                <h1 class="text-primary mb-0">Fruitables</h1>
                                <p class="text-secondary mb-0">Fresh products</p>
                            </a>
                        </div>
                        <div class="col-lg-6">
                            <div class="position-relative mx-auto">
                                <input class="form-control border-0 w-100 py-3 px-4 rounded-pill" type="number" placeholder="Your Email">
                                <button type="submit" class="btn btn-primary border-0 border-secondary py-3 px-4 position-absolute rounded-pill text-white" style="top: 0; right: 0;">Subscribe Now</button>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="d-flex justify-content-end pt-3">
                                <a class="btn  btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-youtube"></i></a>
                                <a class="btn btn-outline-secondary btn-md-square rounded-circle" href=""><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-item">
                            <h4 class="text-light mb-3">Why People Like us!</h4>
                            <p class="mb-4">typesetting, remaining essentially unchanged. It was 
                                popularised in the 1960s with the like Aldus PageMaker including of Lorem Ipsum.</p>
                            <a href="" class="btn border-secondary py-2 px-4 rounded-pill text-primary">Read More</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex flex-column text-start footer-item">
                            <h4 class="text-light mb-3">Shop Info</h4>
                            <a class="btn-link" href="">About Us</a>
                            <a class="btn-link" href="">Contact Us</a>
                            <a class="btn-link" href="">Privacy Policy</a>
                            <a class="btn-link" href="">Terms & Condition</a>
                            <a class="btn-link" href="">Return Policy</a>
                            <a class="btn-link" href="">FAQs & Help</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex flex-column text-start footer-item">
                            <h4 class="text-light mb-3">Account</h4>
                            <a class="btn-link" href="">My Account</a>
                            <a class="btn-link" href="">Shop details</a>
                            <a class="btn-link" href="">Shopping Cart</a>
                            <a class="btn-link" href="">Wishlist</a>
                            <a class="btn-link" href="">Order History</a>
                            <a class="btn-link" href="">International Orders</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-item">
                            <h4 class="text-light mb-3">Contact</h4>
                            <p>Address: 1429 Netus Rd, NY 48247</p>
                            <p>Email: Example@gmail.com</p>
                            <p>Phone: +0123 4567 8910</p>
                            <p>Payment Accepted</p>
                            <img src="img/payment.png" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer End -->

        <!-- Copyright Start -->
        <!-- Copyright End -->



        <!-- Back to Top -->
        <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   

        
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>


    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    </body>

</html>