<?php

require_once 'AuthStorage.php';

function CheckAuth($userRepo) {
  $id = GetToken();

  if ($id == null) {
    return false;
  }

  $foundUser = $userRepo->GetById($id);

  return $foundUser != null;
}