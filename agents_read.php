<?php
    require 'database.php';
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: agents.php");
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM agents where id = ?";
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
         <h2>Read an Agent</h2>
     </div>
    <div class="table-wrapper">
        <table class="alt">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email Address</th>
                    <th>Phone Number</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $data['name'];?></td>
                    <td><?php echo $data['email'];?></td>
                    <td><?php echo $data['phone'];?></td>
                </tr>
            </tbody>
        </table> 
      <div class="actions">
        <a class="button" href="agents.php">Back</a>
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