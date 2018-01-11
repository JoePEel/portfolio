<?php
$pageTitle = "Vacancies"; 
require("includes/headernav.php");

// PAGE FOR INDIVIDUAL VACANCY
?>

<?php
$subTitleNav = "";

if(isset($_GET["subtitle"])){
    $subTitleNav = $_GET["subtitle"];
}

?>

<div class="col-md-2" id="subSideNavDiv">
    <ul class="subSideNav">
        <a href="vacancies.php"><li>Live</li></a>
        <a href="vacancies.php?subtitle=viewall"><li <?php if($subTitleNav == "viewall"){ echo "class='selected'"; } ?>>View All</li></a>
        <a href="vacancies.php?subtitle=addnew"><li <?php if($subTitleNav == "addnew"){ echo "class='selected'"; } ?>>Add New</li></a>
    </ul>
</div>

<div class="col-md-8" id="main-content">
    
<?php
    
  //Nead header to be vacncy details and ability to edit and save changes.
// Need 3 sub lists to view candides prospected, candidtes sent, and interviews arranged
    
if(!isset($_GET["id"])){
    header("Location: vacancies.php");
}
    
$vacId = $_GET["id"];
    
$stmt = $db->prepare("SELECT * FROM vacancies WHERE vacancy_id = :vacid LIMIT 1");
$stmt->bindParam(":vacid", $vacId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);    

$DbVacId = $result["vacancy_id"];   
$vacName = $result["vacancy_name"];
$salary = $result["vacancy_salary"];
$status = $result["vacancy_status"];
$result["vacancy_status"];
$vacDate = $result["vacancy_date"];
$managerId = $result["manager_id"];
    
//If no vacacny name(So if you manually enter incorrect GET) - redirect
if($vacName== "" || $vacName == null){
    header("Location: vacancies.php");
}
    
$stmt = $db->query("SELECT * FROM managers WHERE manager_id = '{$managerId}' LIMIT 1");
$managerResult = $stmt->fetch(PDO::FETCH_ASSOC);
$managerName = $managerResult["manager_firstname"] . " " . $managerResult["manager_surname"];
    
?>
    
<div class="row" id="vacancyContent">
    
    <div class="col-md-6" id="vacancyDataDisplayDiv">
        <ul class="dataSummary">
            <li><span>ID: </span><?php echo $vacId; ?></li>
            <li><span>Role: </span><?php echo $vacName; ?></li>
            <li><span>Salary: </span><?php echo $salary; ?></li>
            <li><span>Status: </span><?php if($status == 1){echo "Live";}else{echo "Closed";} ?></li>
            <li><span>Date Added: </span><?php echo $vacDate; ?></li>
            <li><span>Hiring Manager: </span><?php echo $managerName; ?></li>
        </ul>
        <!-- Modal Button-->
        <button type="button" class="btn" data-toggle="modal" data-target="#editVacancyModal">Edit</button>
        <form action="" method="post" id="statusFormButton">
            <button type="submit" name="changeStatus" class="btn"><?php if($status == 1){ echo "Close Vacacny"; } else { echo "Set to Live";} ?></button>
        </form>
        <?php
        $echo = '<form action="" method="post" id="deleteCandidateForm"><button type="submit" name="delete" class="btn deleteBtn">Delete</button></form>';
        userAccess(697, $echo);
        ?>

        
        <?php
        // Code to update vacancy staus
        if(isset($_POST["changeStatus"])){
            if($status == 1){
                $db->query("UPDATE vacancies SET vacancy_status = 0 WHERE vacancy_id = '{$DbVacId}'");
            } else {
                $db->query("UPDATE vacancies SET vacancy_status = 1 WHERE vacancy_id = '{$DbVacId}'");
            }
            header("Location: vacancy.php?id=$vacId");
        }
        
        //To delete vacancy if user access at 697
        if(isset($_POST["delete"])){
            if(isset($_SESSION["access"])){
            if($_SESSION["access"] == 697){
                $db->query("DELETE FROM vacancies WHERE vacancy_id = '{$DbVacId}'");
                header("Location: vacancies.php");
                }
            } else {
               header("Location: includes/logout.php");
            }
        }
        ?>
    
        
    <!--  Propects list -->
<?php
    
$stmt = $db->prepare("SELECT * FROM prospects WHERE prospect_vacancy_id = :vacid AND prospect_status = 1 ORDER BY prospect_id DESC");
$stmt->bindParam(":vacid", $vacId);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
$hide = "";
$count = count($result);
if($count == 0){
    $hide = "hide";
}
?>   

<div id="prosprectListDiv">
 <table id="prosprectList" class="table table-striped <?php echo $hide; ?>">
  <thead>
    <tr>
      <th>Name</th>
      <th>Prospect Date</th>
      <th>Send CV</th>
      <th>Remove</th>
    </tr>
  </thead>
  <tbody>
      
<?php
    
foreach($result as $row){
    $prospectId = $row["prospect_id"];
    $prospectCanId = $row["prospect_candidate_id"];
    $prospectStatus = $row["prospect_status"];
    $prosDate = $row["prospect_date"];
    
    $canStmt = $db->query("SELECT * FROM candidates WHERE candidate_id = '{$prospectCanId}' LIMIT 1");
    $canResults = $canStmt->fetch(PDO::FETCH_ASSOC);
    
    $canId = $canResults["candidate_id"];
    $name = $canResults["candidate_firstname"] . " " . $canResults["candidate_surname"];
    

    
echo "<tr>";
echo "<td><a href='candidate.php?id={$canId}'>$name</a></td>";
echo "<td>$prosDate</td>";
echo "<td><a href='vacancy.php?id={$vacId}&send={$prospectId}&comment=$prospectCanId'>Send</a></td>";
echo "<td><a href='vacancy.php?id={$vacId}&remove={$prospectId}&comment=$prospectCanId'>Remove</a></td>";
echo "<tr>";
    
}
    
    
?>
    
        </tbody>
    </table>
 </div>
</div>
    
    
<?php
//Functions for changing or removeing prospects
if(isset($_GET["send"])){
    $prospectGetId = $_GET["send"];
    $date = date("jS M Y");
    $stmt = $db->prepare("UPDATE prospects SET prospect_status = 2, prospect_date = '{$date}' WHERE prospect_id = :prospectId");
    $stmt->bindParam(":prospectId", $prospectGetId);
    $stmt->execute();
    
    if(isset($_GET["comment"])){
    $candidateId = $_GET["comment"];
    $stmt = $db->query("SELECT * FROM candidates WHERE candidate_id = '{$candidateId}'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $fname = $result["candidate_firstname"];
    $comment = $fname . " CV sent for " . $vacName . ".";
    candidateComment($candidateId, $comment);
    }

    header("Location: vacancy.php?id=$vacId");
}
    
if(isset($_GET["remove"])){
    $prospectGetId = $_GET["remove"];
    $stmt = $db->prepare("UPDATE prospects SET prospect_status = 0 WHERE prospect_id = :prospectId");
    $stmt->bindParam(":prospectId", $prospectGetId);
    $stmt->execute();
    
    if(isset($_GET["comment"])){
    $candidateId = $_GET["comment"];
    $stmt = $db->query("SELECT * FROM candidates WHERE candidate_id = '{$candidateId}'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $fname = $result["candidate_firstname"];
    $comment = $fname . " removed as prospect from " . $vacName . ".";
    candidateComment($candidateId, $comment);
    }

    header("Location: vacancy.php?id=$vacId");
}    
?>

    
    

<div class="col-md-6" id="vacancyProspectOptionsDiv">
    <table id="" class="table table-striped">
  <thead>
    <tr>
      <th>Name</th>
      <th>Sent Date</th>
      <th>Reject</th>
      <th>Interview</th>
    </tr>
  </thead>
  <tbody>
      
<?php
    
$stmt = $db->prepare("SELECT * FROM prospects WHERE prospect_vacancy_id = :vacid AND prospect_status > 1 ORDER BY prospect_id DESC");
$stmt->bindParam(":vacid", $vacId);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row){
    $prospectId = $row["prospect_id"];
    $prospectCanId = $row["prospect_candidate_id"];
    $prospectStatus = $row["prospect_status"];
    $prosDate = $row["prospect_date"];
    
    $canStmt = $db->query("SELECT * FROM candidates WHERE candidate_id = '{$prospectCanId}' LIMIT 1");
    $canResults = $canStmt->fetch(PDO::FETCH_ASSOC);
    
    $canId = $canResults["candidate_id"];
    $name = $canResults["candidate_firstname"] . " " . $canResults["candidate_surname"];
    
    $class = "";
    if($prospectStatus == 2){
        $class="pending";
    } elseif($prospectStatus == 3){
        $class="interview";
    } elseif($prospectStatus == 4){
        $class="reject";
    }
    
echo "<tr class='{$class} cvSent'>";
echo "<td><a href='candidate.php?id={$canId}'>$name</a></td>";
echo "<td>$prosDate</td>";
echo "<td><a href='vacancy.php?id={$vacId}&reject={$prospectId}&comment=$prospectCanId'>Reject</a></td>";
echo "<td><a href='vacancy.php?id={$vacId}&interview={$prospectId}&comment=$prospectCanId'>Interview</a></td>";
echo "<tr>";
    
}
    
    
?>
    
        </tbody>
    </table>
</div>
    
<?php
// Fucntions for changing sent status 3 accept - 4 reject
if(isset($_GET["reject"])){
    $prospectGetId = $_GET["reject"];
    $stmt = $db->prepare("UPDATE prospects SET prospect_status = 4 WHERE prospect_id = :prospectId");
    $stmt->bindParam(":prospectId", $prospectGetId);
    $stmt->execute();
    
    if(isset($_GET["comment"])){
    $candidateId = $_GET["comment"];
    $stmt = $db->query("SELECT * FROM candidates WHERE candidate_id = '{$candidateId}'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $fname = $result["candidate_firstname"];
    $comment = $fname . " rejected for " . $vacName . ".";
    candidateComment($candidateId, $comment);
    }
    header("Location: vacancy.php?id=$vacId");
}
    
if(isset($_GET["interview"])){
    $prospectGetId = $_GET["interview"];
    $stmt = $db->prepare("UPDATE prospects SET prospect_status = 3 WHERE prospect_id = :prospectId");
    $stmt->bindParam(":prospectId", $prospectGetId);
    $stmt->execute();
    
    if(isset($_GET["comment"])){
    $candidateId = $_GET["comment"];
    $stmt = $db->query("SELECT * FROM candidates WHERE candidate_id = '{$candidateId}'");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $fname = $result["candidate_firstname"];
    $comment = $fname . " interviewed for " . $vacName . ".";
    candidateComment($candidateId, $comment);
    }

    header("Location: vacancy.php?id=$vacId");
}    
?>    

    
</div> <!--  End of first row -->

    
    

    
<!-- Modal for edditing vacacny -->
<div class="modal fade" id="editVacancyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="container">
            <form method="post" action="" id="vacancyForm" class="">

              <div class="form-group row">
                <label for="vacancyName">Vacancy</label>
                <input type="text" class="form-control" id="vacancyName" name="vacancyName" value="<?php echo $vacName; ?>">
                  <div class="form-control-feedback" id="vacancyNameFeedback"></div>
              </div>

              <div class="form-group row">
                <label for="vacancyManager">Manager</label>
                <select class="form-control" id="vacancyManager" name="vacancyManager">
                <?php
                $managerStmt = $db->query("SELECT * FROM managers");
                $managerResult = $managerStmt->fetchAll(PDO::FETCH_ASSOC); 

                    foreach($managerResult as $row){
                        $manager_name = $row["manager_firstname"] . " " . $row["manager_surname"];
                        $manager_id = $row["manager_id"];
                        
                        if($manager_id == $managerId){
                          echo "<option value='{$manager_id}' selected>{$manager_name}</option>";  
                        } else {
                          echo "<option value='{$manager_id}'>{$manager_name}</option>";
                        }
                    }
                    ?>
                </select>
                </div>

                  <div class="form-group row">
                    <label for="vacancySalary">Salary</label>
                    <input type="text" class="form-control" id="vacancySalary" name="vacancySalary" value="<?php echo $salary; ?>">
                      <div class="form-control-feedback" id="vacancySalaryFeedback"></div>
                  </div>
            
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn myBtnSuccess" name="editVacancy">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
    </div>
  </div>
</div>
    
<?php
//To Update the vacancy
if(isset($_POST["editVacancy"])){
    
    $vName = $_POST["vacancyName"];
    $manName= $_POST["vacancyManager"];
    $salary = $_POST["vacancySalary"];
     
    $stmt = $db->prepare("UPDATE vacancies SET vacancy_name = :vname, manager_id = :man, vacancy_salary = :salary WHERE vacancy_id = '{$DbVacId}'");
    $stmt->bindParam(":vname", $vName);
    $stmt->bindParam(":man", $manName);
    $stmt->bindParam(":salary", $salary);
    $stmt->execute();

    header("Location: vacancy.php?id=$vacId");
}
?>
    
    
    
    
</div>
<!--End of main content div-->

</div>
<!--End of page row-->
<?php
require("includes/footer.php");
?>