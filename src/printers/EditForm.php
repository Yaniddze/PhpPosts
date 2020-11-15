<?php

function PrintEditForm(
  $title,
  $text,
  $photo
){
  return "
    <form method='post' enctype='multipart/form-data'>

      <div class='form-group'>
        <label for='title-input'>Название</label>
        <input name='title' value='".$title."' class='form-control' id='title-input' />
      </div>

      <div class='form-group'>
        <label for='description-input'>Описание</label>
        <textarea name='description' class='form-control' id='description-input'>".$text."</textarea>
      </div>

      <div class='form-group'>
        <label for='photo-input'>Фото</label>
        <input name='photo' type='file' class='form-control' id='photo-input' />
      </div>
      
      <div>
        <img src='/imgs/".$photo."' alt='Пост' />
      </div>

      <button type='submit' class='btn btn-primary mt-4'>Обновить</button>

    </form>

    <form class='mt-2' method='post'>
      <button type='submit' class='btn btn-danger' name='delete'>Удалить</button>
    </form>
  ";
}