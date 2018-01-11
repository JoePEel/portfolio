<?php
include("db.php");

if(isset($_POST)){
    
    $title = $_POST["blogTitle"];
    $content = $_POST["blogContentAdd"];
    $date = date("jS M Y");

$stmt = $db->prepare("INSERT INTO blog(blog_title, blog_date, blog_content) VALUES(:title, '{$date}', :content)");
    
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":content", $content);

$stmt->execute();
    
    echo "Blog posted submitted";
  
}


?>