<?php
  // Test PHP Server Version
  // phpinfo();

  // Test Database Connection
  /*
  try {
    $dbh = new PDO(
      'mysql:host=mysql;dbname=name_db',
      'user',
      'password',
      array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    die(json_encode(array('outcome:' => true)));
  }
  catch(PDOException $ex) {
    die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
  }
  */

  require __DIR__ . '/../vendor/autoload.php';

  require __DIR__ . '/../bootstrap/app.php';
  
  $app->run();
