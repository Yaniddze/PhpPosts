<?php

function ValidateTitle($title) {
  if (is_null($title)) {
    return [
      'valid' => false, 
      'message' => 'Название не может быть пустым'
    ];
  }

  if (mb_strlen($title, 'utf8') >= 30) {
    return [
      'valid' => false, 
      'message' => 'Название слишком длинное (> 30 символов)'
    ];
  }

  if (mb_strlen($title, 'utf8') <= 3) {
    return [
      'valid' => false, 
      'message' => 'Название слишком короткое (< 3 символов)'
    ];
  }

  return [
    'valid' => true 
  ];
}