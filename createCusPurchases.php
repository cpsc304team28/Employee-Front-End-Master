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
            "EquipmentID" => $_POST['EquipmentID'],
        );

        // create an SQL statement to insert users input
        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "Rents",
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
    FROM Rents";

        $statement = $connection->prepare($sql);
        $statement->bindParam(':CustomerID', $CustomerID, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();
        if ($result && $statement->rowCount() > 0) {
            echo "<table><tr><th class='border-class'>CustomerID</th>
        <th class='border-class'>EquipmentID</th>";
// output data of each row
            foreach($result as $row) {
                echo "<tr><td class='borderclass'>".$row["CustomerID"]."</td><td class='borderclass'>".$row["EquipmentID"]."</td></tr>";}
            echo "</table>";
        } else {
            echo "0 results";
        }

    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} else if (isset($_POST['divide'])){
    try {
        require "config.php";
        require "common.php";

        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT CustomerID
FROM Customer
WHERE NOT EXISTS
(SELECT * 
    from Equipment 
    WHERE NOT EXISTS
    (SELECT CustomerID
        FROM Rents
        WHERE Equipment.EquipmentID = Rents.EquipmentID AND Customer.CustomerID=Rents.CustomerID))";

        $statement = $connection->prepare($sql);
        $statement->bindParam(':CustomerID', $CustomerID, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();
        if ($result && $statement->rowCount() > 0) {
            echo "<table><tr><th class='border-class'>CustomerID</th>";
// output data of each row
            foreach($result as $row) {
                echo "<tr><td class='borderclass'>".$row["CustomerID"]."</td></tr>";}
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

<?php if (isset($_POST['Create Equipment Rental']) && $statement) { ?>
    > <?php echo $_POST['EquipmentID']; ?> successfully added.
<?php } ?>

    <h2 style="color:white;">Equipment Rentals</h2>

    <form method="post">

        <p>
            <input type="submit" name = "view" value="View Equipment Rentals"></p>
        <p>
            <input type="submit" name = "divide" value="View Customers that have Rented All Equipment"></p>

        <p>
            <label for="CustomerID">CustomerID</label>
            <input type="text" name="CustomerID" id="CustomerID">

            <label for="EquipmentID">EquipmentID</label>
            <input type="text" name="EquipmentID" id="EquipmentID">

            <input type="submit" name="create" value="Create Equipment Rental">

        </p>
        <p>
            <label for="CustomerIDUp">CustomerID to Update</label>
            <input type="text" name="CustomerIDUp" id="CustomerIDUp">

            <label for="EquipmentIDUp">EquipmentID to Update</label>
            <input type="text" name="EquipmentIDUp" id="EquipmentIDUp">

            <input type="submit" name = "update" value="Update Equipment Rental">
        </p>

        <p>
            <label for="CustomerIDDel">CustomerID to Delete</label>
            <input type="text" name="CustomerIDDel" id="CustomerIDDel">
            <input type="submit" name = "delete" value="Delete Equipment Rental">
        </p>


    </form>

    <a href="createBuys.php">Manage Ticket Purchase</a>
    <a href="indexCustomer.php">Back to Customer Management</a>

<?php include "templates/footer.php"; ?>