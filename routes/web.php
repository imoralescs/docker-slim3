<?php

	use App\Controllers\TopicController;
	use App\Controllers\UserController;
	use App\Controllers\ExampleController;
	use App\Controllers\Auth\AuthController;
	use App\Controllers\Auth\PasswordController;

	// setName is to add name to route
	$app->get('/', function($request, $response){
		return $this->view->render($response, 'home.twig');
	})->setName('home');

	// Passing data to view without database
	/*
	$app->get('/customers', function($request, $response){
		$customers = array(
			array(
				"username" => "peterP_02",
				"email" => "peterparker@mail.com"
			),
			array(
				"username" => "clark_070",
				"email" => "clarkkent@mail.com"
			),
		);

		return $this->view->render($response, 'customers.twig',[
			'customers' => $customers,
		]);
	})->setName('customers.index');
	*/

	// Passing data to view with database
	$app->get('/customers', function($request, $response){
		$customers = $this->db_pdo->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);

		return $this->view->render($response, 'customers.twig',[
			'customers' => $customers
		]);
	})->setName('customers.index');

	// Route parameters without database
	/*
	$app->get('/customer/{id}', function($request, $response, $args){
		// look user up in db
		$customer = [
			'id' => $args['id'],
			'username' => 'Steve OHaire'
		];

		return $this->view->render($response, 'customer.twig', compact('customer'));
	});
	*/

	// Route parameters with database
	$app->get('/customer/{id}', function($request, $response, $args){
		$customer = $this->db->prepare("SELECT * FROM users WHERE id = :id");
		$customer->execute([
			'id' => $args['id']
		]);

		$customer = $customer->fetch(PDO::FETCH_OBJ);
		return $this->view->render($response, 'customer.twig', [
			'user' => $customer
		]);
	});

	// Redirect and Post
	$app->get('/contact', function($request, $response){
		return $this->view->render($response, 'contact.twig');
	})->setName('contact');

	$app->post('/contact', function($request, $response){
		// Getting request data
		// echo $request->getParam('email');

		// Redirect after post
		return $response->withRedirect('contact/confirm');
	})->setName('contact');

	$app->get('/contact/confirm', function($request, $response){
		return $this->view->render($response, 'contact_confirm.twig');
	})->setName('contact.confirm');

	// Route Groups
	// Without controller
	/*
	$app->group('/topics', function(){
		$this->get('', function(){
			echo 'Topic list';
		});

		$this->get('/{id}', function($request, $response, $args){
			echo 'Topic ' . $args['id'];
		});

		$this->post('', function(){
			echo 'Post topic';
		});
	});
	*/

	// With controller
	/*
	$app->group('/topics', function(){
		$this->get('', TopicController::class . ':index');
		$this->get('/api', TopicController::class . ':api');
		$this->get('/{id}', TopicController::class . ':show')->setName('topics.show');
	});
	*/

	// Route for controller with model
	$app->group('/users', function(){
		$this->get('', UserController::class . ':index');
	});

	// Redirect
	$app->get('/redirect', ExampleController::class . ':redirect');
	$app->get('/landing', ExampleController::class . ':landing')->setName('landing');

	// Redirect with params
	$app->get('/store', ExampleController::class . ':store');
	$app->get('/show/{id}', ExampleController::class . ':show')->setName('show');

	// Route with middleware
	/*
	$authenticated = function($request, $response, $next) use ($container) {
		if(!isset($_SESSION['user_id'])){
			$response = $response->withRedirect($container->router->pathFor('login'));
		}

		return $next($request, $response);
	};
	*/

	// Middleware with route
	use App\Middleware\RedirectIfUnauthenticated;
	use App\Middleware\AuthMiddleware;
	use App\Middleware\GuestMiddleware;

	//$app->get('/topics', TopicController::class . ':index')->add($middleware);
	//$app->get('/topics/api', TopicController::class . ':api');
	//$app->get('/topics/{id}', TopicController::class . ':show')->add($authenticated)->setName('topics.show');

	// Using ContainerInterface
	// $app->get('/topics/{id}', TopicController::class . ':show')->add(new RedirectIfUnauthenticated($container))->setName('topics.show');

	// Using RouterInterface
	//$app->get('/topics/{id}', TopicController::class . ':show')->add(new RedirectIfUnauthenticated($container['router']))->setName('topics.show');

	// Adding Middleware to group routes
	$app->group('/topics', function(){
		$this->get('', TopicController::class . ':index');
		$this->get('/{id}', TopicController::class . ':show')->setName('topics.show');
	})->add(new RedirectIfUnauthenticated($container['router']));

	$app->get('/login', function(){
		return 'Login';
	})->setName('login');

	//--* Authentication routes

	// If you are login in
	$app->group('', function(){
		// Sign up
		$this->get('/auth/signup', AuthController::class . ':getSignUp')->setName('auth.signup');
		$this->post('/auth/signup', AuthController::class . ':postSignUp');

		// Sign in
		$this->get('/auth/signin', AuthController::class . ':getSignIn')->setName('auth.signin');
		$this->post('/auth/signin', AuthController::class . ':postSignIn');
	})->add(new GuestMiddleware($container));

	// If you are not login in
	$app->group('', function(){
		// Sign out route
		$this->get('/auth/signout', AuthController::class . ':getSignOut')->setName('auth.signout');

		// Change password route
		$this->get('/auth/password/change', PasswordController::class . ':getChangePassword')->setName('auth.password.change');
		$this->post('/auth/password/change', PasswordController::class . ':postChangePassword');
	})->add(new AuthMiddleware($container));
