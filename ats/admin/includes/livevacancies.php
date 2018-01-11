<table id="liveVacanciesTable" class="table table-striped vacancyResultsTable">
  <thead>
    <tr>
      <th>#</th>
      <th>Vacancy</th>
      <th>Manager</th>
	  <th>CVs Sent</th>
      <th>Date Added</th>

    </tr>
  </thead>
  <tbody>

<?php

$vacacnyStmt = $db->query("SELECT * FROM vacancies WHERE vacancy_status = 1 ORDER BY vacancy_id DESC");
$vacancyResult = $vacacnyStmt->fetchAll(PDO::FETCH_ASSOC);

foreach($vacancyResult as $row){
    $vacancy_id = $row["vacancy_id"];
    $vacancy_name = $row["vacancy_name"];
    $manager_id = $row["manager_id"];
    $vacancy_date = $row["vacancy_date"];
    
    $managerStmt = $db->query("SELECT manager_firstname, manager_surname FROM managers WHERE manager_id = '{$manager_id}'");
    $managerResult = $managerStmt->fetch(PDO::FETCH_ASSOC); 
    
    $manager_name = $managerResult["manager_firstname"] . " " . $managerResult["manager_surname"];
     
      
echo "<tr>";
echo "<th scope='row'>$vacancy_id</th>";
echo "<td><a href='vacancy.php?id={$vacancy_id}'>$vacancy_name</a></td>";
echo "<td><a href='manager.php?id={$manager_id}'>$manager_name</a></td>";
$count = countCVSsent($vacancy_id);
echo "<td>$count</td>";
echo "<td>$vacancy_date</td>";
echo "<tr>";
    
}
      
?>
      
    </tbody>
</table>