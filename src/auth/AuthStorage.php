<?php

const tokenName = 'user_id';

function GetToken() {
  return $_COOKIE[tokenName];
}

function SetToken($token) {
  setcookie(tokenName, $token, [
    'httponly' => true,
    'expires' => time() + 60*60*24*30
  ]);
}