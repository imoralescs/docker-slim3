<?php

namespace App\Middleware;

class AuthenticationMiddleware extends Middleware
{
	public function __invoke($request, $response, $next)
	{

    // Check if the user is not signed in
    if(!$this->c->auth->check()){
      // TODO: Flash message

      // Redirect to signin form
      return $response->withRedirect($this->c->router->pathFor('auth.signin'));
    }

		$response = $next($request, $response);
		return $response;
	}
}
