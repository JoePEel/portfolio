<?php
session_start();
ob_start();
require("db.php");
require("functions.php");
date_default_timezone_set('GMT');
if(!isset($_SESSION["username"])){
    header("Location: ../ats.php");
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <script src="https://use.fontawesome.com/3751d35581.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Muli:400,600" rel="stylesheet">
    <link rel="stylesheet" href="../ats.css" type="text/css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
  </head>
  <body>
      
<div id="topBar">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-md-4" id="topTitle">
                <h6>Track Right</h6>
            </div>
            <div class="col-md-4" id="logout">
                <h6>User: <?php echo $_SESSION["username"]; ?>. <a href="includes/logout.php">Logout</a></h6>
            </div>
        </div>
    </div>
</div>

<div class="titleBar">
    <div class="container">
        <h3><?php echo $pageTitle; ?></h3>
    </div>  
</div>
      
      
<div class="row" id="pageDiv">
    <div class="col-md-2" id="sideNavDiv">
        <ul class="sideNav">
            <a href="admin.php"><li <?php if($pageTitle == "Dashboard"){ echo "class='selected'"; } ?>>Dashboard</li></a>
            <a href="vacancies.php"><li <?php if($pageTitle == "Vacancies"){ echo "class='selected'"; } ?>>Vacancies</li></a>
            <a href="candidates.php"><li <?php if($pageTitle == "Candidates"){ echo "class='selected'"; } ?>>Candidates</li></a>
            <a href="managers.php"><li <?php if($pageTitle == "Managers"){ echo "class='selected'"; } ?>>Hiring Managers</li></a>
            <?php
            if($_SESSION["access"] == 697){
            ?>
            <a href="users.php"><li <?php if($pageTitle == "Users"){ echo "class='selected'"; } ?>>Users</li></a>
            <?php } ?>
        </ul>
    </div>

      
      