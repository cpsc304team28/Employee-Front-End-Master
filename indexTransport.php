<!-- Homepage with links to each option -->

<?php include "templates/header.php"; ?>

<div>
  <ul>
    <li>
      <img src="https://image.flaticon.com/icons/svg/1665/1665746.svg">
      <h3> <a href="createTransport.php"><strong>Manage Transportation</strong></a> </h3>
       <p>Insert, Update, View, and Delete overview of Transportation</p>
    </li>
    <li>
      <img src="https://image.flaticon.com/icons/svg/1665/1665746.svg" >
      <h3>      <a href="createVehicles.php"><strong>Vehicles</strong></a> </h3>
      <p>Insert, Update, View, and Delete Vehicles</p>
    </li>
    <li>
      <img src="https://image.flaticon.com/icons/svg/1665/1665746.svg">
      <h3><a href="createShuttle.php"><strong>Shuttle Schedule</strong></a></h3>
      <p>Insert, Update, View, and Delete Shuttle Schedules</p>
      </li>
    <li>
      <img src="https://image.flaticon.com/icons/svg/1665/1665746.svg" >
      <h3><a href="createProvides.php"><strong>Employee Providing Transportation</strong></a></h3>
      <p>Insert, Update, View, and Delete Employees providing the Transportation</p>
    </li>
  </ul>
</div>

<a href="index.php">Back to Management</a>

<?php include "templates/footer.php"; ?>
