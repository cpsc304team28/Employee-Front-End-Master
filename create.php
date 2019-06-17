<?php
// Use an HTML form to create a new entry in the Customer table.

// When SUBMIT button pressed, open new PDO (PHP data object) connection, 
// then send INSERT SQL statement with the users inputted values

if (isset($_POST['submit'])) {

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
      "customerID"     => $_POST['phoneno'],
      "name" => $_POST['name'],
      "phoneno"     => $_POST['phoneno'],
      "email"     => $_POST['email'],
      "address"   => $_POST['address'],
      "creditcard"    => $_POST['creditcard'],
      "noOfAdults"    => $_POST['noOfAdults'],
      "noOfChildren"  => $_POST['noOfChildren'],
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
}
?>


<!-- include website title/headers/etc, a "successfully added" message, 
 and the input form itself.-->
<?php include "templates/header.php"; ?>

  <?php if (isset($_POST['submit']) && $statement) { ?>
    > <?php echo $_POST['name']; ?> successfully added.
  <?php } ?>

  <h2 style="color:white;">Sign-up</h2>

    <form method="post">

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
    
    <?php include "templates/footer.php"; ?>