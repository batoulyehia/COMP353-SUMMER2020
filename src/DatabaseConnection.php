<?php
$servername = "localhost";                  //"wxc353.encs.concordia.ca";
$username = "root";                         //"wxc353_1";
$password = "";                             //"";

try {
  $conn = new PDO("mysql:host=$servername;dbname=login", $username, $password);                  //wxc353_1
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
