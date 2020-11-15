<?php

function PrintEditButton($id) {
  return "
    <a class='btn btn-primary mr-3' href='./edit.php?id=".$id."'>Редактировать</a>
  ";
}

function PrintDetailedButton($id) {
  return "
    <a class='btn btn-primary mr-3' href='./show.php?id=".$id."'>Подробнее</a>
  ";
}