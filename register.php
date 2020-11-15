<?php 
  require_once "./src/db/Connection.php";
  require_once "./src/auth/CheckAuth.php";
  require_once "./src/validations/LoginValidation.php";
  require_once "./src/validations/PasswordValidation.php";

  if(CheckAuth($userRepository)) {
    header('Location: index.php');
  }

  if (isset($_POST["login"])) {
    $login = $_POST["login"];
    $password = $_POST["password"];
    $passwordConfirm = $_POST["password-confirm"];

    $loginValidation = ValidateLogin($login);
    $passwordValidation = ValidatePassword($password);

    if (!$loginValidation['valid']) {
      $error = $loginValidation['message'];
    }
    
    if (!$passwordValidation['valid']) {
      $error = $passwordValidation['message'];
    }

    if ($password != $passwordConfirm) {
      $error = 'Пароли не совпадают';
    }

    if (!isset($error)) {
      $exist = $userRepository->CheckExist($login);

      if ($exist) {
        $error = 'Пользователь с такими данными уже зарегистрирован';
      } else {
        $id = $userRepository->Insert([
          "login" => $login,
          "password" => $password,
        ]);
        
        SetToken($id);
        header('Location: index.php');
      }
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
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
        <label for="password-input">Password</label>
        <input name="password" type="password" class="form-control" id="password-input"/>
      </div>
      <div class="form-group">
        <label for="password-confirm-input">Password confirm</label>
        <input name="password-confirm" type="password" class="form-control" id="password-confirm-input"/>
      </div>

      <button type="submit" class="btn btn-primary">Регистрация</button>
      <a class="btn btn-primary" href="auth.php">Войти</a>
    </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>