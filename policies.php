<?php
session_start();

if(!isset($_SESSION['cred'])){
  session_destroy();
  header('Location: login.php');
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
    <div class="alt">
      <div class="inner">
        <h3><a href="index.php">Joe's Insurance</a></h3>
          <?php if(isset($_SESSION['cred'])){
                  echo '<p>You are logged in as '.$_SESSION['username'].'</p>';
                  echo '<li><a href="logout.php" class="button small">Logout</a></li>';
          }?>
          <h4>Policies</h4>
      </div>
     <div class="inner">
			<p>
				<a href="policies_create.php" class="button special">Add Policy</a>
				<a href="agents.php" class="button">View Agents</a>
       <?php if($_SESSION['cred']=='ADMIN'){
         echo '<a href="users.php" class="button">View Users</a>';
       }?>
             </p>
             <div class="table-wrapper">
             <table class="alt">
               <thead>
                 <tr>
                   <th>Title</th>
                   <th>Description</th>
                   <th>Type of Coverage</th>
                   <?php if($_SESSION['cred']=='ADMIN')
                     echo '<th>Owner</th>';
                   ?>
                   <th>Agent</th>
                   <th>Action</th>
                 </tr>
               </thead>
               <tbody>
               <?php
                include 'database.php';
                $pdo = Database::connect();
                $sql = 'SELECT * FROM policies ORDER BY id DESC';
                foreach ($pdo->query($sql) as $row) {
                   if(($_SESSION['cred']=='ADMIN') or ($_SESSION['username']==$row['owner'])){
                         echo '<tr>';
                         echo '<td>'. $row['insurance'] . '</td>';
                         echo '<td>'. $row['description'] . '</td>';
                         echo '<td>'. $row['type'] . '</td>';
                     
                         if($_SESSION['cred']=='ADMIN')
                           echo '<td>'. $row['owner']. '</td>';
                      echo '<td>'. $row['agent'] .'</td>';
                         echo '<td width=250>';
                         echo '<a class="button fit small" href="policies_read.php?id='.$row['id'].'">Read</a>';
                         echo ' ';
                         echo '<a class="button fit small" href="policies_update.php?id='.$row['id'].'">Update</a>';
                         echo ' ';
                         echo '<a class="button special fit small" href="policies_delete.php?id='.$row['id'].'">Delete</a>';
                         echo '</td>';
                   }
                }
                Database::disconnect();
               ?>
               </tbody>
         </table>
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