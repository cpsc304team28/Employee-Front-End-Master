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
            "EmergencyName" => $_POST['EmergencyName'],
            "CustomerID" => $_POST['CustomerID'],
            "PhoneNo"=>$_POST['PhoneNo'],
            "RelationToCustomer"=>$_POST['RelationToCustomer']
        );

        // create an SQL statement to insert users input
        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "EmergencyContact",
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

        $sql = "SELECT * FROM EmergencyContact";

        $statement = $connection->prepare($sql);
        $statement->bindParam(':CustomerID', $CustomerID, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();
        if ($result && $statement->rowCount() > 0) {
            echo "<table><tr><th class='border-class'>EmergencyName</th>
<th class='border-class'>CustomerID</th>        
        <th class='borderclass'>PhoneNo</th>
        <th class='borderclass'>RelationToCustomer</th></tr>";
// output data of each row
            foreach($result as $row) {
                echo "<tr><td class='borderclass'>".$row["EmergencyName"]."</td><td class='borderclass'>".$row["CustomerID"]."</td>
<td class='borderclass'>".$row["PhoneNo"]."</td>
<td class='borderclass'>".$row["RelationToCustomer"]."</td></tr>";}
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

<?php if (isset($_POST['Create Customer']) && $statement) { ?>
    > <?php echo $_POST['CustomerID']; ?> successfully added.
<?php } ?>

    <h2 style="color:white;">Customers</h2>

    <form method="post">

        <p>
            <input type="submit" name = "view" value="View Emergency Contacts"></p>

        <p>

            <label for="EmergencyName">Emergency Name</label>
            <input type="text" name="EmergencyName" id="EmergencyName">

        <label for="CustomerID">CustomerID</label>
        <input type="text" name="CustomerID" id="CustomerID">

        <label for="PhoneNo">PhoneNo</label>
        <input type="text" name="PhoneNo" id="PhoneNo">

        <label for="RelationToCustomer">Relation To Customer</label>
        <input type="text" name="RelationToCustomer" id="RelationToCustomer">




            <input type="submit" name="create" value="Create Emergency Contact"></p>
<!---->
<!--        <p>-->
<!---->
<!--            <label for="EmergencyNameUp">Emergency Name to Update</label>-->
<!--            <input type="text" name="EmergencyNameUp" id="EmergencyNameUp">-->
<!---->
<!--            <label for="CustomerIDUp">CustomerID to Update</label>-->
<!--            <input type="text" name="CustomerIDUp" id="CustomerIDUp">-->
<!---->
<!--            <label for="PhoneNoUp">PhoneNo to Update</label>-->
<!--            <input type="text" name="PhoneNoUp" id="PhoneNoUp">-->
<!---->
<!--            <label for="RelationToCustomerUp">Relation To Customer to Update</label>-->
<!--            <input type="text" name="RelationToCustomerUp" id="RelationToCustomerUp">-->
<!---->
<!---->
<!---->
<!--            <input type="submit" name = "update" value="Update Emergency Contact">-->
<!--        </p>-->
<!---->
<!--        <p>-->
<!--            <label for="CustomerIDDel">Emergency Contact from CustomerID to Delete</label>-->
<!--            <input type="text" name="CustomerIDDel" id="CustomerIDDel">-->
<!--            <input type="submit" name = "delete" value="Delete Emergency Contact">-->
<!--        </p>-->


    </form>

    <a href="createCustomerInfo.php">Back to Customer Information</a>
    <a href="indexCustomer.php">Back to Customer Management</a>


<?php include "templates/footer.php"; ?>