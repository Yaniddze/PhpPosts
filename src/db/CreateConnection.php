<?php

function CreateConnection($config) {
  try {
    return new PDO(
      "mysql:host={$config['host']};port={$config['port']};dbname={$config['db']}",
      $config['login'],
      $config['password'],
      $config['opt']
    );
  }
  catch(PDOException $e) {
    die($e->getMessage());
  }
} 