<?php

namespace App\Middleware;

class CsrfViewMiddleware extends Middleware
{
	public function __invoke($request, $response, $next)
	{
		$request = $this->c->csrf->generateNewToken($request);

		$this->c->view->getEnvironment()->addGlobal('csrf', [
			'field' => '
				<input type="hidden" name="' . $this->c->csrf->getTokenNameKey() . '"
					value="' . $this->c->csrf->getTokenName() . '">
				<input type="hidden" name="' . $this->c->csrf->getTokenValueKey() . '"
					value="' . $this->c->csrf->getTokenValue() . '">
			'
		]);
		$response = $next($request, $response);
		return $response;
	}
}
