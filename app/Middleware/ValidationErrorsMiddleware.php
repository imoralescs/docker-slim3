<?php 

namespace App\Middleware;

class ValidationErrorsMiddleware extends Middleware
{
	public function __invoke($request, $response, $next)
	{

		// Grab errors from session after setted
		$this->c->view->getEnvironment()->addGlobal('errors', $_SESSION['errors']);

		// Delete from session after pull to display for user
		unset($_SESSION['errors']);

		$response = $next($request, $response);
		return $response;
	}
}