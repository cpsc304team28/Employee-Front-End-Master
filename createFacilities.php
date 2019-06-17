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
            "FacilityName" => $_POST['FacilityName'],
            "Capacity" => $_POST['Capacity'],
            "OpeningHour"=>$_POST['OpeningHour'],
            "ClosingHour"=>$_POST['ClosingHour']
        );

        // create an SQL statement to insert users input
        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "Facility",
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

        $sql = "SELECT * FROM Facility";

        $statement = $connection->prepare($sql);
        $statement->bindParam(':FacilityName', $FacilityName, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();
        if ($result && $statement->rowCount() > 0) {
            echo "<table><tr><th class='border-class'>FacilityName</th>
        <th class='border-class'>Capacity</th>
        <th class='borderclass'>OpeningHour</th>
        <th class='borderclass'>ClosingHour</th></tr>";
// output data of each row
            foreach($result as $row) {
                echo "<tr><td class='borderclass'>".$row["FacilityName"]."</td>
<td class='borderclass'>".$row["Capacity"]."</td>
<td class='borderclass'>".$row["OpeningHour"]."</td>
<td class='borderclass'>".$row["ClosingHour"]."</td></tr>";}
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

<?php if (isset($_POST['Create Facility']) && $statement) { ?>
    > <?php echo $_POST['FacilityName']; ?> successfully added.
<?php } ?>

    <h2 style="color:white;">Facilities</h2>

    <form method="post">

        <p>
            <input type="submit" name = "view" value="View Facilities"></p>

        <p>

        <label for="FacilityName">FacilityName</label>
        <input type="text" name="FacilityName" id="FacilityName">

        <label for="Capacity">Capacity</label>
        <input type="text" name="Capacity" id="Capacity">

        <label for="OpeningHour">OpeningHour</label>
        <input type="text" name="OpeningHour" id="OpeningHour">

        <label for="ClosingHour">ClosingHour</label>
        <input type="text" name="ClosingHour" id="ClosingHour">


            <input type="submit" name="create" value="Create Facility"></p>

        <p>

            <label for="FacilityNameUp">FacilityName to Update</label>
            <input type="text" name="FacilityNameUp" id="FacilityNameUp">

            <label for="CapacityUp">Capacity to Update</label>
            <input type="text" name="CapacityUp" id="CapacityUp">

            <label for="OpeningHourUp">OpeningHour to Update</label>
            <input type="text" name="OpeningHourUp" id="OpeningHourUp">

            <label for="ClosingHourUp">ClosingHour to Update</label>
            <input type="text" name="ClosingHourUp" id="ClosingHourUp">




            <input type="submit" name = "update" value="Update Facility">
        </p>

        <p>
            <label for="FacilityNameDel">Facility to Delete</label>
            <input type="text" name="FacilityNameDel" id="FacilityNameDel">
            <input type="submit" name = "delete" value="Delete Facility">
        </p>


    </form>

    <a href="indexHotel.php">Back to Hotel Management</a>


<?php include "templates/footer.php"; ?>