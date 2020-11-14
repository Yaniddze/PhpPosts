<?php

require_once 'AuthStorage.php';
require_once dirname(__FILE__).'/../db/Connection.php';

function CheckAuth() {
  $id = GetToken();

  if (is_null($id)) {
    return false;
  }

  $foundUser = $userRepository->GetById($id);

  return !is_null($foundUser);
}