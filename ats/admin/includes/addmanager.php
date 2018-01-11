
<form method="post" action="" id="managerForm" class="newForm">
    
  <div class="form-group row">
    <label for="firstName">First Name</label>
    <input type="text" class="form-control" id="managerFirstName" name="managerFirstName" maxlength="15">
      <div class="form-control-feedback" id="managerFirstNameFeedback"></div>
  </div>
    
    <div class="form-group row">
    <label for="surname">Surname</label>
    <input type="text" class="form-control" id="surname" name="surname" maxlength="15">
      <div class="form-control-feedback" id="surnameFeedback"></div>
  </div>
    
    <div class="form-group row">
    <label for="title">Title</label>
    <input type="text" class="form-control" id="title" name="title" maxlength="30">
      <div class="form-control-feedback" id="titleFeedback"></div>
  </div>
    
    <div class="form-group row">
    <label for="phone">Phone</label>
    <input type="text" class="form-control" id="phone" name="phone" maxlength="15">
      <div class="form-control-feedback" id="phoneFeedback"></div>
  </div>
    
    <div class="form-group row">
    <label for="phone">Email</label>
    <input type="email" class="form-control" id="email" name="email" maxlength="50">
      <div class="form-control-feedback" id="emailFeedback"></div>
  </div>

    
  <button type="submit" class="btn" name="addManager">Add</button>
    
</form>



<?php

if(isset($_POST["addManager"])){
    
    $fname = $_POST["managerFirstName"];
    $sname= $_POST["surname"];
    $title = $_POST["title"];
    $email= $_POST["email"];
    $phone= $_POST["phone"];
    
    
    
    $stmt = $db->prepare("INSERT INTO managers(manager_firstname, manager_surname, manager_title, manager_email, manager_phone) VALUES(:fname, :sname, :title, :email, :phone)");
    $stmt->bindParam(":fname", $fname);
    $stmt->bindParam(":sname", $sname);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":phone", $phone);
    $stmt->execute();

    header("Location: managers.php");
}
?>
