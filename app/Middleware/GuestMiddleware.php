<?php

namespace App\Middleware;

class GuestMiddleware extends Middleware
{
	public function __invoke($request, $response, $next)
	{

    // Check if the user is signed in
    if($this->c->auth->check()){
      // TODO: Flash message

      // Redirect to home
      return $response->withRedirect($this->c->router->pathFor('home'));
    }

		$response = $next($request, $response);
		return $response;
	}
}
