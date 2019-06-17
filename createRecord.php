<?php
// Use an HTML form to create a new entry in the Customer table.

// When SUBMIT button pressed, open new PDO (PHP data object) connection, 
// then send INSERT SQL statement with the users inputted values

//function printTable(){
//    require "config.php";
//    require "common.php";
//
//    $connection = new PDO($dsn, $username, $password, $options);
//
//    $sql = "SELECT *
//    FROM Employee_WorksAt";
//
//    $EmployeeID = $_POST['EmployeeID'];
//
//    $statement = $connection->prepare($sql);
//    $statement->bindParam(':EmployeeID', $CustomerID, PDO::PARAM_STR);
//    $statement->execute();
//
//    $result = $statement->fetchAll(); 
//}
//
//printTable();

if (isset($_POST['create'])) {

  // config.php holds the server information 
  // change config file to local host (the one you made in Hazra's tutorial)
  // common.php maintains special characters used in html that would otherwise
  // not be recognized as HTML, by calling method  escape(<html>)
  // not be recognized as HTML, by calling method  escape(<html>)

  require "config.php";
  require "common.php";

  try {

    //open connection with information from config.php

    $connection = new PDO($dsn, $username, $password, $options);

    // create variables from users form inputs. In PHP, values are placed
    // into $_POST array
    $new_user = array(
      "CaseNo"     => $_POST['CaseNo'],
      "EmployeeID" => $_POST['EmployeeID'],
      "Date"     => $_POST['Date'],
      "Completed"     => $_POST['Completed'],
    );

    // create an SQL statement to insert users input
    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "MaintenanceRecord_Keeps_Tracks",
      implode(", ", array_keys($new_user)),
      ":" . implode(", :", array_keys($new_user))
    );

    // send the SQL to the server
    $statement = $connection->prepare($sql);
    $statement->execute($new_user);

  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }    
} else if (isset($_POST['view'])){
    try {
    require "config.php";
    require "common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT *
    FROM MaintenanceRecord_Keeps_Tracks";

    $statement = $connection->prepare($sql);
    $statement->bindParam(':CaseNo', $CaseNo, PDO::PARAM_STR);
    $statement->execute();
        
    $result = $statement->fetchAll();
    if ($result && $statement->rowCount() > 0) {
        echo "<table><tr><th class='border-class'>CaseNo</th>
        <th class='border-class'>EmployeeID</th>
        <th class='borderclass'>Date</th>
        <th class='borderclass'>Completed</th></tr>";
// output data of each row
        foreach($result as $row) {
            echo "<tr><td class='borderclass'>".$row["CaseNo"]."</td><td class='borderclass'>".$row["EmployeeID"]."</td><td class='borderclass'>".$row["Date"]."</td><td class='borderclass'>".$row["Completed"]."</td></tr>";}
        echo "</table>";
    } else {
        echo "0 results";
    }

  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}
?>


<!-- include website title/headers/etc, a "successfully added" message, 
 and the input form itself.-->
<?php include "templates/header.php"; ?>

  <?php if (isset($_POST['Create Maintenance Record']) && $statement) { ?>
    > <?php echo $_POST['CaseNo']; ?> successfully added.
  <?php } ?>

  <h2 style="color:white;">Maintenance Record</h2>

    <form method="post">
        <p>
            <input type="submit" name = "view" value="View Maintence Record"></p>

        <p>
    	<label for="CaseNo">CaseNo</label>
    	<input type="text" name="CaseNo" id="CaseNo">

    	<label for="EmployeeID">EmployeeID</label>
    	<input type="text" name="EmployeeID" id="EmployeeID">

    	<label for="Date">Date</label>
    	<input type="text" name="Date" id="Date">

    	<label for="Completed">Completed</label>
    	<input type="text" name="Completed" id="Completed">

    	<input type="submit" name="create" value="Create Maintenance Record">
        
        </p>

        <p>
           <label for="CaseNoUp">CaseNo to Update</label>
    	<input type="text" name="CaseNoUp" id="CaseNoUp">

    	<label for="EmployeeIDUp">EmployeeID to Update</label>
    	<input type="text" name="EmployeeIDUp" id="EmployeeIDUp">

    	<label for="DateUp">Date to Update</label>
    	<input type="text" name="DateUp" id="DateUp">

    	<label for="CompletedUp">Completed to Update</label>
    	<input type="text" name="CompletedUp" id="CompletedUp">


            <input type="submit" name = "update" value="Update Maintenance Record">
        </p>
        
        <p>
            <label for="CaseNoDel">CaseNo to Delete</label>
    	<input type="text" name="CaseNoDel" id="CaseNoDel">
            <input type="submit" name = "delete" value="Delete Maintenance Record">
        </p>
        

    </form>

<a href="createMaintenance.php">Back to HouseKeeping Assignment</a>

    <a href="indexEmployee.php">Back to Employee Management</a>
    
    <?php include "templates/footer.php"; ?>