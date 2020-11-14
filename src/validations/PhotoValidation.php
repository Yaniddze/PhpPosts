<?php

function ValidatePhoto($photo) {
  if (is_null($photo)) {
    return [
      'valid' => false, 
      'message' => 'Фото не может быть пустым'
    ];
  }

  if (strlen($photo) >= 150) {
    return [
      'valid' => false, 
      'message' => 'Фото слишком длинное (> 150 символов)'
    ];
  }

  if (strlen($photo) <= 3) {
    return [
      'valid' => false, 
      'message' => 'Фото слишком короткое (< 3 символов)'
    ];
  }

  return [
    'valid' => true 
  ];
}