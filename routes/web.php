<?php

	use App\Controllers\TopicController;
	use App\Models\User;

	// setName is to add name to route
	$app->get('/', function($request, $response){
		return $this->view->render($response, 'home.twig');
	})->setName('home');

	// Passing data to view without database
	/*
	$app->get('/users', function($request, $response){
		$userdetail = [
			'username' => 'SteveO',
			'name' => 'Steve OHaire',
			'email' => 'steveohaire@gmail.com'
		];

		return $this->view->render($response, 'users.twig',[
			'user' => 'Steve',
			'userdetail' => $userdetail
		]);
	})->setName('users.index');
	*/

	// Passing data to view with database
	$app->get('/users', function($request, $response){
		$users = $this->db->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);

		return $this->view->render($response, 'users.twig',[
			'users' => $users
		]);
	})->setName('users.index');

	// Route parameters without database
	/*
	$app->get('/users/{id}', function($request, $response, $args){
		// look user up in db
		$user = [
			'id' => $args['id'],
			'username' => 'Steve OHaire'
		];

		return $this->view->render($response, 'user.twig', compact('user'));
	});
	*/

	// Route parameters with database
	$app->get('/users/{id}', function($request, $response, $args){
		$user = $this->db->prepare("SELECT * FROM users WHERE id = :id");
		$user->execute([
			'id' => $args['id']
		]);

		$user = $user->fetch(PDO::FETCH_OBJ);
		return $this->view->render($response, 'user.twig', [
			'user' => $user
		]);
	});

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
	$app->group('/topics', function(){
		$this->get('', TopicController::class . ':index');
		$this->get('/{id}', TopicController::class . ':show')->setName('topics.show');
	});
