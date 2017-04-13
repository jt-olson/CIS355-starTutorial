<?php
session_start();
if(!isset($_SESSION['cred'])){
  session_destroy();
  header('Location: login.php');
  exit;
}
    require 'database.php';
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: policies.php");
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM policies where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();
    }
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
</head>
 
<body>
<div class="alt">
     <div class="inner">
         <h2>Read a Policy</h2>
     </div>
    <div class="table-wrapper">
        <table class="alt">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Owner</th>
                    <th>Agent</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $data['insurance'];?></td>
                    <td><?php echo $data['description'];?></td>
                    <td><?php echo $data['type'];?></td>
                    <td><?php echo $data['owner'];?></td>
                    <td><?php echo $data['agent'];?></td>
                </tr>
            </tbody>
        </table> 
      <div class="actions">
        <a class="button" href="policies.php">Back</a>
      </div>
    </div>
  </div>
    <script src="js/jquery.min.js"></script>
			<script src="js/jquery.scrolly.min.js"></script>
			<script src="js/jquery.scrollex.min.js"></script>
			<script src="js/skel.min.js"></script>
			<script src="js/util.js"></script>
			<script src="js/main.js"></script>
  </body>
</html>