<?php

function PrintSuccess($text) {
  return "
    <div class='alert alert-success' role='alert'>".$text."</div>
  ";
}

function PrintError($text) {
  return "
    <div class='alert alert-danger' role='alert'>".$text."</div>
  ";
}