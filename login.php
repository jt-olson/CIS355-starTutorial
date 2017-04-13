<?php 
    
    session_start();
    
    # include connection data and functions
    require 'database.php';
    
    # if there was data passed, then verify password, 
    # otherwise do nothing (that is, just display html for login)
    if ( !empty($_POST)) {
        // keep track validation errors
        $userNameError = null;
        $passwordError = null;
        
        // keep track post values
        $userName = $_POST['username'];
        $password = $_POST['password'];
        $cred = $_POST['cred'];
        
        // validate input
        $valid = true;
        if (empty($userName)) {
            $userNameError = 'Please enter user name';
            $valid = false;
        }
        
        if (empty($password)) {
            $passwordError = 'Please enter password';
            $valid = false;
        } 
        
        // verify that password is correct for user name
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
            $q = $pdo->prepare($sql);
            $q->execute(array($userName));
            $results = $q->fetch(PDO::FETCH_ASSOC);
            if($results['password']==$password) {
                $_SESSION['username'] = $userName;
                $_SESSION['cred'] = $results['cred'];
                Database::disconnect();
                header("Location: index.php"); // redirect
            }
            else {
                $passwordError = 'Password is not valid';
                Database::disconnect();
            }
        }
    } # end if ( !empty($_POST))
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
                    <div class="row">
                        <h3>Login</h3>
                    </div>
            
                    <form class="form-horizontal" action="login.php" method="post">
                    
                      <div class="control-group <?php echo !empty($userNameError)?'error':'';?>">
                        <label class="control-label">User Name</label>
                        <div class="controls">
                              <input name="username" type="text"  placeholder="Name" value="<?php echo !empty($userName)?$userName:'';?>">
                              <?php if (!empty($userNameError)): ?>
                                  <span class="help-inline"><?php echo $userNameError;?></span>
                              <?php endif; ?>
                        </div>
                      </div>
                      
                      <div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
                        <label class="control-label">Password</label>
                        <div class="controls">
                              <input name="password" type="password" placeholder="password" value="<?php echo !empty($password)?$password:'';?>">
                              <?php if (!empty($passwordError)): ?>
                                  <span class="help-inline"><?php echo $passwordError;?></span>
                              <?php endif;?>
                        </div>
                      </div>
                      
                      <div class="form-actions">
                          <input type="button" onclick="this.form.submit()" class="button small" value="Login"></input>
                          <input type="button" onclick="window.location='index.php'" class="button small"value="Back"></input>
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