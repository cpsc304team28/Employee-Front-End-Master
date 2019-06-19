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

  require "config.php";
  require "common.php";

  try {

    //open connection with information from config.php

    $connection = new PDO($dsn, $username, $password, $options);

    // create variables from users form inputs. In PHP, values are placed
    // into $_POST array
    $new_user = array(
      "EmployeeID"     => $_POST['EmployeeID'],
      "StationNo" => $_POST['StationNo'],
    );

    // create an SQL statement to insert users input
    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "Lifeguard_Guards",
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
    FROM Lifeguard_Guards";

    $statement = $connection->prepare($sql);
    $statement->bindParam(':EmployeeID', $EmployeeID, PDO::PARAM_STR);
    $statement->execute();
        
    $result = $statement->fetchAll();
    if ($result && $statement->rowCount() > 0) {
        echo "<table><tr><th class='border-class'>EmployeeID</th>
        <th class='border-class'>StationNo</th>";
// output data of each row
        foreach($result as $row) {
            echo "<tr><td class='borderclass'>".$row["EmployeeID"]."</td>
<td class='borderclass'>".$row["StationNo"]."</td></tr>";}
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

  <?php if (isset($_POST['Create Lifeguard Assignment']) && $statement) { ?>
    > <?php echo $_POST['EmployeeID']; ?> successfully added.
  <?php } ?>

  <h2 style="color:white;">Lifeguards</h2>

    <form method="post">
        <p>
            <input type="submit" name = "view" value="View Lifeguard Assignment"></p>

        <p>
    	<label for="EmployeeID">EmployeeID</label>
    	<input type="text" name="EmployeeID" id="EmployeeID">

    	<label for="StationNo">StationNo</label>
    	<input type="text" name="StationNo" id="StationNo">

            <input type="submit" name="create" value="Create Lifeguard Assignment"></p>
        
<!--        <p>-->

<!--        <p>-->
<!--           <label for="EmployeeIDUp">EmployeeID to Update</label>-->
<!--    	<input type="text" name="EmployeeIDUp" id="EmployeeIDUp">-->
<!---->
<!--    	<label for="StationNoUp">StationNo to Update</label>-->
<!--    	<input type="text" name="StationNoUp" id="StationNoUp">-->
<!---->
<!--            <input type="submit" name = "update" value="Update Lifeguard Assignment">-->
<!--        </p>-->
<!--        -->
<!--        <p>-->
<!--            <label for="EmployeeIDDel">EmployeeID to Delete</label>-->
<!--    	<input type="text" name="EmployeeIDDel" id="EmployeeIDDel">-->
<!--            <input type="submit" name = "delete" value="Delete Lifeguard Assignment">-->
<!--        </p>-->
<!--        -->

    </form>

<a href="createInstructor.php">Create New Instructor</a>
    <a href="indexEmployee.php">Back to Employee Management</a>
    
    <?php include "templates/footer.php"; ?>