<?php

/**
  * Configuration for database connection
  *
  */

$host       = "localhost";
//$port       = "8080";
$username   = "root";
$password   = "root";
$dbname     = "hotel"; // will use later
$dsn        = "mysql:host=$host;dbname=$dbname"; // will use later
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );