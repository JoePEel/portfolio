<?php
//To Delete User
if(isset($_GET["delete"])){
    $getDelId = $_GET["delete"];
    $db->query("DELETE FROM users WHERE user_id = '{$getDelId}'");
    header("Location: users.php");
}
?>


<table id="usersTable" class="table table-striped resultsTable">
  <thead>
    <tr>
      <th>#</th>
      <th>Username</th>
      <th>Access Level</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>

<?php

$stmt = $db->query("SELECT * FROM users ORDER BY user_id DESC");
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($result as $row){
    $id = $row["user_id"];
    $uname = $row["username"];
    $access = $row["access_level"];
    
//If no manager username(So if you manually enter incorrect GET) - redirect
if($uname == "" || $uname == null){
    header("Location: users.php");
}
      
echo "<tr>";
echo "<th scope='row'>$id</th>";
echo "<td>$uname</td>";
if($access == 697){
    echo "<td>Master User</td>";
}  else {
    echo "<td>Base User</td>";
}
if($access != 697){
    echo "<td><a class='delete' href='users.php?delete={$id}'>Delete</a></td>";
}
echo "<tr>";
}  
?> 
    </tbody>
</table>

