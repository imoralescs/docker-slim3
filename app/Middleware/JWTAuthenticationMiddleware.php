<?php 

namespace App\Middleware;

use \Firebase\JWT\JWT;
use \Slim\Middleware\HttpBasicAuthentication\AuthenticatorInterface;

class JWTAuthenticationMiddleware implements AuthenticatorInterface
{
	public function __invoke(array $arguments)
	{
		$user = $arguments['user'];
		$password = $arguments['password'];

		if($user == 'admin' && $password=="123456"){
			return true;
		}
		else{
			return false;
		}
	}
}