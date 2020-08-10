<?php
$servername = "wxc353.encs.concordia.ca";                  //"wxc353.encs.concordia.ca";
$username = "wxc353_1";                         //"wxc353_1";
$password = "DBSU2020";                             //"";

try {
  $conn = new PDO("mysql:host=$servername;dbname=wxc353_1", $username, $password);                  //wxc353_1
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>