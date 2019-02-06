<?php
  #used to connect to the databse
  $host = "uf63wl4z2daq9dbb.chr7pe7iynqr.eu-west-1.rds.amazonaws.com";
  $db_name = "b5c8mr62u90k1r87";
  $username = "lov2vb2cbeotxkhl";
  $password = "dkafbkunz5zwztu3";

  try {
      $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
      //echo "Connected";
  } catch (PDOException $e) {
    echo "Connection error: ". $e->getMessage();
  }
//changed database credentials to be able to upload on heroku.
 ?>

