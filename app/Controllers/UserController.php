<?php

namespace App\Controllers;

use PDO;
use App\Models\User;

class UserController extends Controller
{
  public function index($request, $response)
  {
    //$users = $this->c->db->query("SELECT * FROM users")->fetchAll(PDO::FETCH_CLASS, User::class);
    $user = $this->c->db->table('users')->find(1);
    var_dump($user->email);
    die();
    return $this->c->view->render($response, 'users/index.twig', compact('users'));
  }
}
