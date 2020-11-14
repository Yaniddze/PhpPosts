<?php 
  require_once "./src/auth/CheckAuth.php";
  require_once "./src/validations/LoginValidation.php";
  require_once "./src/validations/PasswordValidation.php";

  if(CheckAuth()) {
    header('Location index.php');
  }

  if (isset($_POST["login"]) {
    $login = $_POST["login"];
    $password = $_POST["password"];

    $loginValidation = ValidateLogin($login);
    $passwordValidation = ValidatePassword($password);

    if (!$loginValidation['valid']) {
      $error = $loginValidation['message'];
    }
    
    if (!$passwordValidation['valid']) {
      $error = $passwordValidation['message'];
    }

    if (!isset($error)) {
      $foundUser = $userRepository->GetByLoginAndPass($login, $password);

      if (is_null($foundUser)) {
        $error = 'Пользователь с такими данными не найден';
      } else {
        SetToken($foundUser["id"]);
        header('Location index.php');
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
    <form method="post">
      <?php 
        if (isset($error)) {
          echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
        }
      ?>
      <div class="form-group">
        <label for="login-input">Login</label>
        <input name="login" type="text" class="form-control" id="login-input"/>
      </div>
      <div class="form-group">
        <label for="password-input">Login</label>
        <input name="password" type="password" class="form-control" id="password-input"/>
      </div>
    </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>