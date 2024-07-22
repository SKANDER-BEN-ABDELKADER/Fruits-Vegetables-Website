<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "fruits";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // Configuration de PDO pour générer des exceptions en cas d'erreur
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add"])) {
        $fullname = $_POST['fullname'];
        $company_name = $_POST['companyname'];
        $address = $_POST['address'];
        $mobile = $_POST['mobile'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];

        $sql = "INSERT INTO `users` (`fullname`, `companyname`, `address`, `mobile`, `email`, `pass`) VALUES (:fullname, :companyname, :address, :mobile, :email, :pass)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':companyname', $company_name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':mobile', $mobile);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $pass);

        if ($stmt->execute()) {
            echo "<script>alert('New user created successfully');</script>";
        } else {
            echo "<script>alert('Error: Unable to add new user');</script>";
        }
    }
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add new User</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Add User</h2>
        <form method="post">
            <input type="hidden" name="id" value="">
            <div class="form-group">
                <label for="fullname">Name:</label>
                <input type="text" class="form-control" id="fullname" name="fullname" value="">
            </div>
            <div class="form-group">
                <label for="companyname">Company name:</label>
                <input type="text" class="form-control" id="companyname" name="companyname" value="">
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" id="address" name="address" value="">
            </div>
            <div class="form-group">
                <label for="mobile">Mobile:</label>
                <input type="number" class="form-control" id="mobile" name="mobile" value="">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="">
            </div>
            <div class="form-group">
                <label for="pass">Password:</label>
                <input type="password" class="form-control" id="pass" name="pass" value="">
            </div>

            <button type="submit" name="add" class="btn btn-primary">Add</button>
            <a class="btn btn-info" href="manageUsers.php">Back</a>
        </form>
    </div>
</body>
</html>
