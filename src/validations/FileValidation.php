<?php

function ValidateFile($file) {
  $availableExtensions = ['jpg', 'png'];
  
  if ($file == null) {
    return [
      'valid' => false,
      'message' => 'Файл не может быть пустым'
    ];
  }

  if ($file['size'] >= 5000000) {
    return [
      'valid' => false,
      'message' => 'Файл слишком большой'
    ];
  }

  $extension = strtolower(end(explode('.', $file['name'])));

  if (!in_array($extension, $availableExtensions)) {
    return [
      'valid' => false,
      'message' => 'Недопустимое расширение'
    ];
  }

  return [
    'valid' => true
  ];
}