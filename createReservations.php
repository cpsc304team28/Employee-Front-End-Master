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
            "ReservationNo" => $_POST['ReservationNo'],
            "RoomNo" => $_POST['RoomNo'],
            "CustomerID"=>$_POST['CustomerID'],
            "CheckInDate"=>$_POST['CheckInDate'],
        "CheckOutDate" => $_POST['CheckOutDate'],
//        "FacilityName" => $_POST['FacilityName'],
//        "Name" => $_POST['Name'],
//        "Position" => $_POST['Position']
        );

        // create an SQL statement to insert users input
        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "Reservation_Makes",
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
    FROM Reservation_Makes";

        $statement = $connection->prepare($sql);
        $statement->bindParam(':ReservationNo', $ReservationNo, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();
        if ($result && $statement->rowCount() > 0) {
            echo "<table><tr><th class='border-class'>ReservationNo</th>
        <th class='border-class'>RoomNo</th>
        <th class='borderclass'>CustomerID</th>
        <th class='borderclass'>CheckInDate</th>
        <th class='borderclass'>CheckOutDate</th></tr>";
// output data of each row
            foreach($result as $row) {
                echo "<tr><td class='borderclass'>".$row["ReservationNo"]."</td>
<td class='borderclass'>".$row["RoomNo"]."</td>
<td class='borderclass'>".$row["CustomerID"]."</td>
<td class='borderclass'>".$row["CheckInDate"]."</td>
<td class='borderclass'>".$row["CheckOutDate"]."</td></tr>";}
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

<?php if (isset($_POST['Create Employee']) && $statement) { ?>
    > <?php echo $_POST['EmployeeID']; ?> successfully added.
<?php } ?>

    <h2 style="color:white;">Employees</h2>

    <form method="post">

        <p>
            <input type="submit" name = "view" value="View Employees"></p>

        <p>

        <label for="ReservationNo">Reservation Number</label>
        <input type="text" name="ReservationNo" id="ReservationNo">

        <label for="FacilityName">Facility Name</label>
        <input type="text" name="FacilityName" id="FacilityName">

        <label for="Name">Name</label>
        <input type="text" name="Name" id="Name">

        <label for="Position">Position</label>
        <input type="text" name="Position" id="Position">

            <input type="submit" name="create" value="Create Employee"></p>

        <p>

            <label for="EmployeeIDUp">EmployeeID to Update</label>
            <input type="text" name="EmployeeIDUp" id="EmployeeIDUp">
            <label for="FacilityNameUp">Facility Name to Update</label>
            <input type="text" name="FacilityNameUp" id="FacilityNameUp">

            <label for="NameUp">Name to Update</label>
            <input type="text" name="NameUp" id="NameUp">

            <label for="PositionUp">Position to Update</label>
            <input type="text" name="PositionUp" id="PositionUp">

            <input type="submit" name = "update" value="Update Employee">
        </p>

        <p>
            <label for="EmployeeIDDel">EmployeeID to Delete</label>
            <input type="text" name="EmployeeIDDel" id="EmployeeIDDel">
            <input type="submit" name = "delete" value="Delete Employee">
        </p>


    </form>

    <a href="indexEmployee.php">Back to Employee Management</a>

<?php include "templates/footer.php"; ?>