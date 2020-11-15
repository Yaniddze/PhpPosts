<?php

function ValidateComment($comment){
  if (is_null($comment)) {
    return [
      'valid' => false, 
      'message' => 'Комментарий не может быть пустым'
    ];
  }

  if (mb_strlen($comment, 'utf8') <= 3) {
    return [
      'valid' => false, 
      'message' => 'Комментарий слишком короткий (< 3 символов)'
    ];
  }

  return [
    'valid' => true 
  ];
}