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
      "TransportationID"     => $_POST['TransportationID'],
      "VehicleType" => $_POST['VehicleType'],
      "Destination"     => $_POST['Destination'],
      "Date"     => $_POST['Date'],
    );

    // create an SQL statement to insert users input
    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "Transportation",
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
    FROM Transportation";

    $statement = $connection->prepare($sql);
    $statement->bindParam(':TransportationID', $TransportationID, PDO::PARAM_STR);
    $statement->execute();
        
    $result = $statement->fetchAll();
    if ($result && $statement->rowCount() > 0) {
        echo "<table><tr><th class='border-class'>TransportationID</th>
        <th class='border-class'>VehicleType</th>
        <th class='borderclass'>Destination</th>
        <th class='borderclass'>Date</th></tr>";
// output data of each row
        foreach($result as $row) {
            echo "<tr><td class='borderclass'>".$row["TransportationID"]."</td><td class='borderclass'>".$row["VehicleType"]."</td><td class='borderclass'>".$row["Destination"]."</td><td class='borderclass'>".$row["Date"]."</td></tr>";}
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

  <?php if (isset($_POST['Create Transportation Record']) && $statement) { ?>
    > <?php echo $_POST['TransportationID']; ?> successfully added.
  <?php } ?>

  <h2 style="color:white;">Transportation Record</h2>

    <form method="post">

    	<label for="TransportationID">TransportationID</label>
    	<input type="text" name="TransportationID" id="TransportationID">

    	<label for="VehicleType">VehicleType</label>
    	<input type="text" name="VehicleType" id="VehicleType">

    	<label for="Destination">Destination</label>
    	<input type="text" name="Destination" id="Destination">

    	<label for="Date">Date</label>
    	<input type="text" name="Date" id="Date">

    	<input type="submit" name="create" value="Create Transportation Record">
        
        <p>
            <input type="submit" name = "view" value="View Transportation Records"></p>
        
         <p>
           <label for="TransportationID">TransportationID to Update</label>
    	<input type="text" name="TransportationID" id="TransportationID">

    	<label for="VehicleType">VehicleType to Update</label>
    	<input type="text" name="VehicleType" id="VehicleType">

    	<label for="Destination">Destination to Update</label>
    	<input type="text" name="Destination" id="Destination">

    	<label for="Date">Date to Update</label>
    	<input type="text" name="Date" id="Date">


            <input type="submit" name = "update" value="Update Transportation Record">
        </p>
        
        <p>
            <label for="TransportationID">TransportationID to Delete</label>
    	<input type="text" name="TransportationID" id="TransportationID">
            <input type="submit" name = "delete" value="Delete Transportation Record">
        </p>
        

    </form>

    <a href="indexTransport.php">Back to Transportation Management</a>
    
    <?php include "templates/footer.php"; ?>