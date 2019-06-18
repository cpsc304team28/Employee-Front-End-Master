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
} else if (isset($_POST['delete'])) {
    try {

        require "config.php";
        require "common.php";
        $connection = new PDO($dsn, $username, $password, $options);

        $ReservationNo = $_POST['ReservationNo_del'];

        $sql = "DELETE FROM Reservation_Makes WHERE ReservationNo = $ReservationNo";

        $statement = $connection->prepare($sql);
        $statement->bindValue(':ReservationNo_del', $ReservationNo);
        $statement->execute();

        $success = "User successfully deleted";
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>


    <!-- include website title/headers/etc, a "successfully added" message,
     and the input form itself.-->
<?php include "templates/header.php"; ?>

<?php if (isset($_POST['Create Reservation']) && $statement) { ?>
    > <?php echo $_POST['ReservationNo']; ?> successfully added.
<?php } ?>

    <h2 style="color:white;">Reservation</h2>

    <form method="post">

        <p>
            <input type="submit" name = "view" value="View Reservations"></p>

        <p>

            <label for="ReservationNo">Reservation Number</label>
            <input type="text" name="ReservationNo" id="ReservationNo">

            <label for="RoomNo">RoomNo</label>
            <input type="text" name="RoomNo" id="RoomNo">

            <label for="CustomerID">CustomerID</label>
            <input type="text" name="CustomerID" id="CustomerID">

            <label for="CheckInDate">Check-In Date</label>
            <input type="text" name="CheckInDate" id="CheckInDate">

            <label for="CheckOutDate">Check-Out Date</label>
            <input type="text" name="CheckOutDate" id="CheckOutDate">

            <input type="submit" name="create" value="Create Reservation"></p>

        <p>

            <label for="ReservationNoUp">ReservationNo to Update</label>
            <input type="text" name="ReservationNoUp" id="ReservationNoUp">

            <label for="RoomNoUp">RoomNo to Update</label>
            <input type="text" name="RoomNoUp" id="RoomNoUp">

            <label for="CustomerIDUp">CustomerIDUp to Update</label>
            <input type="text" name="CustomerIDUp" id="CustomerIDUp">

            <label for="CheckInDateUp">CheckInDate to Update</label>
            <input type="text" name="CheckInDateUp" id="CheckInDateUp">

            <label for="CheckOutDateUp">CheckOutDate to Update</label>
            <input type="text" name="CheckOutDateUp" id="CheckOutDateUp">

            <input type="submit" name = "update" value="Update Reservation">
        </p>

        <p>
            <label for="ReservationNo_del">Reservation to Delete</label>
            <input type="text" name="ReservationNo_del" id="ReservationNo_del">
            <input type="submit" name = "delete" value="Delete Reservation">
        </p>


    </form>

    <a href="indexCustomer.php">Back to Customer Management</a>

<?php include "templates/footer.php"; ?>