<?php
$pageTitle = "Vacancies"; 
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
        <a href="vacancies.php"><li <?php if($subTitleNav == ""){ echo "class='selected'"; } ?>>Live</li></a>
        <a href="vacancies.php?subtitle=viewall"><li <?php if($subTitleNav == "viewall"){ echo "class='selected'"; } ?>>View All</li></a>
        <a href="vacancies.php?subtitle=addnew"><li <?php if($subTitleNav == "addnew"){ echo "class='selected'"; } ?>>Add New</li></a>
    </ul>
</div>

<div class="col-md-8" id="vacancy-main-content">
    
<?php
    
switch($subTitleNav){
    case "viewall":
        include("includes/allvacancies.php");
        break;
        
        case "addnew":
        include("includes/addvacancy.php");
        break;
        
    default:
        include("includes/livevacancies.php");
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
