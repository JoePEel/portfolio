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
        <a href="candidates.php"><li>Recently Added</li></a>
        <a href="candidates.php?subtitle=az"><li <?php if($subTitleNav == "az"){ echo "class='selected'"; } ?>>A to Z</li></a>
        <a href="candidates.php?subtitle=za"><li <?php if($subTitleNav == "za"){ echo "class='selected'"; } ?>>Z to A</li></a>
        <a href="candidates.php?subtitle=addnew"><li <?php if($subTitleNav == "addnew"){ echo "class='selected'"; } ?>>Add New</li></a>
    </ul>
</div>

<div class="col-md-8" id="vacancy-main-content">
    
<?php
    
// Show candidate details
//Allow edit ... or maybe link to edit page
//Prospect to job
//Send CVs
//Make comments
//Show comment log
    
if(!isset($_GET["id"])){
    header("Location: candidates.php");
}
    
$canId = $_GET["id"];
    
$stmt = $db->prepare("SELECT * FROM candidates WHERE candidate_id = :canid LIMIT 1");
$stmt->bindParam(":canid", $canId);
$stmt->execute();
$candidate = $stmt->fetch(PDO::FETCH_ASSOC);
    
$id = $candidate["candidate_id"];
$fname = $candidate["candidate_firstname"];
$lname = $candidate["candidate_surname"];
$email = $candidate["candidate_email"];
$phone = $candidate["candidate_phone"];
$source = $candidate["candidate_source"];
$canDate = $candidate["candidate_date"];

//If no firstname (So if you manually enter incoorect GET) - redirect
if($fname == "" || $fname == null){
    header("Location: candidates.php");
}
    

?>
    
<div class="row" id="candidateContent">
    
    <div class="col-sm-6" id="candidateDataDisplayDiv">
        <ul class="dataSummary">
            <li><span>ID: </span><?php echo $id; ?></li>
            <li><span>Firstname: </span><?php echo $fname; ?></li>
            <li><span>Surname: </span><?php echo $lname; ?></li>
            <li><span>Email: </span><?php echo $email; ?></li>
            <li><span>Phone: </span><?php echo $phone; ?></li>
            <li><span>Source: </span><?php echo $source; ?></li>
            <li><span>Date added: </span><?php echo $canDate; ?></li>
            <li><span>CV: </span></li>
        </ul>
        <!-- Modal Button-->
        <button type="button" class="btn" data-toggle="modal" data-target="#editCandidateModal">Edit</button>
        <?php
        $echo = '<form action="" method="post" id="deleteCandidateForm"><button type="submit" name="delete" class="btn deleteBtn">Delete</button></form>';
        userAccess(697, $echo);
        ?>
    </div>
    
    <?php
    
    //To delete candidate if user access at 697
        if(isset($_POST["delete"])){
            if(isset($_SESSION["access"])){
            if($_SESSION["access"] == 697){
                $db->query("DELETE FROM candidates WHERE candidate_id = '{$id}'");
                $db->query("DELETE FROM prospects WHERE prospect_candidate_id = '{$id}'");
                header("Location: candidates.php");
                }
            } else {
               header("Location: includes/logout.php");
            }
        }
        ?>

    
    
    <div class="col-sm-6" id="candidateProspectOptionsDiv">

    <form method="post" action="" id="prospectForm" class="">

      <div class="form-group row">
        <label for="prospectOption">Prospect</label>
        <select class="form-control" id="prospectOption" name="prospectOption">
            <option value="1">Prospect</option>
            <option value="2">Sending CV</option>
        </select>
        </div>

      <div class="form-group row">
        <label for="vacancyOption">Vacancy</label>
        <select class="form-control" id="vacancyOption" name="vacancyOption">
        <?php
        $stmt = $db->query("SELECT * FROM vacancies WHERE vacancy_status = 1");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            foreach($result as $row){
                $vacancy_name = $row["vacancy_name"];
                $vacancy_id = $row["vacancy_id"];
                echo "<option value='{$vacancy_id}'>{$vacancy_name}</option>";
            }
            ?>
        </select>
        </div>

        <button type="submit" class="btn candidateButton" name="action">Action</button>

    </form>
    </div>
    
    
</div> <!--End of first row-->
    

<div class="row" id="canSecondRow">  
    
<div class="col-sm-6" id="viewCommentDiv">
    <h5>All Comments</h5>
    <?php
    
    $stmt = $db->query("SELECT * FROM candidate_comments WHERE candidate_id = '{$id}' ORDER BY candidate_comment_id DESC");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row){
        $commentDate = $row["candidate_comment_date"];
        $commentText = $row["candidate_comment_text"];
        
        echo "<div class='comment'><p><span>$commentDate</span> $commentText</p></div><hr>";
    }
    
    ?>
    
 
</div>  
    
<div class="col-sm-6" id="addCommentDiv">
    <h5>Add Comment</h5>
    <form method="post" action="" id="candidateCommentForm" class="">

          <div class="form-group row" id="newCommentDiv">
            <textarea name="newComment" id="newComment" cols="30"></textarea>
              <div class="form-control-feedback" id="newCommentFeedback"></div>
          </div>

          <button type="submit" class="btn candidateButton" name="addComment">Add</button>
        
    </form>
</div>  
</div>    
    

<?php
    
    //Insert in prospects
    
    if(isset($_POST["action"])){
        
        $prospectOption = $_POST["prospectOption"];
        $vacancyOption = $_POST["vacancyOption"];
        $date = date("jS M Y");
       
        $db->query("INSERT INTO prospects(prospect_candidate_id, prospect_vacancy_id, prospect_status, prospect_date) VALUES('{$id}', '{$vacancyOption}', '{$prospectOption}', '{$date}')");
        
        //Insert into candidate comments
        $stmt = $db->query("SELECT * FROM vacancies WHERE vacancy_id = '{$vacancyOption}'");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $vacancyName = $result["vacancy_name"];
        
        if($prospectOption == 1){
            $commentProspect = "prospected";
        } else {
            $commentProspect = "CV sent";
        }
        
        //construct comment
        $comment = $fname . " " . $commentProspect . " for " . $vacancyName . ".";
        
        $db->query("INSERT INTO candidate_comments(candidate_id, candidate_comment_date, candidate_comment_text) VALUES('{$id}', '{$date}', '{$comment}')");
        
        header("Location: candidate.php?id=$id");
        
    }
    
    
    //Add comment
    
        if(isset($_POST["addComment"])){
            $commentInputText = $_POST["newComment"];
            $date = date("jS M Y");
            $stmt = $db->prepare("INSERT INTO candidate_comments(candidate_id, candidate_comment_date, candidate_comment_text) VALUES('{$id}', '{$date}', :comment)");
            $stmt->bindParam(":comment", $commentInputText);
            $stmt->execute();
            
            header("Location: candidate.php?id=$id");
        }
    ?>
    
    
<!-- Modal for edditing candidate -->
<div class="modal fade" id="editCandidateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <form method="post" action="" id="candidateForm" class="">

              <div class="form-group row">
                <label for="firstName">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" maxlength="15" value="<?php echo $fname; ?>">
                  <div class="form-control-feedback" id="firstNameFeedback"></div>
              </div>

                <div class="form-group row">
                <label for="surname">Surname</label>
                <input type="text" class="form-control" id="surname" name="surname" maxlength="15" value="<?php echo $lname; ?>">
                  <div class="form-control-feedback" id="surnameFeedback"></div>
              </div>

                <div class="form-group row">
                <label for="phone">Phone</label>
                <input type="phone" class="form-control" id="phone" name="phone" maxlength="15" value="<?php echo $phone; ?>">
                  <div class="form-control-feedback" id="phoneFeedback"></div>
              </div>

                <div class="form-group row">
                <label for="phone">Email</label>
                <input type="email" class="form-control" id="email" name="email" maxlength="50" value="<?php echo $email; ?>">
                  <div class="form-control-feedback" id="emailFeedback"></div>
              </div>

              <div class="form-group row">
                <label for="vacancyManager">Source</label>
                <select class="form-control" id="source" name="source">
                    <option <?php refferalSelected("Website", $source); ?> value="Website">Website</option>
                    <option <?php refferalSelected("LinkedIn", $source); ?> value="LinkedIn">LinkedIn</option>
                    <option <?php refferalSelected("Refferal", $source); ?> value="Refferal">Refferal</option>
                    <option <?php refferalSelected("Reed", $source); ?> value="Reed">Reed</option>
                    <option <?php refferalSelected("Agency", $source); ?> value="Agency">Agency</option>
                </select>
                </div>
            
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn myBtnSuccess" name="editCandidate">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
    </div>
  </div>
</div>
    
<?php
//To Update the vacancy
if(isset($_POST["editCandidate"])){
    
    $fname = $_POST["firstName"];
    $sname= $_POST["surname"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $source = $_POST["source"];
     
    $stmt = $db->prepare("UPDATE candidates SET candidate_firstname = :fname, candidate_surname = :sname, candidate_email = :email, candidate_phone = :phone, candidate_source = '{$source}' WHERE candidate_id = '{$id}'");
    $stmt->bindParam(":fname", $fname);
    $stmt->bindParam(":sname", $sname);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":phone", $phone);
    $stmt->execute();

    header("Location: candidate.php?id=$id");
}
?>    
    
</div>
<!--End of main content div-->

</div>
<!--End of page row-->
<?php
require("includes/footer.php");
?>