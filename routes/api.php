<?php 
	// Used for basic authentication
	$app->get('/admin', function($request, $response){
		return $response->withJson("success", 200);
	});

	// Used for jwt authentication - get token
	$app->get('/getjwttoken', function($request, $response){
		$apijwt = $this->jwt;

		$now = new DateTime();
		$future = new DateTime("now +1 minutes");

		$payload = [
			"iat" => $now->getTimeStamp(),
			"exp" => $future->getTimeStamp(),
			"sub" => "Test for JWT",
		];

		$secret = "supersecretkeyyoushouldnotcommit";
		$token = $apijwt->encode($payload, $secret, "HS512");
		$data["token"] = $token;

		return $response->withStatus(201)->withHeader("Content-Type", "application/json")->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	});

	// Used for basic authentication - secure by jwt
	/*
	 * To test this after get token:
	 * POSTMAN
	 * Headers
	 * key : Authorization value: Bearer AndTokenCode
	 *
	 * By default after 1 minutes, token will be expire.
	 */
	$app->get('/getservicebyjwt', function($request, $response){
		return $response->withJson("success", 200);
	});

	// Used Basic HTTP Auth with JWT
	$app->get('/gettoken', function($request, $response){
		$apijwt = $this->jwt;

		$now = new DateTime();
		$future = new DateTime("now +12 hour");

		$payload = [
			"iat" => $now->getTimeStamp(),
			"exp" => $future->getTimeStamp(),
			"sub" => $SERVER["PHP_AUTH_USER"],
		];

		$secret = "supersecretkeyyoushouldnotcommit";
		$token = $apijwt->encode($payload, $secret, "HS512");
		$data["token"] = $token;

		return $response->withStatus(201)->withHeader("Content-Type", "application/json")->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	});