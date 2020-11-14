<?php 
  require_once "./src/db/Connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Posts</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <div>
      <a 
        href="./newPost.php"
        class="m-1 btn btn-primary"
      >
        Добавить пост
      </a>
    </div>
    <?php 
      $posts = $postRepository->GetAll();


      foreach ($posts as $post) {
        echo '<div class="card m-3">';

        echo '<img width="200px" src='.$post['photo'].' class="card-img-top" alt="Пост" />';
        
        echo '<div class="card-body">';

        echo '<h5 class="cart-title">'.$post['title'].'</h5>';
        echo '<p class="card-text">'.$post['description'].'</p>';
        echo '<a class="btn btn-primary mr-3" href="./edit.php?id='.$post["id"].'">Обновить</a>';
        echo '<a class="btn btn-danger">Удалить</a>';

        echo '</div>';

        echo '</div>';
      }

    ?>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>