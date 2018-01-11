<form class="form-inline my-2 my-lg-0" id="candidateSearch" method="post" action="">
      <input class="form-control mr-sm-2" type="text" name="searchText" placeholder="Search by surname">
      <button class="btn my-2 my-sm-0" type="submit" name="search">Search</button>
</form>

<table id="recentCandidatesTable" class="table table-striped candidateResultsTable">
  <thead>
    <tr>
      <th>#</th>
      <th>Surname</th>
      <th>First Name</th>
      <th>Date Added</th>
    </tr>
  </thead>
  <tbody>

<?php
      
// Check if search has been made
if(isset($_POST["search"])){
    $input = $_POST["searchText"];
    $input = trim($input);
    header("Location: candidates.php?search=$input");
}
      
      
if(isset($_GET["search"])){
    
    $input = $_GET["search"];
    
    if($input == ""){
        
        $stmt = $db->query("SELECT * FROM candidates ORDER BY candidate_id DESC LIMIT 20");
        
    } else {
        
        $stmt = $db->prepare("SELECT * FROM candidates WHERE candidate_surname LIKE :input ORDER BY candidate_id DESC LIMIT 20");
        $searchInput = "%" . $input . "%";
        $stmt->bindParam(":input", $searchInput);
        $stmt->execute();
        
    }
    
} else {
    
    $stmt = $db->query("SELECT * FROM candidates ORDER BY candidate_id DESC LIMIT 20");
}
      
// retrun and run stmt
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($result as $row){
    $candidate_id = $row["candidate_id"];
    $fname = $row["candidate_firstname"];
    $sname = $row["candidate_surname"];
    $date_added = $row["candidate_date"];
     
      
echo "<tr>";
echo "<th scope='row'>$candidate_id</th>";
echo "<td><a href='candidate.php?id={$candidate_id}'>$fname</a></td>";
echo "<td>$sname</td>";
echo "<td>$date_added</td>";
echo "<tr>";
    
}
      
?>
    </tbody>
</table>