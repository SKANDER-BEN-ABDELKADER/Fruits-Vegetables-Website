<?php
// Configuration de la base de données
$servername = "localhost";
$username = "root";
$password = "";
$database = "fruits";

try {
    // Connexion à la base de données avec PDO
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // Configuration de PDO pour qu'il lance des exceptions en cas d'erreur
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL pour récupérer tous les utilisateurs
    $sql = "SELECT * FROM users";
    // Préparation de la requête
    $stmt = $conn->prepare($sql);
    // Exécution de la requête
    $stmt->execute();
} catch (PDOException $e) {
    // Affichage d'un message d'erreur si la connexion à la base de données échoue
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
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<link href="m_users.css" rel="stylesheet">
<script>
$(document).ready(function(){
	// Activation des tooltips
	$('[data-toggle="tooltip"]').tooltip();
	
	// Sélection/Déselection des cases à cocher
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
                        <a href="manageUsers.php" style="color: white;"><h2>Manage <b>Users</b></h2></a>
					</div>
					<div class="col-sm-6">
						<a href="add_user.php" class="btn btn-success"><i class="material-icons">&#xE147;</i> <span>Add New User</span></a>						
					</div>
				</div>
			</div>
            <div class="table-title">
				<div class="row">
					<div class="col-sm-6">
						<a href="manageProducts.php" style="color: white;"><h2>Manage <b>Products</b></h2></a>
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
                        <th>Company Name</th>
                        <th>Address</th>
                        <th>Mobile</th>
						<th>Email</th>
						<th>Password</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
				<?php
                if ($stmt->rowCount() > 0) {
                    while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . $rows['user_id'] . "</td>";
                        echo "<td>" . $rows['fullname'] . "</td>";
                        echo "<td>" . $rows['companyname'] . "</td>";
                        echo "<td>" . $rows['address'] . "</td>";
                        echo "<td>" . $rows['email'] . "</td>";
						echo "<td>" . $rows['mobile'] . "</td>";
						echo "<td>" . $rows['pass'] . "</td>";
						echo "<td style='display: flex; gap: 5px; color: white;'><a class='btn btn-info btn-sm' href='update_user.php?user_id=" . $rows['user_id'] . "'>Edit</a><a class='btn btn-danger btn-sm' href='delete_user.php?user_id=" . $rows['user_id'] . "'>Delete</a></td>";
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
</body>
</html>
