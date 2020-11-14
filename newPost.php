<?php 
  require_once "./src/db/Connection.php";

  if (isset($_POST['title'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $photo = $_POST['photo'];

    if (
      is_null($description) 
      || strlen($description) <= 3
    ) {
      $error = "Плохая ссылка на фото";
    }

    if (
      is_null($title) 
      || strlen($title) >= 30
      || strlen($title) <= 3
    ) {
      $error = "Плохое название";
    }

    if (
      is_null($photo) 
      || strlen($photo) >= 150
      || strlen($photo) <= 5
    ) {
      $error = "Плохая ссылка на фото";
    }

    if (!isset($error)) {
      $result = $postRepository->Insert($_POST);

      if ($result > 0) {
        $success = 'Пост добавлен!';
      } else {
        $error = 'Ошибка при добавлении';
      }
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>New posts</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <div>
      <a 
        href="./index.php"
        class="m-1 btn btn-primary"
      >
        Домой
      </a>
    </div>

    <form method="post">
      <?php 
        if (isset($error)) {
          echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
        }

        if (isset($success)) {
          echo '<div class="alert alert-success" role="alert">'.$success.'</div>';
        }
      ?>
      <div class="form-group">
        <label for="title-input">Название</label>
        <input name="title" type="text" class="form-control" id="title-input"/>
      </div>
      <div class="form-group">
        <label for="description-input">Описание</label>
        <textarea name="description" class="form-control" id="description-input"></textarea>
      </div>
      <div class="form-group">
        <label for="photo-input">Фото</label>
        <input name="photo" type="text" class="form-control" id="photo-input" />
      </div>
      <button type="submit" class="btn btn-primary">Добавить</button>
    </form>
  
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>