<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "fruits";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $user_id = $_POST["user_id"];
    $fullname = $_POST['fullname'];
    $company_name = $_POST['companyname'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $sql = "UPDATE users SET fullname=:fullname, companyname=:companyname, address=:address, mobile=:mobile, pass=:pass WHERE user_id=:user_id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':fullname', $fullname);
    $stmt->bindParam(':companyname', $company_name);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':mobile', $mobile);
    $stmt->bindParam(':pass', $pass);
    $stmt->bindParam(':user_id', $user_id);

    try {
        $stmt->execute();
        echo "<script>alert('User updated successfully');</script>";
    } catch(PDOException $e) {
        echo "<script>alert('Error updating record: " . $e->getMessage() . "');</script>";
    }
}

if (isset($_GET["user_id"])) {
    $user_id = $_GET["user_id"];
    $sql = "SELECT * FROM users WHERE user_id=:user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    
    try {
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "<script>alert('User not found');</script>";
        exit();
    }
} else {
    echo "<script>alert('Invalid request');</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Update User</h2>
        <form method="post">
            <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
            <div class="form-group">
                <label for="fullname">Name:</label>
                <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $row['fullname']; ?>">
            </div>
            <div class="form-group">
                <label for="companyname">Company name:</label>
                <input type="text" class="form-control" id="companyname" name="companyname" value="<?php echo $row['companyname']; ?>">
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo $row['address']; ?>">
            </div>
            <div class="form-group">
                <label for="mobile">Mobile:</label>
                <input type="number" class="form-control" id="mobile" name="mobile" value="<?php echo $row['mobile']; ?>">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="pass">Password:</label>
                <input type="password" class="form-control" id="pass" name="pass" value="<?php echo $row['pass']; ?>">
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update</button>
            <a class="btn btn-info" href="manageUsers.php">Back</a>
        </form>
    </div>
</body>
</html>
