<?php

class PostRepository {
  protected $pdo;

  public function __construct(PDO $pdo) {
    $this->pdo = $pdo;
  }

  public function Search($pattern) {
    $query = $this->pdo->prepare('SELECT * FROM posts WHERE title LIKE "%'.$pattern.'%"');
  
    if ($query->execute()) {
      return $query->fetchAll();
    }

    echo 'error';

    return null;
  }

  public function GetById($id) {
    $query = $this->pdo->prepare("SELECT * FROM posts WHERE id=:id ORDER BY created_time LIMIT 1");

    if ($query->execute([
      "id" => $id
    ])) {
      return $query->fetch();
    }

    return null;
  }

  public function GetAll() {
    $query = $this->pdo->prepare("SELECT * FROM posts ORDER BY created_time");

    if ($query->execute()) {
      return $query->fetchAll();
    }

    return null;
  }

  public function Insert($data) {
    $query = $this->pdo->prepare("INSERT INTO posts(title, description, created_time, photo, user_id) VALUES (:title, :description, :created_time, :photo, :user_id)");

    $execResult = $query->execute([
      "title" => $data["title"],
      "description" => $data["description"],
      "created_time" => date('Y-m-d H:i:s'),
      "photo" => $data["photo"],
      "user_id" => $data["user_id"]
    ]);

    if($execResult) {
      return $this->pdo->lastInsertId();
    }

    return -1;
  }

  public function Update($data) {
    $query = $this->pdo->prepare("UPDATE posts SET title=:title, description=:description, photo=:photo WHERE id=:id");

    $execResult = $query->execute($data);

    if ($execResult) {
      return 1;
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