<?php

namespace App\Controllers;

use PDO;

class ExampleController extends Controller
{
  public function redirect($request, $response)
  {
    return $response->withRedirect($this->c->router->pathFor('landing'));
  }

  public function landing($request, $response)
  {
    return 'To Here';
  }

  public function store($request, $response)
  {
    return $response->withRedirect($this->c->router->pathFor('show', ['id' => 5]));
  }

  public function show($request, $response, $args)
  {
    return 'Show ' . $args['id'];
  }
}
