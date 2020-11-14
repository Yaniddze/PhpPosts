<?php 
  require_once "./src/db/Connection.php";
  require_once "./src/validations/DescriptionValidation.php";
  require_once "./src/validations/TitleValidation.php";
  require_once "./src/validations/PhotoValidation.php";

  if (isset($_GET["id"]) && $_GET["id"] > 0) {
    $post = $postRepository->GetById($_GET["id"]);
  }

  if (isset($_POST['delete']) && isset($post)) {
    $result = $postRepository->Delete($_GET["id"]);

    if ($result > 0) {
      header('Location: index.php');
    } 
    else {
      $error = "Ошибка при удалении";
    }
  }

  if (isset($_POST['title']) && isset($post)) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $photo = $_POST['photo'];

    $titleValidation = ValidateTitle($title);
    $descriptionValidation = ValidateDescription($description);
    $photoValidation = ValidatePhoto($photo);

    if (!$titleValidation['valid']) {
      $error = $titleValidation['message'];
    }

    if (!$descriptionValidation['valid']) {
      $error = $descriptionValidation['message'];
    }

    if (!$photoValidation['valid']) {
      $error = $photoValidation['message'];
    }

    if (!isset($error)) {
      $result = $postRepository->Update([
        "id" => $_GET["id"],
        "title" => $title,
        "description" => $description,
        "photo" => $photo
      ]);

      if ($result > 0) {
        $success = 'Пост обновлен!';
        $post = $postRepository->GetById($_GET["id"]);
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
  <title>Edit post</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <h1>Обновление</h1>
    <div>
      <a 
        href="./index.php"
        class="m-1 btn btn-primary"
      >
        Домой
      </a>
    </div>
    <?php 

    
    if (isset($error)) {
      echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
    }

    if (isset($success)) {
      echo '<div class="alert alert-success" role="alert">'.$success.'</div>';
    }

    if (isset($post)) {

      echo '<form method="post">';

      echo '<div class="form-group">';
      echo '<label for="title-input">Название</label>';
      echo '<input name="title" value="'.$post["title"].'" class="form-control" id="title-input" />';
      echo '</div>';

      echo '<div class="form-group">';
      echo '<label for="description-input">Описание</label>';
      echo '<textarea name="description" class="form-control" id="description-input">'.$post["description"].'</textarea>';
      echo '</div>';

      echo '<div class="form-group">';
      echo '<label for="photo-input">Фото</label>';
      echo '<input name="photo" value="'.$post["photo"].'" class="form-control" id="photo-input" />';
      echo '</div>';

      echo '<button type="submit" class="btn btn-primary">Обновить</button>';

      echo '</form>';

      echo '<form class="mt-2" method="post">';
      echo '<button type="submit" class="btn btn-danger" name="delete">Удалить</button>';
      echo '</form>';
      
    } else {
      echo '<div class="alert alert-danger" role="alert">Невалидный id</div>';
    }
      
    ?>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>