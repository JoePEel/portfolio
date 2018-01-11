<table id="managersTable" class="table table-striped managerResultsTable">
  <thead>
    <tr>
      <th>#</th>
      <th>Firstname</th>
      <th>Surname</th>
	  <th>Title</th>
    </tr>
  </thead>
  <tbody>

<?php

$stmt = $db->query("SELECT * FROM managers ORDER BY manager_id DESC");
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($result as $row){
    $id = $row["manager_id"];
    $fname = $row["manager_firstname"];
    $sname = $row["manager_surname"];
    $title = $row["manager_title"];
    
     
      
echo "<tr>";
echo "<th scope='row'>$id</th>";
echo "<td><a href='manager.php?id={$id}'>$fname</a></td>";
echo "<td>$sname</td>";
echo "<td>$title</td>";   
echo "<tr>";
    
}
      
?>
      
    </tbody>
</table>