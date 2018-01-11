<?php
$pageTitle = "Managers"; 
require("includes/headernav.php");
?>

<?php
$subTitleNav = "";

if(isset($_GET["subtitle"])){
    $subTitleNav = $_GET["subtitle"];
}

?>

<div class="col-md-2" id="subSideNavDiv">
    <ul class="subSideNav">
        <a href="managers.php"><li <?php if($subTitleNav == ""){ echo "class='selected'"; } ?>>All</li></a>
        <a href="managers.php?subtitle=addnew"><li <?php if($subTitleNav == "addnew"){ echo "class='selected'"; } ?>>Add New</li></a>
    </ul>
</div>

<div class="col-md-8" id="vacancy-main-content">
    
<?php
    
switch($subTitleNav){
 
        case "addnew":
        include("includes/addmanager.php");
        break;
        
    default:
        include("includes/allmanagers.php");
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