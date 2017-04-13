<!DOCTYPE html>
<?php
session_start();
if(!($_SESSION['cred']=='ADMIN')){
  header('Location: index.php');
  exit;
}
    require 'database.php';
 
    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
        $emailError = null;
        $phoneError = null;
         
        // keep track post values
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
         
        // validate input
        $valid = true;
        if (empty($name)) {
            $nameError = 'Please enter Name';
            $valid = false;
        }
         
        if (empty($email)) {
            $emailError = 'Please enter Email Address';
            $valid = false;
        } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
            $emailError = 'Please enter a valid Email Address';
            $valid = false;
        }
         
        if (empty($phone)) {
            $phoneError = 'Please enter Phone Number';
            $valid = false;
        }
         
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO agents (name,phone,email) values(?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($name,$phone,$email));
            Database::disconnect();
            header("Location: agents.php");
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
    <div class="alt">
     
                <div class="inner">
                    <div class="row">
                        <h3>Add New Agent</h3>
                    </div>
             
                    <form action="agents_create.php" method="post">
                    <div class="row uniform">
                      <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                        <label class="control-label">Name</label>
                        <div class="controls">
                            <input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
                            <?php if (!empty($nameError)): ?>
                                <span class="help-inline"><?php echo $nameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
                        <label>Email Address</label>
                        <div class="controls">
                            <input name="email" type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
                            <?php if (!empty($emailError)): ?>
                                <span class="help-inline"><?php echo $emailError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($phoneError)?'error':'';?>">
                        <label class="control-label">Phone Number</label>
                        <div class="controls">
                            <input name="phone" type="text"  placeholder="Phone Number" value="<?php echo !empty($phone)?$phone:'';?>">
                            <?php if (!empty($phoneError)): ?>
                                <span class="help-inline"><?php echo $phoneError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      </div>
                      <div class="form-actions">
                          <input type="button" onclick="this.form.submit()" class="button small" value="Create"></input>
                          <input type="button" onclick="window.location='agents.php'" class="button small"value="Back"></input>
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