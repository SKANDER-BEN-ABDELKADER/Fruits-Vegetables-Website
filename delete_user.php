<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "fruits";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // Configure PDO to throw exceptions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<script>alert('Connected successfully');</script>";
} catch(PDOException $e) {
    echo "<script>alert('Connection failed: " . $e->getMessage() . "');</script>";
}

// Check if the 'id' parameter is set in the URL
if (isset($_GET["user_id"])) {
    $user_id = $_GET["user_id"];

    try {
        // SQL to delete a record
        $sql = "DELETE FROM users WHERE user_id=:user_id";
        // Prepare statement
        $stmt = $conn->prepare($sql);
        // Bind parameters
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        // Execute the statement
        $stmt->execute();
        // Check if deletion was successful
        echo "<script>alert('User deleted successfully');</script>";
    } catch(PDOException $e) {
        // Error deleting record
        echo "<script>alert('Error deleting user: " . $e->getMessage() . "');</script>";
    }
} else {
    echo "<script>alert('Invalid request');</script>";
    exit();
}

// Redirect back to the view page after deletion
header("Location: manageUsers.php");
exit();
?>
