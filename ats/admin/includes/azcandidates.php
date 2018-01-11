

<table id="azCandidatesTable" class="table table-striped candidateResultsTable">
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
      

$stmt = $db->query("SELECT * FROM candidates ORDER BY candidate_surname ASC");   
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