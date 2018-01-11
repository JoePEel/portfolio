
<form method="post" action="" id="candidateForm" class="newForm">
    
  <div class="form-group row">
    <label for="firstName">First Name</label>
    <input type="text" class="form-control" id="firstName" name="firstName" maxlength="15">
      <div class="form-control-feedback" id="firstNameFeedback"></div>
  </div>
    
    <div class="form-group row">
    <label for="surname">Surname</label>
    <input type="text" class="form-control" id="surname" name="surname" maxlength="15">
      <div class="form-control-feedback" id="surnameFeedback"></div>
  </div>
    
    <div class="form-group row">
    <label for="phone">Phone</label>
    <input type="phone" class="form-control" id="phone" name="phone" maxlength="15">
      <div class="form-control-feedback" id="phoneFeedback"></div>
  </div>
    
    <div class="form-group row">
    <label for="phone">Email</label>
    <input type="email" class="form-control" id="email" name="email" maxlength="50">
      <div class="form-control-feedback" id="emailFeedback"></div>
  </div>
    
    <div class="form-group" id="cvFileDiv">
    <label for="cvFile">Upload CV</label>
    <input type="file" class="form-control-file" id="cvFile" aria-describedby="fileHelp">
  </div>

  <div class="form-group row">
    <label for="vacancyManager">Source</label>
    <select class="form-control" id="source" name="source">
        <option value="Website">Website</option>
        <option value="LinkedIn">LinkedIn</option>
        <option value="Refferal">Refferal</option>
        <option value="Reed">Reed</option>
        <option value="Agency">Agency</option>
    </select>
    </div>

    
  <button type="submit" class="btn" name="addCandidate">Add</button>
    
</form>


<?php

if(isset($_POST["addCandidate"])){
    
    $fname = $_POST["firstName"];
    $sname= $_POST["surname"];
    $phone= $_POST["phone"];
    $email= $_POST["email"];
    $source = $_POST["source"];
    $date = date("jS M Y");
    
    
    $stmt = $db->prepare("INSERT INTO candidates(candidate_firstname, candidate_surname, candidate_email, candidate_phone, candidate_source, candidate_date) VALUES(:fname, :sname, :email, :phone, '{$source}', '{$date}')");
    $stmt->bindParam(":fname", $fname);
    $stmt->bindParam(":sname", $sname);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":phone", $phone);
    $stmt->execute();

    header("Location: candidates.php");
}
?>
