<?php 

  // Basic Slim Route
  $app = new \Slim\App([
  	'settings' => [
  		'displayErrorDetails' => true
  	]
  ]);

  // Slim Container - Is a Dependency Container, used for dependency injection.
  $container = $app->getContainer();

  // Installing Database
  $container['db'] = function(){
    return new PDO('mysql:host=mysql;dbname=name_db','user','password');
  };

  // Installing View Container (Twig)
  $container['view'] = function($container){
    $view = new \Slim\Views\Twig(__DIR__ . "/../resources/views",[
      'cache' => false
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
  };

  require_once(__DIR__ .'/../routes/web.php');
