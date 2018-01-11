<?php
include("db.php");


$jsonarr = array();   

if(isset($_GET["search"])){
    
      
            $search = str_replace(' ', '', $_GET["search"]);
            $searchq = "%" . $search . "%";

              
            $query = $db->query("SELECT app.*, vac.* FROM app INNER JOIN vac ON app.app_vac_id = vac.vac_id WHERE (app_fname LIKE '{$searchq}' OR app_sname LIKE '{$searchq}') ORDER BY app.app_id DESC");
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
    
    
    
    
//    $stmt = $db->prepare("INSERT INTO app(app_fname, app_sname, app_tel, app_email, app_date, app_vac_id) VALUES(:fname, :sname, :tel, :email, '{$date}', :vid)");
//    
//    $stmt->bindParam(":fname", $fname);
//    $stmt->bindParam(":sname", $lname);
//    $stmt->bindParam(":tel", $tel);
//    $stmt->bindParam(":email", $email);
//    $stmt->bindParam(":vid", $vacId);
//    
//$stmt->execute();
    
        
        
        
    
    
}
//End of first if
    

// Load results to array
foreach($results as $row){
      array_push($jsonarr, $row);
}

//return as json
echo json_encode($jsonarr);

?>