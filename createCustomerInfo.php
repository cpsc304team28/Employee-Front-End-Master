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
            "CustomerID" => $_POST['CustomerID'],
            "Name" => $_POST['Name'],
            "PhoneNo"=>$_POST['PhoneNo'],
            "Email"=>$_POST['Email'],
            "Address" => $_POST['Address'],
            "CreditCard" => $_POST['CreditCard'],
            "NoOfAdults" => $_POST['NoOfAdults'],
            "NoOfChildren" => $_POST['NoOfChildren']
        );

        // create an SQL statement to insert users input
        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "Customer",
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

        $sql = "SELECT * FROM Customer";

        $statement = $connection->prepare($sql);
        $statement->bindParam(':CustomerID', $CustomerID, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();
        if ($result && $statement->rowCount() > 0) {
            echo "<table><tr><th class='border-class'>CustomerID</th>
        <th class='border-class'>Name</th>
        <th class='borderclass'>PhoneNo</th>
        <th class='borderclass'>Email</th>
        <th class='borderclass'>Address</th>
        <th class='borderclass'>CreditCard</th>
        <th class='borderclass'>NoOfAdults</th>
        <th class='borderclass'>NoOfChildren</th></tr>";
// output data of each row
            foreach($result as $row) {
                echo "<tr><td class='borderclass'>".$row["CustomerID"]."</td>
<td class='borderclass'>".$row["Name"]."</td>
<td class='borderclass'>".$row["PhoneNo"]."</td>
<td class='borderclass'>".$row["Email"]."</td>
<td class='borderclass'>".$row["Address"]."</td>
<td class='borderclass'>".$row["CreditCard"]."</td>
<td class='borderclass'>".$row["NoOfAdults"]."</td>
<td class='borderclass'>".$row["NoOfChildren"]."</td></tr>";}
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
            <input type="submit" name = "view" value="View Customers"></p>

        <p>

        <label for="CustomerID">CustomerID</label>
        <input type="text" name="CustomerID" id="CustomerID">

        <label for="Name">Name</label>
        <input type="text" name="Name" id="Name">

        <label for="PhoneNo">PhoneNo</label>
        <input type="text" name="PhoneNo" id="PhoneNo">

        <label for="Email">Email</label>
        <input type="text" name="Email" id="Email">

            <label for="Address">Address</label>
            <input type="text" name="Address" id="Address">

            <label for="CreditCard">CreditCard</label>
            <input type="text" name="CreditCard" id="CreditCard">

            <label for="NoOfAdults">NoOfAdults</label>
            <input type="text" name="NoOfAdults" id="NoOfAdults">

            <label for="NoOfChildren">NoOfChildren</label>
            <input type="text" name="NoOfChildren" id="NoOfChildren">




            <input type="submit" name="create" value="Create Customer"></p>

<!--        <p>-->
<!---->
<!--            <label for="CustomerIDUp">CustomerID to Update</label>-->
<!--            <input type="text" name="CustomerIDUp" id="CustomerIDUp">-->
<!---->
<!--            <label for="NameUp">Name to Update</label>-->
<!--            <input type="text" name="NameUp" id="NameUp">-->
<!---->
<!--            <label for="PhoneNoUp">Phone Number to Update</label>-->
<!--            <input type="text" name="PhoneNoUp" id="PhoneNoUp">-->
<!---->
<!--            <label for="EmailUp">Email to Update</label>-->
<!--            <input type="text" name="EmailUp" id="EmailUp">-->
<!---->
<!--            <label for="AddressUp">Address to Update</label>-->
<!--            <input type="text" name="AddressUp" id="AddressUp">-->
<!---->
<!--            <label for="CreditCardUp">Credit Card Number to Update</label>-->
<!--            <input type="text" name="CreditCardUp" id="CreditCardUp">-->
<!---->
<!--            <label for="NoOfAdultsUp">NoOfAdults to Update</label>-->
<!--            <input type="text" name="NoOfAdultsUp" id="NoOfAdultsUp">-->
<!---->
<!--            <label for="NoOfChildrenUp">NoOfChildren to Update</label>-->
<!--            <input type="text" name="NoOfChildrenUp" id="NoOfChildrenUp">-->
<!---->
<!---->
<!---->
<!--            <input type="submit" name = "update" value="Update Customer">-->
<!--        </p>-->
<!---->
<!--        <p>-->
<!--            <label for="CustomerIDDel">CustomerID to Delete</label>-->
<!--            <input type="text" name="CustomerIDDel" id="CustomerIDDel">-->
<!--            <input type="submit" name = "delete" value="Delete Customer">-->
<!--        </p>-->


    </form>

    <a href="createEmergency.php">Create an Emergency Contact</a>
    <a href="indexCustomer.php">Back to Customer Management</a>


<?php include "templates/footer.php"; ?>