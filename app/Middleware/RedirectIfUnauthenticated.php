<?php

namespace App\Middleware;

// To used container
use Interop\Container\ContainerInterface;

use Slim\Interfaces\RouterInterface;

class RedirectIfUnauthenticated
{
	// Using ContainerInterface
	/*
	protected $c;

	public function __construct(ContainerInterface $c)
	{
			$this->c = $c;
	}
	*/

	// Using RouterInterface
	protected $router;

	public function __construct(RouterInterface $router)
	{
			$this->router = $router;
	}

	public function __invoke($request, $response, $next)
	{
		if(!isset($_SESSION['user_id'])){
			// Using ContainerInterface
			//$response = $response->withRedirect($this->c->router->pathFor('login'));

			// Using RouterInterface
			$response = $response->withRedirect($this->router->pathFor('login'));
		}

		return $next($request, $response);
	}
}
