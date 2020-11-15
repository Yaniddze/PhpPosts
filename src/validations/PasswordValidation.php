<?php

function ValidatePassword($pass) {
  if (is_null($pass)) {
    return [
      'valid' => false, 
      'message' => 'Пароль не может быть пустым'
    ];
  }

  if (mb_strlen($pass, 'utf8') <= 2) {
    return [
      'valid' => false, 
      'message' => 'Пароль слишком короткий (< 3 символов)'
    ];
  }

  return [
    'valid' => true 
  ];
}