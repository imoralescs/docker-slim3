<?php 

namespace App\Middleware;

use App\Models\User;

use \Slim\Middleware\HttpBasicAuthentication\AuthenticatorInterface;

class BasicAuthenticationMiddleware implements AuthenticatorInterface
{
	public function __invoke(array $arguments)
	{
		// Testing purpose
		/*
		$user = $arguments['user'];
		$password = $arguments['password'];

		if($user == 'admin' && $password=="123456"){
			return true;
		}
		else{
			return false;
		}
		*/

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