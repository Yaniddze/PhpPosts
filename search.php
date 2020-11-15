<?php 
  require_once "./src/db/Connection.php";
  require_once "./src/auth/CheckAuth.php";
  require_once "./src/printers/Article.php";

  if (!CheckAuth($userRepository)) {
    header('Location: auth.php');
  }

  if(isset($_POST["exit"])) {
    DeleteToken();

    header('Location: auth.php');
  }

  $pattern = $_GET["pattern"];

  if (!isset($pattern) || strlen($pattern) == 0) {
    header('Location: index.php');
  }
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

    <form class="float-right m-1" method="post">
      <button type="submit" name="exit" class="btn btn-danger">Выйти</button>
    </form>
    <form>
      <div class="d-flex mb-5">
        <input name="pattern" value="<?php echo $pattern; ?>" placeholder="Поиск..." />
        <button class="btn btn-primary ml-2">Найти</button>
      </div>
    </form>
    <div>
      <a 
        href="./index.php"
        class="m-1 btn btn-primary"
      >
        Домой
      </a>
    </div>
    <div class="row row-cols-2">
      
      <?php 
        $posts = $postRepository->Search($pattern);

        if ($posts != null) {
          foreach ($posts as $post) {
            echo PrintArticle(
              $post["id"], 
              $post["user_id"] == GetToken(),
              $post["photo"],
              $post["title"],
              $post["description"]
            );
          }
        }
      ?>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>