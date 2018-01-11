<?php
ob_start();
session_start();
require("admin/includes/db.php");

if(isset($_SESSION["username"])){
    session_unset(); 
    session_destroy();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    $dbUsername = $results["username"];
    $dbPassword = $results["password"];
    $access = $results["access_level"];
    
    
    
    if(password_verify($password, $dbPassword)){
        $_SESSION["username"] = $dbUsername;
        $_SESSION["access"] = $access;
        $_SESSION["error"] = "none";
        header("Location: admin/admin.php");
    } else {
        $message = "You've entered an incorrect Username or Password";
        
    } 
    
    
    
//    if($dbUsername === $username && $dbPassword === $password){
//        $_SESSION["username"] = $dbUsername;
//        $_SESSION["access"] = $access;
//        $_SESSION["error"] = "none";
//        header("Location: admin/admin.php");
//    } else {
//        $message = "You've entered an incorrect Username or Password";
//        
//    }      
}

//Display error message if incorrect

if(isset($_SESSION["error"])){
    if($_SESSION["error"] == "error"){
    $message = "You've entered an incorrect Username or Password";
    } else {
    $message = "";
}
}


?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Muli:400,600" rel="stylesheet">
    <link rel="stylesheet" href="ats.css" type="text/css">
  </head>
  <body>
      
<!--General title and tag line-->
<div id="header">   
    <div class="container">
        <h2>Track Right</h2>
        <h4>Test Applicant tracking system</h4>
        <a href="../index.php">Take me back to joepeel.co.uk</a>
    </div>
</div>       
      
      
<!--Main body -->
      
<div class="container">
<div class="row">
    
    <div class="col-md-4">
        <h3 class="cardTitle">About Track Right</h3>
        <div>Track Right is an Applicant Tracking System, or "ATS". ATSs are commonly used within the recruitment industry to, as the name suggests, track applicants but also much more such as - manage vacancies, hiring managers and so forth. Track Right, in it's current early version, capitalises on some core functionality of this type of application.
        </div>
    </div>
    
    <div class="col-md-4">
        <h3 class="cardTitle">Features</h3>
        <div>Track right allows me to create, read, update and delete candidate, manager, vacancy and user records, and log the interaction between them.<br><br><p><span class="toBold">Please log in with the username "test" and password "test123".</span></p>
        </div>
    </div>
    
    <div class="col-md-4">
        <h3 class="cardTitle">Login</h3>
        <div id="logInDiv">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="loginForm">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" maxlength="15" name="username" class="form-control" id="username">
                     <div class="form-control-feedback" id="usernameFeedback"></div>
                </div>      
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" maxlength="15" name="password" class="form-control" id="password">
                    <div class="form-control-feedback" id="passwordFeedback"></div>
                </div>           
                <div class="form-group" id="logSubmit">
                    <input type="submit" name="log" class="form-control" id="log">
                </div>         
            </form>
            <h6 id="phpError"><?php echo $message; ?></h6>
        </div>
    </div>
    
</div>
</div>
      
      
<!--Footer-->
      
<div class="footer">
    <p>&copy <?php echo date("Y"); ?> Joe Peel. <a href="../index.php">Take me to home</a></p>
</div>

    <!-- jQuery first, then Tether, then Bootstrap JS. -->
<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
      <script src="ats.js"></script>
  </body>
</html>