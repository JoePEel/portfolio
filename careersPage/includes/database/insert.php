<?php
include("db.php");

if(isset($_POST)){
    
    $method = $_POST["method"];
    
    if($method == "updateClient"){
        $id = $_POST["id"];
        $field = $_POST["field"];
        $input = $_POST["input"];
        $stmt = $db->query("UPDATE clients SET " . $field . " = '{$input}' WHERE client_id = '{$id}'");
        
        echo $id . $field . $input;
    }
    

    
}


?>