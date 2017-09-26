<?php
  require '../vendor/autoload.php';

  // Test PHP Server Version
  // phpinfo();

  // Test Database Connection
  /*
  try {
    $dbh = new pdo(
      'mysql:host=mysql:3306;dbname=project',
      'project',
      'project',
      array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    die(json_encode(array('outcome:' => true)));
  }
  catch(PDOException $ex) {
    die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
  }
  */

  // Basic Slim Route
  $app = new \Slim\App([
    // Display Error Details - Include only for development.
    'settings' => [
      'displayErrorDetails' => true
    ]
  ]);

  // Slim Container - Is a Dependency Container, used for dependency injection.
  $container = $app->getContainer();

  $app->get('/', function(){
    echo 'Home';
  });

  $app->run();

?>
