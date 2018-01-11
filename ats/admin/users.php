<?php
$pageTitle = "Users"; 
require("includes/headernav.php");
?>

<?php
$subTitleNav = "";

if(isset($_GET["subtitle"])){
    $subTitleNav = $_GET["subtitle"];
}

?>

<?php
//$else = header("Location: includes/logout.php");
if(isset($_SESSION["access"])){
    if($_SESSION["access"] != 697){
        header("Location: includes/logout.php");
    }
} else {
    header("Location: includes/logout.php");
}


?>

<div class="col-md-2" id="subSideNavDiv">
    <ul class="subSideNav">
        <a href="users.php"><li <?php if($subTitleNav == ""){ echo "class='selected'"; } ?>>All</li></a>
        <a href="users.php?subtitle=addnew"><li <?php if($subTitleNav == "addnew"){ echo "class='selected'"; } ?>>Add New</li></a>
    </ul>
</div>

<div class="col-md-8" id="vacancy-main-content">
    

<?php
    
switch($subTitleNav){
 
        case "addnew":
        include("includes/adduser.php");
        break;
        
    default:
        include("includes/allusers.php");
        break;
}   
    

?>
   

</div>
<!--End of main content div-->

</div>
<!--End of page row-->
<?php
require("includes/footer.php");
?>