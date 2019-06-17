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
      "VehicleType" => $_POST['VehicleType'],
      "Capacity"     => $_POST['Capacity'],
    );

    // create an SQL statement to insert users input
    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "Vehicle",
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
    FROM Vehicle";

    $statement = $connection->prepare($sql);
    $statement->bindParam(':VehicleType', $VehicleType, PDO::PARAM_STR);
    $statement->execute();
        
    $result = $statement->fetchAll();
    if ($result && $statement->rowCount() > 0) {
        echo "<table><tr>
        <th class='border-class'>VehicleType</th>
        <th class='borderclass'>Capacity</th></tr>";
// output data of each row
        foreach($result as $row) {
            echo "<tr><td class='borderclass'>".$row["VehicleType"]."</td><td class='borderclass'>".$row["Capacity"]."</td></tr>";}
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

  <?php if (isset($_POST['Create VehicleType Record']) && $statement) { ?>
    > <?php echo $_POST['VehicleType']; ?> successfully added.
  <?php } ?>

  <h2 style="color:white;">VehicleType Record</h2>

    <form method="post">

    	<label for="VehicleType">VehicleType</label>
    	<input type="text" name="VehicleType" id="VehicleType">

    	<label for="Capacity">Destination</label>
    	<input type="text" name="Capacity" id="Capacity">

    	<input type="submit" name="create" value="Create Vehicle Record">
        
        <p>
            <input type="submit" name = "view" value="View Vehicle Records"></p>
        
         <p>

    	<label for="VehicleType">VehicleType to Update</label>
    	<input type="text" name="VehicleType" id="VehicleType">

    	<label for="Capacity">Destination to Update</label>
    	<input type="text" name="Capacity" id="Capacity">


            <input type="submit" name = "update" value="Update Vehicle Record">
        </p>
        
        <p>
            <label for="VehicleType">VehicleType to Delete</label>
    	<input type="text" name="VehicleType" id="VehicleType">
            <input type="submit" name = "delete" value="Delete VehicleType Record">
        </p>
        

    </form>

    <a href="indexTransport.php">Back to Transportation Management</a>
    
    <?php include "templates/footer.php"; ?>