<?php
include_once("database.php");
include_once("functions.php");

$sql = "SHOW TABLES";
$result = $conn->query($sql);
?>

<!doctype html>
<html lang="en">
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="fonts/icomoon/style.css">
<link rel="stylesheet" href="css/owl.carousel.min.css">

<link rel="stylesheet" href="css/bootstrap.min.css">

<link rel="stylesheet" href="css/style.css">
<title>Generate Backbonejs Script</title>
<body>
<div class="content">
    <div class="container">
        <h2 class="mb-5">BackboneHelper v1.0
            <small class="d-block kecil">Generate CRUD Application Using Backbonejs-MySQL</small></h2>
        <div class="table-responsive custom-table-responsive">
            <table class="table custom-table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Table Name</th>
                        <th scope="col">Primary Key</th>
                        <th scope="col">Unique Key</th>
                        <th scope="col">Generate</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $i=1;
                    while($row = $result->fetch_array()) {
                        $pk = getPrimaryKey($conn,$row[0]);
                        $unik = getUnique($conn,$row[0]);
                        
                        if($row[0]<>"failed_jobs" && $row[0]<>"migrations" && $row[0]<>"password_reset_tokens" && $row[0]<>"personal_access_tokens"){
                            
                ?>
                    <tr scope="row">
                        <td><?php echo $i; ?></td>
                        <td><a href="#"><?php echo $row[0]; ?></a></td>
                        <td><?php echo $pk; ?><small class="d-block">Primary Key</small></td>
                        <td><?php echo $unik; ?><small class="d-block">Unique Key</small></td>
                        <td>
                            <a href="gen_model.php?table=<?php echo $row[0]; ?>" target="_blank">Class Model</a> | 
                            <a href="gen_controller.php?table=<?php echo $row[0]; ?>" target="_blank">Class Controller</a> |
                            <a href="gen_action.php?table=<?php echo $row[0]; ?>" target="_blank">Class Action</a> |
                            <a href="gen_view.php?table=<?php echo $row[0]; ?>" target="_blank">Class View</a>
                            
                        </td>
                    </tr>
                <?php
                            $i++;
                        }
                        
                    }
                ?>
                </tbody>
            </table>
            <a href="gen_database.php" class="btn btn-primary" target="_blank">DB Connection</a>&nbsp;
            <a href="gen_htaccess.php" class="btn btn-warning" target="_blank">Set htaccess</a>
            <a href="gen_env.php" class="btn btn-warning" target="_blank">Create .env File</a>
            
        </div>
        <h2 class="mb-5">
            <small class="d-block kecil" style="padding-top:20px">Copyrights@2023, Created by : Freddy Wicaksono, M.Kom</small></h2>
    </div>
</div>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>
<?
$conn->close();
?>