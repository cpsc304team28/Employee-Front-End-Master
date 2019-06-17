<?php
// Use an HTML form to edit an entry in the customers table.

require "config.php";
require "common.php";

// Similar to create.php submit form
if (isset($_POST['submit'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $Customer =[
        "customerID"     => $_GET['customerID'],
        "name" => $_POST['name'],
        "phoneno"     => $_POST['phoneno'],
        "email"     => $_POST['email'],
        "address"   => $_POST['address'],
        "creditcard"    => $_POST['creditcard'],
        "noOfAdults"    => $_POST['noOfAdults'],
        "noOfChildren"  => $_POST['noOfChildren']
    ];

    $sql = "UPDATE Customer
              SET 
              customerID = :customerID,
              name = :name,
              phoneno = :phoneno,
              email = :email,
              address = :address,
              creditcard = :creditcard,
              noOfAdults = :noOfAdults,
              noOfChildren = :noOfChildren
            WHERE customerID = :customerID";

    $statement = $connection->prepare($sql);
    $statement->execute($Customer);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}

// Fetch customer tuple from given CustomerID, store it in $Customer
if (isset($_GET['customerID'])) {

  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $customerID = $_GET['customerID'];
    $sql = "SELECT * FROM Customer WHERE customerID = :customerID";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':customerID', $customerID);
    $statement->execute();
    $Customer = $statement->fetch(PDO::FETCH_ASSOC);

  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Something went wrong!";
    exit;
}
?>

<?php require "templates/header.php"; ?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <?php echo escape($_POST['name']); ?> successfully updated.
  <?php endif; ?>

  <h2 style="color:white;">Edit a Customer</h2>

  <!-- Input form, don't allow editing of customerID -->
  <form method="post">

    <label for="customerID">ID #</label>
    <?php echo $_GET['customerID']; ?> 

    <label for="name">Name</label>
    <input type="text" name="name" id="name">

    <label for="email">Email Address</label>
    <input type="text" name="email" id="email">

    <label for="phoneno">Phone</label>
    <input type="text" name="phoneno" id="phoneno">

    <label for="address">Address</label>
    <input type="text" name="address" id="address">

    <label for="creditcard">Credit Card</label>
    <input type="text" name="creditcard" id="creditcard">

    <label for="noOfAdults">Number of Adults</label>
    <input type="text" name="noOfAdults" id="noOfAdults">

    <label for="noOfChildren">Number of Children</label>
    <input type="text" name="noOfChildren" id="noOfChildren">

    <input type="submit" name="submit" value="Submit">

  </form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>