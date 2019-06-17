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
      "Destination" => $_POST['Destination'],
      "DepartureTime"     => $_POST['DepartureTime'],
        "ArrivalTime" => $_POST['ArrivalTime'],
    );

    // create an SQL statement to insert users input
    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "ShuttleSchedule",
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
    FROM ShuttleSchedule";

    $statement = $connection->prepare($sql);
    $statement->bindParam(':Destination', $Destination, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetchAll();
    if ($result && $statement->rowCount() > 0) {
        echo "<table><tr>
        <th class='border-class'>VehicleType</th>
        <th class='borderclass'>Capacity</th></tr>";
// output data of each row
        foreach($result as $row) {
            echo "<tr><td class='borderclass'>".$row["Destination"]."</td><td class='borderclass'>".$row["DepartureTime"]."</td><td class='borderclass'>".$row["ArrivalTime"]."</td></tr>";}
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

  <?php if (isset($_POST['Create Shuttle Schedule']) && $statement) { ?>
    > <?php echo $_POST['Destination']; ?> successfully added.
  <?php } ?>

  <h2 style="color:white;">Shuttle Schedule</h2>

    <form method="post">
        <p>
            <input type="submit" name = "view" value="View Shuttle Schedule Records"></p>

        <p>
    	<label for="Destination">Destination</label>
    	<input type="text" name="Destination" id="Destination">

    	<label for="DepartureTime">DepartureTime</label>
    	<input type="text" name="DepartureTime" id="DepartureTime">

        <label for="ArrivalTime">ArrivalTime</label>
        <input type="text" name="ArrivalTime" id="ArrivalTime">

    	<input type="submit" name="create" value="Create Shuttle Schedule Record">
        </p>
        <p>

    	<label for="DestinationUp">VehicleType to Update</label>
    	<input type="text" name="DestinationUp" id="DestinationUp">

    	<label for="DepartureTimeUp">DepartureTime to Update</label>
    	<input type="text" name="DepartureTimeUp" id="DepartureTimeUp">

             <label for="ArrivalTimeUp">ArrivalTime to Update</label>
             <input type="text" name="ArrivalTimeUp" id="ArrivalTimeUp">


            <input type="submit" name = "update" value="Update Shuttle Schedule Record">
        </p>

        <p>
            <label for="DestinationDel">Shuttle Schedule to Delete</label>
    	<input type="text" name="DestinationDel" id="DestinationDel">
            <input type="submit" name = "delete" value="Delete Shuttle Schedule Record">
        </p>


    </form>

    <a href="indexTransport.php">Back to Transportation Management</a>

    <?php include "templates/footer.php"; ?>