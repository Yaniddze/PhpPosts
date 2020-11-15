<?php 
  require_once "./src/db/Connection.php";
  require_once "./src/auth/CheckAuth.php";
  require_once "./src/validations/DescriptionValidation.php";
  require_once "./src/validations/TitleValidation.php";
  require_once "./src/validations/PhotoValidation.php";
  require_once "./src/printers/Alerts.php";
  require_once "./src/printers/EditForm.php";

  if (!CheckAuth($userRepository)) {
    header('Location: auth.php');
  }

  if(isset($_POST["exit"])) {
    DeleteToken();

    header('Location: auth.php');
  }

  if (isset($_GET["id"]) && $_GET["id"] > 0) {
    $tempPost = $postRepository->GetById($_GET["id"]);

    if (is_null($tempPost)) {
      $error = 'Пост не найден';
    } else {
      if ($tempPost["user_id"] == GetToken()) {
        $post = $tempPost;
      } else {
        $error = "Это не ваш пост";
      }
    }
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
    <form class="float-right m-1" method="post">
      <button type="submit" name="exit" class="btn btn-danger">Выйти</button>
    </form>
    <h1>Обновление</h1>
    <div>
      <a 
        href="./index.php"
        class="m-1 btn btn-primary"
      >
        Домой
      </a>
      <a 
        <?php echo 'href="./show.php?id='.$_GET["id"].'"'; ?>
        class="m-1 btn btn-primary"
      >
        Просмотр
      </a>
    </div>
  
    <?php 

    
    if (isset($error)) {
      echo PrintError($error);
    }

    if (isset($success)) {
      echo PrintSuccess($success);
    }

    if (isset($post)) {

      echo PrintEditForm(
        $post['title'],
        $post['description'],
        $post['photo']
      );
      
    } else {
      echo PrintError('Невалидный id');
    }
      
    ?>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>