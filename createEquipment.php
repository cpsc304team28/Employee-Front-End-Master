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
            "EquipmentID" => $_POST['EquipmentID'],
            "FacilityName" => $_POST['FacilityName'],
            "CurrentlyRented"=>$_POST['CurrentlyRented'],
            "Type"=>$_POST['Type']
        );

        // create an SQL statement to insert users input
        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "Equipment",
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

        $sql = "SELECT * FROM Equipment";

        $statement = $connection->prepare($sql);
        $statement->bindParam(':EquipmentID', $EquipmentID, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();
        if ($result && $statement->rowCount() > 0) {
            echo "<table><tr><th class='border-class'>EquipmentID</th><th class='border-class'>FacilityName</th>
        <th class='borderclass'>CurrentlyRented</th>
        <th class='borderclass'>Type</th></tr>";
// output data of each row
            foreach($result as $row) {
                echo "<tr><td class='borderclass'>".$row["EquipmentID"]."</td><td class='borderclass'>".$row["FacilityName"]."</td>
<td class='borderclass'>".$row["CurrentlyRented"]."</td>
<td class='borderclass'>".$row["Type"]."</td></tr>";}
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

<?php if (isset($_POST['Create Equipment']) && $statement) { ?>
    > <?php echo $_POST['EquipmentID']; ?> successfully added.
<?php } ?>

    <h2 style="color:white;">Equipment</h2>

    <form method="post">

        <p>
            <input type="submit" name = "view" value="View Equipment"></p>

        <p>

            <label for="EquipmentID">EquipmentID</label>
            <input type="text" name="EquipmentID" id="EquipmentID">

        <label for="FacilityName">FacilityName</label>
        <input type="text" name="FacilityName" id="FacilityName">


        <label for="CurrentlyRented">CurrentlyRented</label>
        <input type="text" name="CurrentlyRented" id="CurrentlyRented">

        <label for="Type">Type</label>
        <input type="text" name="Type" id="Type">


            <input type="submit" name="create" value="Create Equipment"></p>

        <p>

            <label for="EquipmentIDUp">EquipmentID to Update</label>
            <input type="text" name="EquipmentIDUp" id="EquipmentIDUp">

            <label for="FacilityNameUp">FacilityName to Update</label>
            <input type="text" name="FacilityNameUp" id="FacilityNameUp">


            <label for="CurrentlyRentedUp">CurrentlyRented to Update</label>
            <input type="text" name="CurrentlyRentedUp" id="CurrentlyRentedUp">

            <label for="TypeUp">Type to Update</label>
            <input type="text" name="TypeUp" id="TypeUp">




            <input type="submit" name = "update" value="Update Equipment">
        </p>

        <p>
            <label for="EquipmentIDDel">Equipment to Delete</label>
            <input type="text" name="EquipmentIDDel" id="EquipmentIDDel">
            <input type="submit" name = "delete" value="Delete Equipment">
        </p>


    </form>

    <a href="indexHotel.php">Back to Hotel Management</a>


<?php include "templates/footer.php"; ?>