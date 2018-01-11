<?php
$pageTitle = "Managers"; 
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
        <a href="managers.php"><li>All</li></a>
        <a href="managers.php?subtitle=addnew"><li>Add New</li></a>
    </ul>
</div>

<div class="col-md-8" id="main-content">
    
<?php
    
  //Nead header to be vacncy details and ability to edit and save changes.
// Need 3 sub lists to view candides prospected, candidtes sent, and interviews arranged
    
if(!isset($_GET["id"])){
    header("Location: managers.php");
}
    
$manId = $_GET["id"];
    
$stmt = $db->prepare("SELECT * FROM managers WHERE manager_id = :manid LIMIT 1");
$stmt->bindParam(":manid", $manId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
    
$dbManId = $result["manager_id"];
$manFname = $result["manager_firstname"];
$manSname = $result["manager_surname"];
$manTitle = $result["manager_title"];
$manEmail = $result["manager_email"];
$manPhone = $result["manager_phone"];

//If no manager firstname(So if you manually enter incorrect GET) - redirect
if($manFname == "" || $manFname == null){
    header("Location: managers.php");
}
    
?>
    
<div class="row" id="managerContent">
    
    <div class="col-md-12" id="managerDataDisplayDiv">
        <ul class="dataSummary">
            <li><span>Firstname: </span><?php echo $manFname; ?></li>
            <li><span>Surname: </span><?php echo $manSname; ?></li>
            <li><span>Title: </span><?php echo $manTitle; ?></li>
            <li><span>Email: </span><?php echo $manEmail; ?></li>
            <li><span>Phone: </span><?php echo $manPhone; ?></li>
        </ul>
<!-- Modal Button for editing-->
        <button type="button" class="btn" data-toggle="modal" data-target="#editModal">Edit</button>
        <?php
        $echo = '<form action="" method="post" id="deleteCandidateForm"><button type="submit" name="delete" class="btn deleteBtn">Delete</button></form>';
        userAccess(697, $echo);
        ?>
    </div> 
 </div> 
    
      <?php
    //To delete manager if user access at 697
        if(isset($_POST["delete"])){
            if(isset($_SESSION["access"])){
            if($_SESSION["access"] == 697){
                $db->query("DELETE FROM managers WHERE manager_id = '{$dbManId}'");
                header("Location: managers.php");
                }
            } else {
               header("Location: includes/logout.php");
            }
        }
        ?>  
    
    
    
<?php
    
$hide = "";
$count = count($result);
if($count == 0){
    $hide = "hide";
}
 
?>
    
<div class="row" id="managerOutstandingCVs">
<div class="col-md-12" id="managerProspectOptionsDiv">
    <h5>CVs awaiting feedback:</h5>
    <table id="" class="table table-striped <?php echo $hide;?>">
  <thead>
    <tr>
      <th>Name</th>
      <th>Vacancy</th>
       <th>Sent Date</th>
      <th>Reject</th>
      <th>Interview</th>
    </tr>
  </thead>
  <tbody>
      
<?php
    
$stmt = $db->prepare("SELECT * FROM vacancies WHERE manager_id = :manid");
$stmt->bindParam(":manid", $manId);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
foreach($result as $row){
    
    $vacId = $row["vacancy_id"];
    $prosStmt = $db->query("SELECT * FROM prospects WHERE prospect_vacancy_id = '{$vacId}' AND prospect_status = 2");
    $prosResults = $prosStmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($prosResults as $prosResultss){
    
    $prospectId = $prosResultss["prospect_id"];
    $prospectCanId = $prosResultss["prospect_candidate_id"];
    $prospectStatus = $prosResultss["prospect_status"];
    $prosDate = $prosResultss["prospect_date"];
    $prosVacId = $prosResultss["prospect_vacancy_id"];
        
    $vacStmt = $db->query("SELECT * FROM vacancies WHERE vacancy_id = '{$prosVacId }' LIMIT 1");
    $vacResults = $vacStmt ->fetch(PDO::FETCH_ASSOC);
    $jobTitle = $vacResults["vacancy_name"];
    
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
    
echo "<tr class='{$class}'>";
echo "<td><a href='candidate.php?id={$canId}'>$name</a></td>";
echo "<td>$jobTitle</td>";
echo "<td>$prosDate</td>";
echo "<td><a href='manager.php?id={$manId}&reject={$prospectId}&comment=$prospectCanId'>Reject</a></td>";
echo "<td><a href='manager.php?id={$manId}&interview={$prospectId}&comment=$prospectCanId'>Interview</a></td>";
echo "<tr>";
    }
}
    
    
?>
    
        </tbody>
    </table>
</div>
</div>
    
<?php
// Fucntions for changing sent status 3 accept - 4 reject. Removes from list visible in manager
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
    header("Location: manager.php?id=$manId");
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
    global $manId;
    header("Location: manager.php?id=$manId");
}    
?>    



<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <form method="post" action="" id="managerForm" class="">

              <div class="form-group row">
                <label for="firstName">First Name</label>
                <input type="text" class="form-control" id="managerFirstName" name="managerFirstName" maxlength="15" value="<?php echo $manFname ?>">
                  <div class="form-control-feedback" id="managerFirstNameFeedback"></div>
              </div>

                <div class="form-group row">
                <label for="surname">Surname</label>
                <input type="text" class="form-control" id="surname" name="surname" maxlength="15" value="<?php echo $manSname; ?>">
                  <div class="form-control-feedback" id="surnameFeedback"></div>
              </div>

                <div class="form-group row">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" maxlength="30" value="<?php echo $manTitle; ?>">
                  <div class="form-control-feedback" id="titleFeedback"></div>
              </div>

                <div class="form-group row">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" maxlength="15" value="<?php echo $manPhone; ?>">
                  <div class="form-control-feedback" id="phoneFeedback"></div>
              </div>

                <div class="form-group row">
                <label for="phone">Email</label>
                <input type="email" class="form-control" id="email" name="email" maxlength="50" value="<?php echo $manEmail; ?>">
                  <div class="form-control-feedback" id="emailFeedback"></div>
              </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="editManager">Save Changes</button>
                  </div>

            </form>
          </div>
      </div>
    </div>
  </div>
</div>
    
<?php

if(isset($_POST["editManager"])){
    
    $fname = $_POST["managerFirstName"];
    $sname= $_POST["surname"];
    $title = $_POST["title"];
    $email= $_POST["email"];
    $phone= $_POST["phone"];
    
    
    $stmt = $db->prepare("UPDATE managers SET manager_firstname = :fname, manager_surname = :sname, manager_title = :title, manager_email = :email, manager_phone = :phone WHERE manager_id = '{$dbManId}'");
    $stmt->bindParam(":fname", $fname);
    $stmt->bindParam(":sname", $sname);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":phone", $phone);
    $stmt->execute();

    header("Location: manager.php?id=$manId");
}
?>
    
</div>
<!--End of main content div-->

</div>
<!--End of page row-->
<?php
require("includes/footer.php");
?>