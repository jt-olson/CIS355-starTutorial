<?php
session_start();
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
            </div>
                <?php if (!(isset($_SESSION['cred']))){
                  echo '<p>You are not logged in. Please login to see more options</p>';
                  echo '<a class="button special small" href="login.php">Login</a>';
                }
                else{
                  echo '<p>You are logged in as '.$_SESSION['username'].'</p>';
                  echo '<a class="button small" href="logout.php">Logout</a>'; 
                }?>
        <div class="inner">
				<h4>Agents</h4>
            
          <div class="inner">
          <?php if(isset($_SESSION['cred'])){
            if($_SESSION['cred']=='ADMIN')
              echo '<a href="agents_create.php" class="button special">Add Agent</a>';
              echo '<a href="policies.php" class="button">View Policies</a>';
              if($_SESSION['cred']=='ADMIN')
                echo '<a href="users.php" class="button">View Users</a>';
          }
          ?>
                <table class="alt">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Email Address</th>
                      <th>Mobile Number</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                   include 'database.php';
                   $pdo = Database::connect();
                   $sql = 'SELECT * FROM agents ORDER BY id DESC';
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['name'] . '</td>';
                            echo '<td>'. $row['email'] . '</td>';
                            echo '<td>'. $row['phone'] . '</td>';
                    echo '<td width=250>';
                            echo '<a class="button fit small" href="agents_read.php?id='.$row['id'].'">Read</a>';
                            echo ' ';
                            if($_SESSION['cred']=='ADMIN'){
                              echo '<a class="button fit small" href="agents_update.php?id='.$row['id'].'">Update</a>';
                              echo ' ';
                              echo '<a class="button special fit small" href="agents_delete.php?id='.$row['id'].'">Delete</a>';
                            }
                            echo '</td>';
                   }
                   Database::disconnect();
                  ?>
                  </tbody>
            </table>
          </div>
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