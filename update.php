<?php
// List all Customers with a link to edit

// Establish new PDO (PHP data object) connection, 
// then send SELECT SQL statement to server, and store it in $result
try {
  require "config.php";
  require "common.php";

  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM Customer";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>


<!-- Table with customers presented below -->

<?php require "templates/header.php"; ?>

  <h2 style="color:white;">Update Customers</h2>

  <table class="blueTable">
    <!-- Create table headers -->
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
        <th>Edit</th>
      </tr>
    </thead>
     <!-- For each tuple returned from our SQL statement, display the tuple under 
      corresponding table header -->
    <tbody>
      <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["CustomerID"]); ?></td>
          <td><?php echo escape($row["Name"]); ?></td>
          <td><?php echo escape($row["PhoneNo"]); ?></td>
          <td><?php echo escape($row["Email"]); ?></td>
          <td><?php echo escape($row["Address"]); ?></td>
          <td><?php echo escape($row["CreditCard"]); ?></td>
          <td><?php echo escape($row["noOfAdults"]); ?> </td>
          <td><?php echo escape($row["noOfChildren"]); ?> </td>
          <!-- create a link that refers to customerID of respective row
          link to "update-single.php" page with that specific customerID -->
          <td><a href="update-single.php?customerID= <?php echo escape($row["CustomerID"]); ?>">Edit</a> </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <a href="index.php">Back to home</a>
<?php require "templates/footer.php"; ?>