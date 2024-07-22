<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "fruits";

try {
    // Start session


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
        
        // Check if form is submitted for adding to cart
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_to_cart"])) {
            // Check if user is logged in
            if (isset($_SESSION['loggedin']) && isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id']; // Use session user_id
                $product_id = $row['id']; // Use product ID from database
                $quantity = 1; // Default quantity
                $addToCartUrl="cart.php";

                // Insert the product into the cart
                $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':product_id', $product_id);
                $stmt->bindParam(':quantity', $quantity);
                if ($stmt->execute()) {
                    echo "New product added to cart successfully";
                } else {
                    echo "Error: Unable to add new product to cart";
                }
            } else {
                // Redirect to login page if user is not logged in
                header("Location: login.php");
                exit();
            }
        }
    } else {
        echo "Product not found";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}



<td>
<a href="delete_from_cart.php?id='.$row['id'].'">
    <button class="btn btn-md rounded-circle bg-light border mt-4 delete-product-btn" >
        <i class="fa fa-times text-danger"></i>
    </button>
</a>
</td>