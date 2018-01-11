<?php
include("db.php");

if(isset($_POST)){
    
    $title = $_POST["vacTitle"];
    $content = $_POST["vacContent"];
    $id = $_POST["vacId"];

$stmt = $db->prepare("UPDATE vac SET vac_name = :title, vac_desc = :content WHERE vac_id = :id");
    
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":content", $content);
    $stmt->bindParam(":id", $id);

$stmt->execute();
    
    echo "Vacancy updated";
  
}


?>