<?php
session_start();

if(!($_SESSION['cred']=='ADMIN')){
  header('Location: index.php');
  exit;
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
    <div class="inner">
        <div class="inner">
           <h3><a href="index.php">Joe's Insurance</a></h3>
           <?php if(isset($_SESSION['cred'])){
                  echo '<p>You are logged in as '.$_SESSION['username'].'</p>';
                  echo '<li><a href="logout.php" class="button small">Logout</a></li>';
           }?>
				<h4>Users</h4>
            </div>
        <div class="table-wrapper">
				<p>
					<a href="users_create.php" class="button special">Add User</a>
					<a href="agents.php" class="button">View Agents</a>
					<a href="policies.php" class="button">View Policies</a>
                </p>
                <table class="alt">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Email Address</th>
                      <th>Mobile Number</th>
                      <th>Credentials</th>
                      <th>Username</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                   include 'database.php';
                   $pdo = Database::connect();
                   $sql = 'SELECT * FROM users ORDER BY cred';
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['name'] . '</td>';
                            echo '<td>'. $row['email'] . '</td>';
                            echo '<td>'. $row['mobile'] . '</td>';
                            echo '<td>'. $row['cred'] .'</td>';
                            echo '<td>'. $row['username'] .'</td>';
                          echo '<td width=250>';
                            echo '<a class="button fit small" href="users_read.php?id='.$row['id'].'">Read</a>';
                            echo ' ';
                          if(!($row['cred']=='ADMIN')){
                            echo '<a class="button fit small" href="users_update.php?id='.$row['id'].'">Update</a>';
                            echo ' ';
                            echo '<a class="button special fit small" href="users_delete.php?id='.$row['id'].'">Delete</a>';
                          }
                          else{
                            echo '<a class="button fit small disabled" href="users_update.php?id='.$row['id'].'">Update</a>';
                            echo ' ';
                            echo '<a class="button special fit small disabled" href="users_delete.php?id='.$row['id'].'">Delete</a>';
                          }
                            echo '</td>';
                   }
                   Database::disconnect();
                  ?>
                  </tbody>
            </table>
        </div>
    </div> <!-- /container -->
    <script src="js/jquery.min.js"></script>
			<script src="js/jquery.scrolly.min.js"></script>
			<script src="js/jquery.scrollex.min.js"></script>
			<script src="js/skel.min.js"></script>
			<script src="js/util.js"></script>
			<script src="js/main.js"></script>
  </body>
</html>