<?php 
  require_once "./src/CheckAuth.php";
  require_once "./src/db/Connection.php";
  require_once "./src/validations/CommentValidation.php";

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
      $post = $tempPost;
    }
  }

  if (isset($post) && isset($_POST["comment"])) {
    $comment = $_POST["comment"];

    $commentValidation = ValidateComment($comment);

    if (!$commentValidation["valid"]) {
      $error = $commentValidation["message"];
    }

    if (!isset($error)) {
      $commentRepository->Insert([
        "post_id" => $post["id"],
        "author_id" => GetToken(),
        "text" => $comment,
      ]);
    }
  }
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Show post</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
  <div class="container">

    <form class="float-right m-1" method="post">
      <button type="submit" name="exit" class="btn btn-danger">Выйти</button>
    </form>
    <h1>Пост</h1>
    <div>
      <a 
        href="./index.php"
        class="m-1 btn btn-primary"
      >
        Домой
      </a>
      <?php 
      
      if (isset($post)) {
        if ($post["user_id"] == GetToken()) {
          echo '<a href="./edit.php?id='.$_GET["id"].'" class="m-1 btn btn-primary" >';
          echo 'Редактировать';
          echo '</a>';
        }
      }    

      ?>
    </div>

    <?php 

      if (isset($error)) {
        echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
      }

      if (isset($post)) {
        echo '<div>';

          echo '<div>';
            echo '<img src="'.$post["photo"].'" />';
          echo '</div>';

          echo '<div>';
            echo '<h1>'.$post["title"].'</h1>';
          echo '</div>';

          echo '<div>';
            echo $post["created_time"];
          echo '</div>';

          echo '<div style="word-wrap:break-word;">';
            echo $post["description"];
          echo '</div>';

        echo '</div>';
        
      } else {
        echo '<div class="alert alert-danger" role="alert">Невалидный id</div>';
      }

    ?>
    <div>
      <h2>Комментарии</h2>
      <form method="post" class="mb-4">
        <div class="form-group">
          <label for="comment-input">Оставьте свой комментарий</label>
          <textarea name="comment" class="form-control" id="comment-input"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">
          Отправить
        </button>
      </form>
      <?php 
        if (isset($post)) {
          $comments = $commentRepository->GetByPost($post["id"]);

          if ($comments != null) {
            foreach($comments as $comment) {
              echo '<div>';
  
              echo '<div class="d-flex">';
                echo '<h4>'.$comment["login"].'</h4>';
                echo '<div class="ml-2 mt-1">'.$comment["time"].'</div>';
              echo '</div>';
              echo '<p style="word-wrap:break-word;">'.$comment["text"].'</p>';
    
              echo '</div>';
            }
          }          
        }
      ?>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>