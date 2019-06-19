<?php
// Use an HTML form to create a new entry in the Customer table.

// When SUBMIT button pressed, open new PDO (PHP data object) connection, 
// then send INSERT SQL statement with the users inputted values

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
      "CustomerID"     => $_POST['CustomerID'],
      "TransportationID" => $_POST['TransportationID'],
        "TicketID" => $_POST['TicketID']
    );

    // create an SQL statement to insert users input
    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "Buys",
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
    FROM Buys";

    $statement = $connection->prepare($sql);
    $statement->bindParam(':CustomerID', $CustomerID, PDO::PARAM_STR);
    $statement->execute();
        
    $result = $statement->fetchAll();
    if ($result && $statement->rowCount() > 0) {
        echo "<table><tr><th class='border-class'>CustomerID</th>
        <th class='border-class'>TransportationID</th>
        <th class='border-class'>TicketID</th>";
// output data of each row
        foreach($result as $row) {
            echo "<tr><td class='borderclass'>".$row["CustomerID"]."</td><td class='borderclass'>".$row["TransportationID"]."</td>
<td class='borderclass'>".$row["TicketID"]."</td></tr>";}
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

  <?php if (isset($_POST['Create Ticket Purchase']) && $statement) { ?>
    > <?php echo $_POST['TicketID']; ?> successfully added.
  <?php } ?>

  <h2 style="color:white;">Ticket Purchases</h2>

    <form method="post">

        <p>
            <input type="submit" name = "view" value="View Ticket Purchases"></p>

        <p>
    	<label for="CustomerID">CustomerID</label>
    	<input type="text" name="CustomerID" id="CustomerID">

    	<label for="TransportationID">TransportationID</label>
            <input type="text" name="TransportationID" id="TransportationID">

            <label for="TicketID">TicketID</label>
            <input type="text" name="TicketID" id="TicketID">

    	<input type="submit" name="create" value="Create Ticket Purchase">
        
        </p>
<!--        <p>-->
<!--            <label for="CustomerIDUp">CustomerID to Update</label>-->
<!--            <input type="text" name="CustomerIDUp" id="CustomerIDUp">-->
<!---->
<!--            <label for="TransportationIDUp">TransportationID to Update</label>-->
<!--            <input type="text" name="TransportationIDUp" id="TransportationIDUp">-->
<!---->
<!--            <label for="TicketIDUp">TicketID to Update</label>-->
<!--            <input type="text" name="TicketIDUp" id="TicketIDUp">-->
<!---->
<!--            <input type="submit" name = "update" value="Update Ticket Purchase">-->
<!--        </p>-->
<!--        -->
<!--        <p>-->
<!--            <label for="CustomerIDDel">CustomerID Purchase to Delete</label>-->
<!--    	<input type="text" name="CustomerIDDel" id="CustomerIDDel">-->
<!--            <input type="submit" name = "delete" value="Delete Equipment Rental">-->
<!--        </p>-->
<!--        -->

    </form>

<a href="createCusPurchases.php">Back to Equipment Rentals</a>
    <a href="indexCustomer.php">Back to Customer Management</a>
    
    <?php include "templates/footer.php"; ?>