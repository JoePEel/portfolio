<?php
include("db.php");

if(isset($_POST)){
    
    $title = $_POST["vacTitle"];
    $content = $_POST["vacContent"];
    $date = date("jS M Y");

$stmt = $db->prepare("INSERT INTO vac(vac_name, vac_date, vac_desc) VALUES(:title, '{$date}', :content)");
    
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":content", $content);

$stmt->execute();
    
    echo "Vacancy submitted";
  
}


?>