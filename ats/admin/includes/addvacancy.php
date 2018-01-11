
<form method="post" action="" id="vacancyForm" class="newForm">
    
  <div class="form-group row">
    <label for="vacancyName">Title</label>
    <input type="text" class="form-control" id="vacancyName" name="vacancyName">
      <div class="form-control-feedback" id="vacancyNameFeedback"></div>
  </div>

  <div class="form-group row">
    <label for="vacancyManager">Manager</label>
    <select class="form-control" id="vacancyManager" name="vacancyManager">
    
    <?php
    $managerStmt = $db->query("SELECT * FROM managers");
    $managerResult = $managerStmt->fetchAll(PDO::FETCH_ASSOC); 
        
        foreach($managerResult as $row){
            $manager_name = $row["manager_firstname"] . " " . $row["manager_surname"];
            $manager_id = $row["manager_id"];
            echo "<option value='{$manager_id}'>{$manager_name}</option>";
        }
        ?>
 
    </select>
    </div>
    
    
  <div class="form-group row">
    <label for="vacancySalary">Salary</label>
    <input type="text" class="form-control" id="vacancySalary" name="vacancySalary">
      <div class="form-control-feedback" id="vacancySalaryFeedback"></div>
  </div>
    
  <button type="submit" class="btn" name="addVacancy">Add</button>
</form>


<?php

if(isset($_POST["addVacancy"])){
    
    $vacancy_name = $_POST["vacancyName"];
    $vacancy_manager = $_POST["vacancyManager"];
    $vacancy_salary = $_POST["vacancySalary"];
    $vacancy_date = date("jS M Y");
    
    
    $stmt = $db->prepare("INSERT INTO vacancies(manager_id, vacancy_name, vacancy_salary, vacancy_status, vacancy_date) VALUES('{$vacancy_manager}', :vname, :vsal, 1, '{$vacancy_date}')");
    $stmt->bindParam(":vname", $vacancy_name);
    $stmt->bindParam(":vsal", $vacancy_salary);
    $stmt->execute();

    header("Location: vacancies.php");
}
?>









