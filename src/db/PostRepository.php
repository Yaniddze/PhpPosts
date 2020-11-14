<?php

class PostRepository {
  protected $pdo;

  public function __construct(PDO $pdo) {
    $this->pdo = $pdo;
  }

  public function GetAll() {
    $query = $this->pdo->prepare("SELECT * FROM posts ORDER BY created_time");

    if ($query->execute()) {
      return $query->fetchAll();
    }

    return null;
  }

  public function Insert($data) {
    $query = $this->pdo->prepare("INSERT INTO posts(title, description, created_time, photo) VALUES (:title, :description, :created_time, :photo)");

    $execResult = $query->execute([
      "title" => $data["title"],
      "description" => $data["description"],
      "created_time" => date('Y-m-d H:i:s'),
      "photo" => $data["photo"],
    ]);

    if($execResult) {
      return $this->pdo->lastInsertId();
    }

    return -1;
  }

  public function Delete($id) {
    $query = $this->pdo->prepare("DELETE FROM posts WHERE id = :id");

    $execResult = $query->execute([
      "id" => $id
    ]);

    if($execResult) {
      return 1;
    }

    return -1;
  }
}