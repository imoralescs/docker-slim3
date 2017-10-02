<?php

namespace App\Controllers;

use PDO;
use App\Models\User;

class UserController extends Controller
{
  public function index($request, $response)
  {
  	// Query using PDO
    //$users = $this->c->db_pdo->query("SELECT * FROM users")->fetchAll(PDO::FETCH_CLASS, User::class);
    
    // Query using Eloquent
    //$user = $this->c->db_elo->table('users')->find(1);
    
    $user = User::where('email', 'alex.jones@gmail.com')->first();

    var_dump($user->email);
    die();
    return $this->c->view->render($response, 'users/index.twig', compact('users'));
  }
}
