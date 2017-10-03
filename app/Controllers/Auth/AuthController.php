<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\User;
use Respect\Validation\Validator as v;

class AuthController extends Controller
{
  public function getSignUp($request, $response)
  {
    return $this->c->view->render($response, 'auth/signup.twig');
  }

  public function postSignUp($request, $response)
  {
    //var_dump($request->getParams());

    // Persisting form data
    //$_SESSION['old'] = $request->getParams();

    // Validate data
    $validation = $this->c->validator->validate($request, [
      'firstname' => v::notEmpty()->alpha(),
      'lastname' => v::notEmpty()->alpha(),
      'username' => v::noWhitespace()->notEmpty(),
      'email' => v::noWhitespace()->notEmpty()->email()->EmailAvailable(),
      'password' => v::noWhitespace()->notEmpty(),
    ]);

    // Redirect to form if fail validation
    if($validation->failed()){
      return $response->withRedirect($this->c->router->pathFor('auth.signup'));
    }

    // Add to database
    $user = User::create([
      'firstname' => $request->getParam('firstname'),
      'lastname' => $request->getParam('lastname'),
      'username' => $request->getParam('username'),
      'email' => $request->getParam('email'),
      'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT)
    ]);

    return $response->withRedirect($this->c->router->pathFor('home'));
  }
}
