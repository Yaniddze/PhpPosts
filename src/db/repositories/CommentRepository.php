<?php

class CommentRepository {
  protected $pdo;

  public function __construct(PDO $pdo) {
    $this->pdo = $pdo;
  }

  public function GetByPost($id) {
    $query = $this->pdo->prepare("SELECT comments.text AS text, comments.create_time as time, users.login AS login FROM comments INNER JOIN users ON comments.author_id = users.id WHERE comments.post_id = :id");

    $execResult = $query->execute([
      "id" => $id,
    ]);

    if($execResult) {
      return $query->fetchAll();
    }

    return null;
  }

  public function Insert($data) {
    $query = $this->pdo->prepare("INSERT INTO comments(post_id, author_id, text, create_time) VALUES (:post_id, :author_id, :text, :create_time)");

    $execResult = $query->execute([
      "post_id" => $data['post_id'],
      "author_id" => $data['author_id'],
      "text" => $data['text'],
      "create_time" => date('Y-m-d H:i:s')
    ]);

    if($execResult) {
      return $this->pdo->lastInsertId();
    }

    return -1;
  }
}