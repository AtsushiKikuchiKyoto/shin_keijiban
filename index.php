<!-- http://localhost/shin_keijiban/ -->
<!-- http://localhost/phpmyadmin/ -->

  <?php
ini_set('display_errors', "On");
$comment_array = array();
$dbh = null;
$stmt = null;

// input DB
if(isset($_POST["submitButton"])){
  if(empty($_POST["username"]) or empty($_POST["comment"])){
    echo "名前またはコメントが空です。";
  } else {
    try {
      $postDate = date("Y-m-d H:i:s");
      $dbh = new PDO('mysql:host=localhost;dbname=shin_keijiban', "root", "");
      $stmt = $dbh->prepare("INSERT INTO `keijiban` (`username`, `comment`, `postDate`) VALUES (:username, :comment, :postDate)");
      $stmt->bindParam(':username', htmlentities($_POST["username"]));
      $stmt->bindParam(':comment', nl2br(htmlspecialchars($_POST["comment"], ENT_QUOTES, 'utf-8')), PDO::PARAM_STR);
      $stmt->bindParam(':postDate', $postDate, PDO::PARAM_STR);
      
      $stmt->execute();
      $dbh = null;

      // フォーム送信後リダイレクト
      header("Location: " . $_SERVER['PHP_SELF']);
      exit;
    } catch (PDOException $e) {
      echo $e->getMessage();
    };
  };
};

// delete
if(!empty($_POST["deleteButton"])){
  try {
    $id = $_POST["id"];
    $dbh = new PDO('mysql:host=localhost;dbname=shin_keijiban', "root", "");
    $stmt = $dbh->prepare("DELETE FROM `keijiban` WHERE id=:id");
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $dbh = null;

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

// output DB
try {
  $dbh = new PDO('mysql:host=localhost;dbname=shin_keijiban', "root", "");
  $sql = "SELECT * FROM keijiban ";
  $comment_array = $dbh->query($sql);
  $dbh = null;
} catch (PDOException $e) {
  echo $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP掲示板</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1 class="title">PHPで掲示板アプリ</h1>
  <hr>
  <div class="boardWrapper">
    <section>
      <?php foreach ($comment_array as $comment) : ?>
      <article>
        <div class="wrapper">
          <div class="nameArea">
            <span>名前：</span>
            <p class="username"><?php echo $comment["username"]; ?></p>
            <time>:<?php echo $comment["postDate"]; ?></time>
          </div>
          <p class="comment"><?php echo $comment["comment"]; ?></p>
          <form method="post">
            <input type="hidden" name="id" value="<?php echo $comment["id"] ?>">
            <input type="submit"  name="deleteButton" value="削除">
          </form>
        </div>
      </article>
      <?php endforeach; ?>
    </section>
    <form class="formWrapper" method="POST">
      <div>
        <input type="submit" value="書き込む" name="submitButton">
        <label for="usernameLabel">名前：</label>
        <input type="text" name="username">
      </div>
      <div>
        <textarea class="commentTextArea" name="comment"></textarea>
      </div>
    </form>
  </div>
</body>
</html>