<?php

function UploadImage($file){

  $filename = $file['name'];
  $extension = strtolower(end(explode('.', $filename)));

  $guid = bin2hex(openssl_random_pseudo_bytes(16));
  $newName = $guid.'.'.$extension;
  echo __FILE__;
  $dir = str_replace("src\UploadImage.php", "imgs\\", __FILE__);

  move_uploaded_file($file['tmp_name'], $dir.$newName);

  return $newName;
    
}