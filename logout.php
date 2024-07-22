<!-- manageProducts.php -->
<?php
// Initialize the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page
header("location: login.php");
exit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>
</head>
<body>
    <h2>Welcome to the Product Management Page</h2>
    <!-- Add a link/button to logout -->
    <a href="logout.php">Logout</a>
</body>
</html>
