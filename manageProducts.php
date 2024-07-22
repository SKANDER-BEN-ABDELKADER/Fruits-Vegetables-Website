<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "fruits";

try {
    // Établir la connexion PDO
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Préparer la requête SQL
    $sql = "SELECT * FROM products";
    $stmt = $conn->prepare($sql);

    // Exécuter la requête
    $stmt->execute();

    // Récupérer tous les résultats
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    // Gérer les erreurs de connexion
    die("Connection failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Bootstrap CRUD Data Table for Database with Modal Form</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<link href="m_users.css" rel="stylesheet">

<script>
$(document).ready(function(){
	// Activate tooltip
	$('[data-toggle="tooltip"]').tooltip();
	
	// Select/Deselect checkboxes
	var checkbox = $('table tbody input[type="checkbox"]');
	$("#selectAll").click(function(){
		if(this.checked){
			checkbox.each(function(){
				this.checked = true;                        
			});
		} else{
			checkbox.each(function(){
				this.checked = false;                        
			});
		} 
	});
	checkbox.click(function(){
		if(!this.checked){
			$("#selectAll").prop("checked", false);
		}
	});
});
</script>
</head>
<body>
<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper">
			<div class="table-title">
				<div class="row">
					<div class="col-sm-6">
						<a href="manageProducts.php" style="color: white;"><h2>Manage <b>Products</b></h2></a>
					</div>
					<div class="col-sm-6">
						<a href="add_product.php" class="btn btn-success"><i class="material-icons">&#xE147;</i> <span>Add New Procuct</span></a>						
					</div>
				</div>
			</div>
            <div class="table-title">
				<div class="row">
					<div class="col-sm-6">
					<a href="manageUsers.php" style="color: white;"><h2>Manage <b>Users</b></h2></a>
					</div>
					<div class="col-sm-6">
						<a href="logout.php" class="btn btn-info btn-lg"><span class="glyphicon glyphicon-log-out"></span> Log out</a>						
					</div>
				</div>
			</div>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>
						</th>
						<th>Name</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Description</th>
						<th>Image</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
				<?php
                if (count($result) > 0) {
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['type'] . "</td>";
                        echo "<td>" . $row['price'] . "</td>";
                        echo "<td>" . $row['descr'] . "</td>";
                        echo "<td>" . $row['image'] . "</td>";
                        echo "<td style='display: flex; gap: 5px; color: white;'><a class='btn btn-info btn-sm' href='update_product.php?id=" . $row['id'] . "'>Edit</a><a class='btn btn-danger btn-sm' href='delete_product.php?id=" . $row['id'] . "'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No users found</td></tr>";
                }
                ?>
					 
				</tbody>
			</table>
		</div>
	</div>        
</div>


<div id="editEmployeeModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form>
				<div class="modal-header">						
					<h4 class="modal-title">Edit Product</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control" required>
					</div>
                    <div class="form-group">
						<label>Type</label>
						<input type="text" class="form-control" required>
					</div>
                    <div class="form-group">
						<label>Price</label>
						<input type="number" class="form-control" required>
					</div>
                    <div class="form-group">
						<label>Description</label>
						<textarea class="form-control" required></textarea>
					</div>
					<div class="form-group">
						<label>Image</label>
						<input type="" class="form-control" required>
					</div>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-success" value="Add">
				</div>
			</form>
		</div>
	</div>
</div>
</body>
</html>