<?php

namespace App\Controllers;

use PDO;

class TopicController extends Controller
{
  public function index($request, $response)
  {
    $topics = $this->c->db_pdo->query("SELECT * FROM topics")->fetchAll(PDO::FETCH_OBJ);
    return $this->c->view->render($response, 'topics/index.twig', compact('topics'));
  }

  public function show($request, $response, $args)
  {
    $topic = $this->c->db_pdo->prepare("SELECT * FROM topics WHERE id = :id");
    $topic->execute([
      'id' => $args['id']
    ]);
    $topic = $topic->fetch(PDO::FETCH_OBJ);

    // Adding Not Found with 404 http code
    if($topic === false)
    {
      return $this->c->view->render($response->withStatus(404), 'errors/404.twig');
    }

    return $this->c->view->render($response, 'topics/show.twig', compact('topic'));
  }

  // Response on JSON
  public function api($request, $response)
  {
    $topics = $this->c->db_pdo->query("SELECT * FROM topics")->fetchAll(PDO::FETCH_OBJ);

    if($topics === false)
    {
      return $response->withHeader('Content-Type', 'application/json')->withStatus(404)->write(json_encode([
        'error' => 'That topic does not exist'
      ]));
    }

    return $response->withJson($topics, 200);
  }
}
