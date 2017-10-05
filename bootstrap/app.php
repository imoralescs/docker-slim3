<?php
  session_start();

  use Respect\Validation\Validator as v;



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

  // Installing CSRF
  $container['csrf'] = function($container){
    return new \Slim\Csrf\Guard;
  };

  // Installing View Container (Twig)
  $container['view'] = function($container){
    $view = new \Slim\Views\Twig(__DIR__ . "/../resources/views",[
      'cache' => false
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));
    $view->addExtension(new App\Views\CsrfExtension($container['csrf']));

    return $view;
  };



  //-- Middleware with container.
  // Middleware is for do some task before or after access to the main core app.
  $middleware = function($request, $response, $next){
    $response->getBody()->write('Before');
    $response = $next($request, $response);
    $response->getBody()->write('After');

    return $response;
  };

  // Csrf protector
  //$app->add(new \App\Middleware\CsrfViewMiddleware($container));

  // Form validation
  $app->add(new \App\Middleware\ValidationErrorsMiddleware($container));

  // Persisting form data
  $app->add(new \App\Middleware\OldInputMiddleware($container));

  // Allow custom validation rules
  v::with('App\\Validation\\Rules\\');

  $app->add($container->get('csrf'));

  require_once(__DIR__ .'/../routes/web.php');
