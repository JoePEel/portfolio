<?php
include("db.php");

if(isset($_POST)){
    
    $fname = $_POST["firstNameApplication"];
    $lname = $_POST["lastNameApplication"];
    $email = $_POST["emailApplication"];
    $tel = $_POST["telNameApplication"];
    $vacId = $_POST["vacId"];
    $date = date("jS M Y");

$stmt = $db->prepare("INSERT INTO app(app_fname, app_sname, app_tel, app_email, app_date, app_vac_id) VALUES(:fname, :sname, :tel, :email, '{$date}', :vid)");
    
    $stmt->bindParam(":fname", $fname);
    $stmt->bindParam(":sname", $lname);
    $stmt->bindParam(":tel", $tel);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":vid", $vacId);
    
$stmt->execute();
    
    echo "CV Successfully submitted";
  
}


?>