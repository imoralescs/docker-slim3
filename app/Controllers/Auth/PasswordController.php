<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\User;
use Respect\Validation\Validator as v;

class PasswordController extends Controller
{
  public function getChangePassword($request, $response)
  {
    return $this->c->view->render($response, 'auth/password/change.twig');
  }

  public function postChangePassword($request, $response)
  {
    $validation = $this->c->validator->validate($request, [
        'password_old' => v::noWhitespace()->notEmpty()->matchesPassword($this->c->auth->user()->password),
        'password' => v::noWhitespace()->notEmpty(),
    ]);

    if($validation->failed()){
      return $response->withRedirect($this->c->router->pathFor('auth.password.change'));
    }

    $this->c->auth->user()->setPassword($request->getParam('password'));

    return $response->withRedirect($this->c->router->pathFor('home'));
  }
}
