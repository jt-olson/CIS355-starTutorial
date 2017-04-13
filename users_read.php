<?php
  session_start();

  if(!($_SESSION['cred']=='ADMIN')){
    header('Location: index.php');
    exit;
  }
    require 'database.php';
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: users.php");
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM users where id = ?";
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
         <h2>Read a User</h2>
     </div>
    <div class="table-wrapper">
        <table class="alt">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Photo</th>
                    <th>Email Address</th>
                    <th>Mobile Number</th>
                    <th>Username</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $data['name'];?></td>
                    <td width="200"><?php if (!empty(base64_encode($data['picture'])))
                                echo '<img  height=5%; width=50%; src="data:image/jpeg;base64,' . base64_encode( $data['picture'] ) . '" />'; 
                              else 
                                echo 'No photo on file.';?></td>
                    <td><?php echo $data['email'];?></td>
                    <td><?php echo $data['mobile'];?></td>
                    <td><?php echo $data['username']?></td>
                </tr>
            </tbody>
        </table> 
      <div class="actions">
        <a class="button" href="users.php">Back</a>
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