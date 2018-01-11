<?php
$pageTitle = "Candidates"; 
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
        <a href="candidates.php"><li <?php if($subTitleNav == ""){ echo "class='selected'"; } ?>>Recently Added</li></a>
        <a href="candidates.php?subtitle=az"><li <?php if($subTitleNav == "az"){ echo "class='selected'"; } ?>>A to Z</li></a>
        <a href="candidates.php?subtitle=za"><li <?php if($subTitleNav == "za"){ echo "class='selected'"; } ?>>Z to A</li></a>
        <a href="candidates.php?subtitle=addnew"><li <?php if($subTitleNav == "addnew"){ echo "class='selected'"; } ?>>Add New</li></a>
    </ul>
</div>

<div class="col-md-8" id="vacancy-main-content">
    
<?php
    
switch($subTitleNav){
    case "az":
        include("includes/azcandidates.php");
        break;
        
        case "za":
        include("includes/zacandidates.php");
        break;
        
        case "addnew":
        include("includes/addcandidate.php");
        break;
        
    default:
        include("includes/recentcandidates.php");
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