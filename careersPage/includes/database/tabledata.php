<?php
include("db.php");


$jsonarr = array();   

if(isset($_GET["getAction"])){
    
    $getAction = $_GET["getAction"];
    
    // For loading vacancies 
    if($getAction == "getVacs"){
        $query = $db->query("SELECT * FROM vac ORDER BY vac_id DESC");
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    else if ($getAction == "getSingleVac"){
        $id = $_GET["id"];
        $query = $db->query("SELECT * FROM vac WHERE vac_id = " . $id . " LIMIT 1");
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    else if ($getAction == "getApps"){
        $lastId = $_GET["lastId"];
        $selection = $_GET["selection"];
        
//            $query = $db->query("SELECT * FROM app ORDER BY app_id LIMIT 5 OFFSET " . $lastId);
            $query = $db->query("SELECT app.*, vac.* FROM app INNER JOIN vac ON app.app_vac_id = vac.vac_id ORDER BY app.app_id DESC LIMIT ${selection} OFFSET " . $lastId);
            $results = $query->fetchAll(PDO::FETCH_ASSOC); 
    
    }
    else if($getAction == "getVacApps"){
        $vacId = $_GET["target"];
        $query = $db->query("SELECT app.*, vac.* FROM app INNER JOIN vac ON app.app_vac_id = vac.vac_id WHERE app.app_vac_id = '{$vacId}' ORDER BY app.app_id DESC");
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    else if($getAction == "getAllBlogPosts"){
        $query = $db->query("SELECT * FROM blog ORDER BY blog_id DESC");
        $results = $query->fetchAll(PDO::FETCH_ASSOC); 
        
    }
    else if($getAction == "getSingleBlogPost"){
        $id = $_GET["id"];
        $query = $db->query("SELECT * FROM blog WHERE blog_id = '{$id}'");
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    else if($getAction == "getSingleVac"){
        $id = $_GET["id"];
        $query = $db->query("SELECT * FROM vac WHERE vac_id = '{$id}'");
        $results = $query->fetchAll(PDO::FETCH_ASSOC);    
    }
    else if ($getAction == "getBlogPostsPage"){
        $lastId = $_GET["lastId"];
        $limit = $_GET["limit"];
        $query = $db->query("SELECT * FROM blog ORDER BY blog_id DESC LIMIT ${limit} OFFSET " . $lastId);
        $results = $query->fetchAll(PDO::FETCH_ASSOC); 
    }
    
}
//End of first if
    

// Load results to array
foreach($results as $row){
      array_push($jsonarr, $row);
}

//return as json
echo json_encode($jsonarr);

?>