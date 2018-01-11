    <?php
require("db.php");


// Echo something shouuld user access meet expectation
function userAccess($level, $echo){
        if(isset($_SESSION["access"])){
            if($_SESSION["access"] == $level){
                echo $echo; 
        }
    }
}

//Same Above yet with else statement
function userAccessNot($level, $else){
        if(isset($_SESSION["access"])){
            if($_SESSION["access"] !== $level){
                $else;
        }
    } 
}

function candidateComment($canId, $comment){
    global $db;
    $date = date("jS M Y");
    $db->query("INSERT INTO candidate_comments(candidate_id, candidate_comment_date, candidate_comment_text) VALUES('{$canId}', '{$date}', '{$comment}')");
}

//count number rows where CV has been sent for a role
function countCVSsent($vacancyId){
    global $db;
    $stmt = $db->query("SELECT * FROM prospects WHERE prospect_vacancy_id = '{$vacancyId}' AND prospect_status > 1");
    $result = $stmt->fetchAll();
    $count = count($result);
    return $count;
}


//Count num of rows for candidate source
function countCVSource($source){
    global $db;
    $stmt = $db->query("SELECT * FROM candidates WHERE candidate_source = '{$source}'");
    $result = $stmt->fetchAll();
    $count = count($result);
    return $count;
}

// Count number of whatever add in the current month
function dateAddedCount($sql, $targetColumn){
    global $db;
    $currentMonth = date("M");
    $currentYear = date("Y");
    $count = "";
    $stmt = $db->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row){
        $date = $row[$targetColumn];
        if(strpos($date, $currentMonth) !== false && strpos($date, $currentYear) !== false){
            $count++;
        }
    }
     if($count == 0 || null || ""){
         $count = 0;
     }
    return $count;
}


function refferalSelected($value, $source){
    global $db;
    if($value == $source){
        echo "selected";
    }
    
}





?>











