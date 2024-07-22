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

// Check if $_GET["id"] is set
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM products WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    
    try {
        $stmt->execute();
        // Fetch the product information
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // Check if the product exists
        if (!$row) {
            echo "<script>alert('Product not found');</script>";
            exit();
        }
    } catch(PDOException $e) {
        echo "<script>alert('Error fetching product information');</script>";
        exit();
    }
} else {
    echo "Invalid request";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $id = $_POST["id"];
    $name = $_POST['name'];
    $type = isset($_POST['type']) ? $_POST['type'] : ""; 
    $price = $_POST['price'];
    $descr = $_POST['descr'];

    // Check if a new image is uploaded
    if ($_FILES["image"]["error"] !== UPLOAD_ERR_NO_FILE) {
        // Handle file upload
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Check file size
        if ($_FILES["image"]["size"] > 500000) {
            echo "<script>alert('Sorry, your file is too large.');</script>";
            $uploadOk = 0;
        }
        
        // Allow certain file formats
        $allowedFormats = array("jpg", "jpeg", "png");
        if (!in_array($imageFileType, $allowedFormats)) {
            echo "<script>alert('Sorry, only JPG, JPEG, and PNG files are allowed.');</script>";
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
            } else {
                echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
            }
        }
    } else {
        // No new image uploaded, retain the existing image path
        $image = $row['image'];
    }

    // Update the product information in the database
    $sql = "UPDATE products SET name=:name, type=:type, price=:price, descr=:descr, image=:image WHERE id=:id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':descr', $descr);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':id', $id);

    try {
        $stmt->execute();
        echo "<script>alert('Product updated successfully');</script>";
    } catch(PDOException $e) {
        echo "<script>alert('Error updating record: " . $e->getMessage() . "');</script>";
    }
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM products WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    
    try {
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        echo "<script>alert('Product not found');</script>";
        exit();
    }
} else {
    echo "Invalid request";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Update Product</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>">
            </div>
            <div class="form-group">
                <label for="type">Type:</label>
                <select class="form-control" id="typeSelect" name="type">
                    <option value="Fruits" <?php if($row['type'] == 'Fruits') echo 'selected'; ?>>Fruits</option>
                    <option value="Vegetables" <?php if($row['type'] == 'Vegetables') echo 'selected'; ?>>Vegetables</option>
                </select>
                <input type="text" class="form-control" id="typeInput" name="typeInput" value="<?php if($row['type'] != 'Fruits' && $row['type'] != 'Vegetables') echo $row['type']; ?>" <?php if($row['type'] == 'Fruits' || $row['type'] == 'Vegetables') echo 'style="display: none;"'; ?>>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?php echo $row['price']; ?>">
            </div>
            <div class="form-group">
                <label for="descr">Description:</label>
                <textarea class="form-control" id="descr" name="descr" rows="3"><?php echo $row['descr']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image :</label>
                <input type="file" class="form-control" id="image" name="image" accept=".jpg, .jpeg, .png" >
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update</button>
            <a class="btn btn-info" href="manageProducts.php">Back</a>
        </form>
    </div>
</body>
</html>
