<?php
  session_start();

  // Basic Slim Route
  $app = new \Slim\App([
  	'settings' => [
  		'displayErrorDetails' => true,
      // Used Eloquent
      'db' => [
        'driver' => 'mysql',
        'host' => 'mysql',
        'database' => 'name_db',
        'username' => 'user',
        'password' => 'password',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
      ]
  	],
  ]);

  // Slim Container - Is a Dependency Container, used for dependency injection.
  $container = $app->getContainer();

  // We are going to name this variable $capsule, this is the way laravel component.
  $capsule = new \Illuminate\Database\Capsule\Manager;
  $capsule->addConnection($container['settings']['db']);
  $capsule->setAsGlobal();
  $capsule->bootEloquent();

  // Installing Database to used PDO
  $container['db_pdo'] = function(){
    return new PDO('mysql:host=mysql;dbname=name_db','user','password');
  };

  // Installing Database to used Eloquent
  $container['db_elo'] = function($container) use ($capsule){
    return $capsule;
  };

  // Adding Validation to container
  $container['validator'] = function($container){
    return new App\Validation\Validator;
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

  // Middleware is for do some task before or after access to the main core app.
  $middleware = function($request, $response, $next){
    $response->getBody()->write('Before');
    $response = $next($request, $response);
    $response->getBody()->write('After');

    return $response;
  };

  require_once(__DIR__ .'/../routes/web.php');
