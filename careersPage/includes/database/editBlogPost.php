<?php
include("db.php");

if(isset($_POST)){
    
    $title = $_POST["blogTitle"];
    $content = $_POST["blogContent"];
    $id = $_POST["blogId"];

$stmt = $db->prepare("UPDATE blog SET blog_title = :title, blog_content = :content WHERE blog_id = :id");
    
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":content", $content);
    $stmt->bindParam(":id", $id);

$stmt->execute();
    
    echo "Blog updated";
  
}


?>