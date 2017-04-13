<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION['cred'])){
  session_destroy();
  header('Location: login.php');
  exit;
}
    require 'database.php';
 
    if ( !empty($_POST)) {
        // keep track validation errors
        $titleError = null;
        $descriptionError = null;
        $typeError = null;
        $agentError = null;
        $ownerError = null;
         
        // keep track post values
        $title = $_POST['title'];
        $description = $_POST['description'];
        $type = $_POST['type'];
        if($_SESSION['cred']=='ADMIN')
          $owner = $_POST['Owner'];
        else
          $owner = $_SESSION['username'];
        $agent = $_POST['Agent'];
         
        // validate input
        $valid = true;
        if (empty($title)) {
            $titleError = 'Please enter Title';
            $valid = false;
        }
         
        if (empty($description)) {
            $descriptionError = 'Please enter Description';
            $valid = false;
        }
         
        if (empty($type)) {
            $typeError = 'Please enter Type';
            $valid = false;
        }
        
        if (empty($agent)){
          $agentError = 'Please select an Agent';
          $valid = false;
        }
        
        if (empty($owner)){
          $ownerError = 'Please select an Owner';
          $valid = false;
        }
         
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO policies (insurance,description,type,owner,agent) values(?, ?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($title,$description,$type,$owner,$agent));
            Database::disconnect();
            header("Location: policies.php");
        }
    }
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
</head>
 
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Create Policy</h3>
                    </div>
             
                    <form class="form-horizontal" action="policies_create.php" method="post">
                      <div class="control-group <?php echo !empty($titleError)?'error':'';?>">
                        <label class="control-label">Title</label>
                        <div class="controls">
                            <input name="title" type="text"  placeholder="Title" value="<?php echo !empty($title)?$title:'';?>">
                            <?php if (!empty($titleError)): ?>
                                <span class="help-inline"><?php echo $titleError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($descriptionError)?'error':'';?>">
                        <label class="control-label">Description</label>
                        <div class="controls">
                            <input name="description" type="text" placeholder="Description" value="<?php echo !empty($description)?$description:'';?>">
                            <?php if (!empty($descriptionError)): ?>
                                <span class="help-inline"><?php echo $descriptionError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($typeError)?'error':'';?>">
                        <label class="control-label">Type</label>
                        <div class="controls">
                            <input name="type" type="text"  placeholder="Type" value="<?php echo !empty($type)?$type:'';?>">
                            <?php if (!empty($typeError)): ?>
                                <span class="help-inline"><?php echo $typeError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      
                      <!--Dropdown menu -->
                      <div class="control-group <?php echo !empty($agentError)?'error':'';?>">
                        <label class="control-label">Agent</label>
                        <div class="controls">
                              <select name="Agent">
                                <?php 
                                $pdo = Database::connect();
                                $sql = 'SELECT * FROM agents';
                                echo '<option value="">Select agent</option>';
                                foreach ($pdo->query($sql) as $row) {
                                  echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
                                }
                                Database::disconnect();
                                ?>
                                </select>
                            <?php if (!empty($agentError)): ?>
                                <span class="help-inline"><?php echo $agentError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      
                      <?php 
                      if($_SESSION['cred']=='ADMIN'){
                      echo '<div class="control-group'. (!empty($ownerError)?error:'').'">';
                        echo '<label class="control-label">Owner</label>';
                        echo '<div class="controls">';
                              echo'<select name="Owner">';
                                
                                $pdo = Database::connect();
                                $sql = 'SELECT * FROM users WHERE cred = "CUST"';
                                echo '<option value="">Select customer</option>';
                                foreach ($pdo->query($sql) as $row) {
                                  echo '<option value="'.$row['username'].'">'.$row['username'].' - '.$row['name'].'</option>';
                                }
                                Database::disconnect();
                                
                                echo '</select>';
                            if (!empty($ownerError)):
                                echo '<span class="help-inline">'.$ownerError.'</span>';
                             endif;
                        echo '</div>';
                      echo '</div>';
                      }
                      ?>
                      <div class="form-actions">
                          <input type="button" onclick="this.form.submit()" class="button small" value="Create"></input>
                          <input type="button" onclick="window.location='policies.php'" class="button small"value="Back"></input>
                        </div>
                    </form>
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