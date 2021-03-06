<?php

function ValidateDescription($description) {
  if (is_null($description)) {
    return [
      'valid' => false, 
      'message' => 'Описание не может быть пустым'
    ];
  }

  if (mb_strlen($description, 'utf8') <= 3) {
    return [
      'valid' => false, 
      'message' => 'Название слишком короткое (< 3 символов)'
    ];
  }

  return [
    'valid' => true 
  ];
}