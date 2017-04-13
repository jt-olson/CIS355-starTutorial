<!DOCTYPE html>
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
    }
     
    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
        $descriptionError = null;
        $typeError = null;
        $agentError = null;
         
        // keep track post values
        $name = $_POST['title'];
        $description = $_POST['description'];
        $type = $_POST['type'];
        $agent = $_POST['Agent'];
         
        // validate input
        $valid = true;
        if (empty($name)) {
            $nameError = 'Please enter a Title';
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
          $agentError = "Please select an Agent";
          $valid = false;
        }
         
        // update data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE policies  set insurance = ?, description = ?, type =?, agent = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($name,$description,$type, $agent, $id));
            Database::disconnect();
            header("Location: policies.php");
        }
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM policies where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $name = $data['insurance'];
        $description = $data['description'];
        $type = $data['type'];
        $agent = $data['agent'];
        Database::disconnect();
    }
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
</head>
 
<body>
    <div class="alt">
     
                <div class="inner">
                    <div class="row">
                        <h3>Update a Policy</h3>
                    </div>
             
                    <form class="form-horizontal" action="policies_update.php?id=<?php echo $id?>" method="post">
                      <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                        <label class="control-label">Name</label>
                        <div class="controls">
                            <input name="title" type="text"  placeholder="Title" value="<?php echo !empty($name)?$name:'';?>">
                            <?php if (!empty($nameError)): ?>
                                <span class="help-inline"><?php echo $nameError;?></span>
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
                      <div class="control-group <?php echo !empty($agentError)?'error':'';?>">
                        <label class="control-label">Agent</label>
                        <div class="controls">
                              <select name="Agent">
                                <?php 
                                $pdo = Database::connect();
                                $sql = 'SELECT * FROM agents';
                                echo '<option value="'.!empty($agent)?$agent:''.'">'.!empty($agent)?$agent:''.'</option>';
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
                      <div class="form-actions">
                          <input type="button" onclick="this.form.submit()" class="button small" value="Update"></input>
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