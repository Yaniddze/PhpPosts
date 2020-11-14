<?php

class UserRepository {
  protected $pdo;

  public function __construct(PDO $pdo) {
    $this->pdo = $pdo;
  }

  public function GetById($id) {
    $query = $this->pdo->prepare("SELECT * FROM users WHERE id=:id LIMIT 1");

    if ($query->execute([
      "id" => $id
    ])) {
      return $query->fetch();
    }

    return null;
  }

  public function GetByLoginAndPass($login, $pass) {
    $query = $this->pdo->prepare("SELECT * FROM users WHERE login=:login AND password=:password LIMIT 1");

    if ($query->execute([
      "login" => $login,
      "password" => $pass
    ])) {
      return $query->fetch();
    }

    return null;
  }

  public function GetAll() {
    $query = $this->pdo->prepare("SELECT * FROM users ORDER BY id");

    if ($query->execute()) {
      return $query->fetchAll();
    }

    return null;
  }

  public function Insert($data) {
    $query = $this->pdo->prepare("INSERT INTO users(login, password) VALUES (:login, :password)");

    $execResult = $query->execute([
      "login" => $data["login"],
      "password" => $data["password"]
    ]);

    if($execResult) {
      return $this->pdo->lastInsertId();
    }

    return -1;
  }

  public function Update($data) {
    $query = $this->pdo->prepare("UPDATE users SET login=:login, password=:password WHERE id=:id");

    $execResult = $query->execute($data);

    if ($execResult) {
      return 1;
    }

    return -1;
  }

  public function Delete($id) {
    $query = $this->pdo->prepare("DELETE FROM users WHERE id = :id");

    $execResult = $query->execute([
      "id" => $id
    ]);

    if($execResult) {
      return 1;
    }

    return -1;
  }
}