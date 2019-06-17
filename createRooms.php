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
            "RoomNo" => $_POST['RoomNo'],
            "Price" => $_POST['Price'],
            "NoOfBeds"=>$_POST['NoOfBeds'],
            "Kitchen"=>$_POST['Kitchen'],
            "Patio" => $_POST['Patio'],
            "Handicap" => $_POST['Handicap'],
            "PrivatePool" => $_POST['PrivatePool']
        );

        // create an SQL statement to insert users input
        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "Room",
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

        $sql = "SELECT * FROM Room";

        $statement = $connection->prepare($sql);
        $statement->bindParam(':CustomerID', $CustomerID, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();
        if ($result && $statement->rowCount() > 0) {
            echo "<table><tr><th class='border-class'>RoomNo</th>
        <th class='border-class'>Price</th>
        <th class='borderclass'>NoOfBeds</th>
        <th class='borderclass'>Kitchen</th>
        <th class='borderclass'>Patio</th>
        <th class='borderclass'>Handicap</th>
        <th class='borderclass'>PrivatePool</th></tr>";
// output data of each row
            foreach($result as $row) {
                echo "<tr><td class='borderclass'>".$row["RoomNo"]."</td>
<td class='borderclass'>".$row["Price"]."</td>
<td class='borderclass'>".$row["NoOfBeds"]."</td>
<td class='borderclass'>".$row["Kitchen"]."</td>
<td class='borderclass'>".$row["Patio"]."</td>
<td class='borderclass'>".$row["Handicap"]."</td>
<td class='borderclass'>".$row["NoOfAdults"]."</td>
<td class='borderclass'>".$row["PrivatePool"]."</td></tr>";}
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

<?php if (isset($_POST['Create Rooms']) && $statement) { ?>
    > <?php echo $_POST['RoomNo']; ?> successfully added.
<?php } ?>

    <h2 style="color:white;">Rooms</h2>

    <form method="post">

        <p>
            <input type="submit" name = "view" value="View Rooms"></p>

        <p>

        <label for="RoomNo">RoomNo</label>
        <input type="text" name="RoomNo" id="RoomNo">

        <label for="Price">Price</label>
        <input type="text" name="Price" id="Price">

        <label for="NoOfBeds">NoOfBeds</label>
        <input type="text" name="NoOfBeds" id="NoOfBeds">

        <label for="Kitchen">Kitchen</label>
        <input type="text" name="Kitchen" id="Kitchen">

            <label for="Patio">Patio</label>
            <input type="text" name="Patio" id="Patio">

            <label for="Handicap">Handicap</label>
            <input type="text" name="Handicap" id="Handicap">

            <label for="PrivatePool">PrivatePool</label>
            <input type="text" name="PrivatePool" id="PrivatePool">


            <input type="submit" name="create" value="Create Room"></p>

        <p>

            <label for="RoomNoUp">RoomNo to Update</label>
            <input type="text" name="RoomNoUp" id="RoomNoUp">

            <label for="PriceUp">Price to Update</label>
            <input type="text" name="PriceUp" id="PriceUp">

            <label for="NoOfBedsUp">NoOfBeds to Update</label>
            <input type="text" name="NoOfBedsUp" id="NoOfBedsUp">

            <label for="KitchenUp">Kitchen to Update</label>
            <input type="text" name="KitchenUp" id="KitchenUp">

            <label for="PatioUp">Patio to Update</label>
            <input type="text" name="PatioUp" id="PatioUp">

            <label for="HandicapUp">Handicap to Update</label>
            <input type="text" name="HandicapUp" id="HandicapUp">

            <label for="PrivatePoolUp">PrivatePool to Update</label>
            <input type="text" name="PrivatePoolUp" id="PrivatePoolUp">



            <input type="submit" name = "update" value="Update Room">
        </p>

        <p>
            <label for="RoomNoDel">Room to Delete</label>
            <input type="text" name="RoomNoDel" id="RoomNoDel">
            <input type="submit" name = "delete" value="Delete Room">
        </p>


    </form>

    <a href="indexHotel.php">Back to Hotel Management</a>


<?php include "templates/footer.php"; ?>