
<form method="post" action="" id="userForm" class="newForm">
    
  <div class="form-group row">
    <label for="username">Username</label>
    <input type="text" class="form-control" id="username" name="username" maxlength="15">
      <div class="form-control-feedback" id="usernameNameFeedback"></div>
  </div>
    
    <div class="form-group row">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password" maxlength="15">
      <div class="form-control-feedback" id="passwordFeedback"></div>
  </div>

  <button type="submit" class="btn" name="addUser">Add</button>
    
</form>


<?php

if(isset($_POST["addUser"])){
    $uname = $_POST["username"];
    $pword = $_POST["password"];
    $finPword = password_hash($pword, PASSWORD_BCRYPT);
    
//    echo $uname;
//    echo $pword;
//    echo $finPword;
    $stmt = $db->prepare("INSERT INTO users(username, password, access_level) VALUES(:uname, '{$finPword}', 1)");
    $stmt->bindParam(":uname", $uname);
    $stmt->execute();

    header("Location: users.php");
}
?>