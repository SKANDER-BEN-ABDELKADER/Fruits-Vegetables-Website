<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "fruits";

try {
    // Establish database connection using PDO
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // Set PDO to throw exceptions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Start session
    session_start();

    // Check if the user is already logged in, redirect to home page if logged in
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        header("location: index.php");
        //echo "<p>You are already logged in. <a href='index.php'>Go to Home Page</a></p>";
        exit;
    }

    // Define variables and initialize with empty values
    $email = $pass = "";
    $email_err = $pass_err = "";

    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if email is empty
        if (empty(trim($_POST["email"]))) {
            $email_err = "Please enter email.";
        } else {
            $email = trim($_POST["email"]);
        }

        // Check if password is empty
        if (!isset($_POST["pass"]) || empty(trim($_POST["pass"]))) {
            $pass_err = "Please enter your password.";
        } else {
            $pass = trim($_POST["pass"]);
        }
        

        // Validate credentials
        if (empty($email_err) && empty($pass_err)) {
            // Prepare a select statement
            $sql = "SELECT user_id, pass, email, is_admin FROM users WHERE email = :email";

            if ($stmt = $conn->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":email", $email, PDO::PARAM_STR);

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    // Check if email exists
                    if ($stmt->rowCount() == 1) {
                        // Fetch result row as an associative array
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                        // Verify password
                        if ($_POST["pass"] == $row['pass']) {
                            // Password is correct, start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $row['user_id'];
                            $_SESSION["email"] = $row['email'];
                            $_SESSION["is_admin"] = $row['is_admin'];

                            // Debugging: Print session variables
                            echo "Session variables set:<br>";
                            echo "Loggedin: " . $_SESSION["loggedin"] . "<br>";
                            echo "ID: " . $_SESSION["user_id"] . "<br>";
                            echo "Email: " . $_SESSION["email"] . "<br>";
                            echo "Admin: " . $_SESSION["is_admin"] . "<br>";

                            // Redirect user based on admin status
                            if ($row['is_admin'] == 1) {
                                header("location: manageUsers.php");
                            } else {
                                header("location: index.php");
                            }
                            exit;
                        } else {
                            // Display an error message if password is not valid
                            $pass_err = "The password you entered was not valid.";
                        }
                    } else {
                        // Display an error message if email doesn't exist
                        $email_err = "No account found with that email.";
                    }
                } else {
                    // Display an error message if execution failed
                    echo "<script>alert('Oops! Something went wrong. Please try again later.');</script>";
                }

                // Close statement
                unset($stmt);
            }
        }
    }
} catch (PDOException $e) {
    // Display an error message if database connection failed
    echo "<script>alert('Connection failed: " . $e->getMessage() . "');</script>";
}

// Close connection
$conn = null;
?>



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
                        <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="https://getbootstrap.com/docs/4.0/components/forms/" class="text-white">123 Street, New York</a>/</small>
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
                    <a href="index.php" class="nav-item nav-link">Home</a>
                    <a href="shop.php" class="nav-item nav-link">Shop</a>
                    <a href="testimonial.php" class="nav-item nav-link">Testimonial</a>
                    <a href="contact.php" class="nav-item nav-link">Contact</a>
                </div>
                <div class="d-flex m-3 me-0">
                    <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search text-primary"></i></button>
                </div>
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
            <h1 class="text-center text-white display-16">Fruitables</h1>
        </div>
        <!-- Single Page Header End -->


        <!-- Checkout Page Start -->
    <!-- Removed outer <form> tag -->

<!-- Login Form -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <h1 class="mb-4" id="log">Login to shop !</h1>
        <h5 class="mb-4" id="log2">No account ? <a href="SignIn.php">Register</a></h5> 
        <form action="login.php" method="post">
            <div class="row g-5">
                <div class="col-md-6" id="form">
                    <div class="row">
                        <div class="form-item">
                            <label class="form-label my-3">Email Address<sup>*</sup></label>
                            <input type="email" class="form-control" name="email" value="">
                            <!-- Display Email Error -->
                            <span class="text-danger"><?php echo $email_err; ?></span>
                        </div>
                        <div class="form-item">
                            <label class="form-label my-3">Password<sup>*</sup></label>
                            <input type="password" class="form-control" name="pass">
                            <!-- Display Password Error -->
                            <span class="text-danger"><?php echo $pass_err; ?></span>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="col-lg-6">
                        <button type="submit" value="Login" class="btn btn-primary btn-lg custom-width" id="Submit" style="  position: relative; left: 95%; ">Login</button>  
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Login Form End -->

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
        <div class="container-fluid copyright bg-dark py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>Your Site Name</a>, All right reserved.</span>
                    </div>
                    <div class="col-md-6 my-auto text-center text-md-end text-white">
                        <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                        <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                        <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                        Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a> Distributed By <a class="border-bottom" href="https://themewagon.com">ThemeWagon</a>
                    </div>
                </div>
            </div>
        </div>
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
