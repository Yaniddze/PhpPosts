<?php

function ValidateLogin($login) {
  if (is_null($login)) {
    return [
      'valid' => false, 
      'message' => 'Логин не может быть пустым'
    ];
  }

  if (mb_strlen($login, 'utf8') <= 2) {
    return [
      'valid' => false, 
      'message' => 'Логин слишком короткий (< 3 символов)'
    ];
  }

  return [
    'valid' => true 
  ];
}