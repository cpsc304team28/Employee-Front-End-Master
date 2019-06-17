<?php

  // Function to query information based on
  // a parameter: in this case, CustomerID.


// Send SQL statement to display customer with given customerID
$result = 0;
if (isset($_POST['submit'])) {
  try {
    require "config.php";
    require "common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT *
    FROM Customer
    WHERE CustomerID = :CustomerID";

    $CustomerID = $_POST['CustomerID'];

    $statement = $connection->prepare($sql);
    $statement->bindParam(':CustomerID', $CustomerID, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetchAll();
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}
?>

<!-- Table to display the customer information -->
<?php require "templates/header.php"; ?>
  <?php
  if (isset($_POST['submit'])) {
    if ($result && $statement->rowCount() > 0) { ?>
      <h2 style="color:white;">Results</h2>

      <table class="blueTable">
        <thead>
          <tr>
            <th>ID #</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Address</th>
            <th>Credit Card</th>
            <th>Adults</th>
            <th>Children</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($result as $row) { ?>
            <tr>
              <td><?php echo escape($row["CustomerID"]); ?></td>
              <td><?php echo escape($row["Name"]); ?></td>
              <td><?php echo escape($row["PhoneNo"]); ?></td>
              <td><?php echo escape($row["Email"]); ?></td>
              <td><?php echo escape($row["Address"]); ?></td>
              <td><?php echo escape($row["CreditCard"]); ?></td>
              <td><?php echo escape($row["noOfAdults"]); ?> </td>
              <td><?php echo escape($row["noOfChildren"]); ?> </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } else { ?>
      > No results found for <?php echo escape($_POST['PhoneNo']); ?>.
    <?php }
  } ?>

  <!-- Form to enter customer information; submit calls SQL method up top -->
  <h2 style="color:white;">View Account</h2>
  <form method="post">
    <label for="CustomerID">Enter your unique customer ID:</label>
    <input type="text" id="CustomerID" name="CustomerID">
    <input type="submit" name="submit" value="View Results">
  </form>

  <a href="index.php">Back to home</a>

<?php include "templates/footer.php"; ?>