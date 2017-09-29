<?php 

namespace App\Middleware;

class RedirectIfUnauthenticated
{
	public function __invoke($request, $response, $next) 
	{
		if(!isset($_SESSION['user_id'])){
			$response = $response->withRedirect($container->router->pathFor('login'));
		}

		return $next($request, $response);
	}
}