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
?>
