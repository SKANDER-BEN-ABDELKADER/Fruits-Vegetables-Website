<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "fruits";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // Configure PDO to throw exceptions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage() ;
}

// Check if the 'id' parameter is set in the URL
if (isset($_GET["user_id"]) && ($_GET["product_id"]) ) {
    $productId = $_GET["id"];
    $userId = $_SESSION['user_id'];

    // Debugging: Log received product ID
    echo "<script>alert('Received product ID: " . $productId . "');</script>";

    try {
        // SQL to delete a record
        $sql = "DELETE FROM cart  WHERE product_id = :productId AND user_id = :userId";
        // Prepare statement
        $stmt = $conn->prepare($sql);
        // Bind parameters
        $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
        // Execute the statement
        $stmt->execute();
        // Check if deletion was successful
        echo "<script>alert('Product deleted successfully');</script>";
    } catch(PDOException $e) {
        // Error deleting record
        echo "<script>alert('Error deleting record: " . $e->getMessage() . "');</script>";
    }
} else {
    echo "Invalid request";
    exit();
}

// Redirect back to the view page after deletion
header("Location: cart.php");
exit();
?>
