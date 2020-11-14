<?php

const tokenName = 'user_id';

function GetToken() {
  return $_COOKIE[tokenName];
}

function SetToken($token) {
  setcookie(tokenName, $token, time() + 60*60*24*30, "", "", false, true);
}

function DeleteToken() {
  setcookie(tokenName, "", time()-3600);
}