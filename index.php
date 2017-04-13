<?php
session_start();
include 'fileUpload.php';

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM users where username = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($username));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
  }

if(!empty($_POST)) {
  
  $pictureError = null;
  $picture = $_POST['userfile'];
  $valid = true;
  $username;
  
  
  
  $fileName = $_FILES['userfile']['name'];
  $tmpName  = $_FILES['userfile']['tmp_name'];
  $fileSize = $_FILES['userfile']['size'];
  $fileType = $_FILES['userfile']['type'];
  $content = file_get_contents($tmpName);
  
  $types = array('image/jpeg','image/gif','image/png');
  if($filesize > 0) {
    if(in_array($_FILES['userfile']['type'], $types)) {
    }
    else {
      $filename = null;
      $filetype = null;
      $filesize = null;
      $filecontent = null;
      $pictureError = 'improper file type';
      $valid=false;
    }
  }
  
  if ($valid) {
    fileUpload::upload($content, $fileSize, $username);
    header("Location: index.php");
  }
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
          <h3>Joe's Insurance</h3>
      </div>
      <div class="inner">
          <ul class="actions">
          <?php if (!(isset($_SESSION['cred']))){
                  echo '<p>You are not logged in. Please login to see more options</p>';
                  echo '<li><a href="register.php" class="button special small">Register</a></li>';
                  echo '<li><a href="login.php" class="button small">Login</a></li>';
          }
                else{
                  if (($data['picSize']) > 0)
                    echo '<img height=5%; width=15%; src="data:image/jpeg;base64,' . base64_encode( $data['picture'] ) . '" />'; 
                  else 
                    echo 'No photo on file.';
                  echo '<div class="controls">';
                         echo '<form class="form-horizontal" action="index.php" method="post" enctype="multipart/form-data">';
                         echo '<p>Set user picture</p>';
                         echo '<input type="hidden" name="MAX_FILE_SIZE" value="150000000">';
                         echo '<input name="userfile" type="file" id="userfile">';
                         echo '<input type="button" onclick="this.form.submit()" class="button small" value="Set picture"></input>';
                         echo '</form>';
                  echo '</div>';
                  echo '<p>You are logged in as '.$_SESSION['username'].'</p>';
                  echo '<li><a href="logout.php" class="button small">Logout</a></li>'; 
                }?>
          </ul>
          <table class="alt">
            <thead>
              <tr>
                <th>Agents</th>
                <?php if(isset($_SESSION['cred'])){
                  echo '<th>Policies</th>';
                  if($_SESSION['cred']== 'ADMIN'){
                    echo '<th>Users</th>';
                  }
                }
                ?>
              </tr>
            </thead>
          <tbody>
					<tr>
						<td><a class="button" href="agents.php">View Agents</a></td>
            <?php if(isset($_SESSION['cred'])){
              echo '<td><a class="button" href="policies.php">View Policies</a></td>';
              if($_SESSION['cred']== 'ADMIN'){
                echo '<td><a class="button" href="users.php">View Users</a></td>';
              }
            }?>
					</tr>
                  </tbody>
            </table>
        </div>
    </div> <!-- /container -->
    <!-- Scripts -->
			<script src="js/jquery.min.js"></script>
			<script src="js/jquery.scrolly.min.js"></script>
			<script src="js/jquery.scrollex.min.js"></script>
			<script src="js/skel.min.js"></script>
			<script src="js/util.js"></script>
			<script src="js/main.js"></script>
  </body>
</html>