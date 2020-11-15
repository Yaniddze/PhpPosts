<?php 
  require_once "./src/auth/CheckAuth.php";
  require_once "./src/db/Connection.php";
  require_once "./src/printers/Alerts.php";
  
  require_once "./src/auth/AuthStorage.php";

  require_once "./src/validations/DescriptionValidation.php";
  require_once "./src/validations/TitleValidation.php";
  require_once "./src/validations/PhotoValidation.php";
  require_once "./src/validations/FileValidation.php";

  require_once "./src/UploadImage.php";
  
  if (!CheckAuth($userRepository)) {
    header('Location: auth.php');
  }

  if(isset($_POST["exit"])) {
    DeleteToken();

    header('Location: auth.php');
  }
  
  if (isset($_POST['title'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $photo = $_FILES['photo'];

    $titleValidation = ValidateTitle($title);
    $descriptionValidation = ValidateDescription($description);
    $fileValidation = ValidateFile($photo);

    if (!$titleValidation['valid']) {
      $error = $titleValidation['message'];
    }

    if (!$descriptionValidation['valid']) {
      $error = $descriptionValidation['messsage'];
    }

    if (!$fileValidation['valid']) {
      $error = $fileValidation['message'];
    }

    if (!isset($error)) {
      $filename = UploadImage($photo);

      $result = $postRepository->Insert([
        "title" => $title,
        "description" => $description,
        "photo" => $filename,
        "user_id" => GetToken()
      ]);

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

    <form class="float-right m-1" method="post">
      <button type="submit" name="exit" class="btn btn-danger">Выйти</button>
    </form>
    <h1>Добавление</h1>
    <div>
      <a 
        href="./index.php"
        class="m-1 btn btn-primary"
      >
        Домой
      </a>
    </div>

    <form method="post" enctype="multipart/form-data">
      <?php 
        if (isset($error)) {
          echo PrintError($error);
        }

        if (isset($success)) {
          echo PrintSuccess($success);
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
        <input name="photo" type="file" class="form-control" id="photo-input" />
      </div>
      <button type="submit" class="btn btn-primary">Добавить</button>
    </form>
  
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>