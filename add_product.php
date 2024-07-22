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
        $name = $_POST['name'];
        $type = $_POST['type'];
        $price = $_POST['price'];
        $descr = $_POST['descr'];

        // File upload handling
        $target_dir = "uploads/"; // Specify the directory where you want to store uploaded files
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            //echo "<script>alert('File is an image - " . $check["mime"] . "');</script>";
            $uploadOk = 1;
        } else {
            //echo "<script>alert('File is not an image.');</script>";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["image"]["size"] > 500000) {
            echo "<script>alert('Sorry, your file is too large.');</script>";
            $uploadOk = 0;
        }

        // Allow certain file formats
        $allowedFormats = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $allowedFormats)) {
            echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "<script>alert('Sorry, your file was not uploaded.');</script>";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                //echo "<script>alert('The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.');</script>";
                $image = $target_file;

                // Insert into database
                $sql = "INSERT INTO `products` (`name`, `type`, `price`, `descr`, `image`) VALUES (:name, :type, :price, :descr, :image)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':type', $type);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':descr', $descr);
                $stmt->bindParam(':image', $image);

                if ($stmt->execute()) {
                    echo "<script>alert('New product created successfully');</script>";
                } else {
                    echo "<script>alert('Error: Unable to add new product');</script>";
                }
            } else {
                echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
            }
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
    <title>Add New Product</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Add Product</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="type">Type:</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="Fruits">Fruits</option>
                    <option value="Vegetables">Vegetables</option>
                </select>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="descr">Description:</label>
                <textarea class="form-control" id="descr" name="descr" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image :</label>
                <input type="file" class="form-control" id="image" name="image" accept=".jpg, .jpeg, .png, .gif" required>
            </div>

            <button type="submit" name="add" class="btn btn-primary">Add</button>
            <a class="btn btn-info" href="manageProducts.php">Back</a>
        </form>
    </div>
</body>
</html>
