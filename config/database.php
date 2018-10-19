<?php
  #used to connect to the databse
  $host = "localhost";
  $db_name = "hr_";
  $username = "root";
  $password = "";

  try {
      $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
      //echo "Connected";
  } catch (PDOException $e) {
    echo "Connection error: ". $e->getMessage();
  }

 ?>
