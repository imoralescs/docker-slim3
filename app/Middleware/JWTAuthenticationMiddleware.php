<?php 

namespace App\Middleware;

use App\Models\User;
use \Firebase\JWT\JWT;
use \Slim\Middleware\HttpBasicAuthentication\AuthenticatorInterface;

class JWTAuthenticationMiddleware implements AuthenticatorInterface
{
	public function __invoke(array $arguments)
	{
		// Grab user data
		$email = $arguments['user'];
		$password = $arguments['password'];

		// Grab the user by email
		$user = User::where('email', $email)->first();

		// If !user return false
		if(!$user){
			return false;
		}

		// Verify password for that user
		if(password_verify($password, $user->password)){
			return true;
		}

		return false;
	}
}