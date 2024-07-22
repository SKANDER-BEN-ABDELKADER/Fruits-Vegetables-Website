<?php

// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "fruits";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  // Set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Check if the request is a POST with a valid product ID
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $productId = (int) $_POST['id']; // Cast to integer for safety

    // Check if the user is logged in (optional security measure)
    if (isset($_SESSION['user_id'])) {
      $userId = $_SESSION['user_id'];

      // Delete the item from the cart for the logged-in user
      $stmt = $conn->prepare("DELETE FROM cart WHERE product_id = :productId AND user_id = :userId");
      $stmt->bindParam(':productId', $productId);
      $stmt->bindParam(':userId', $userId);
      $stmt->execute();

      // Handle successful deletion
      if ($stmt->rowCount() > 0) {
        echo "success"; // Send a success message for AJAX or redirect
      } else {
        echo "Item not found"; // Inform if deletion failed (e.g., item not in cart)
      }
    } else {
      echo "Unauthorized access"; // Handle unauthorized deletion attempt
    }
  } else {
    echo "Invalid request"; // Inform about incorrect request method or missing data
  }
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage(); // Display error for debugging purposes
}

?>
