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

    <div class="topic-wrapper">
      <p class="topic-title">トピック：ダミートピック</p>
      <div>
        <p class="topic-name">名前：ダミーネーム</p>
        <p class="topic-date">立てた日：2024-12-12 15:30:23</p>
      </div>
    </div>

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
  </div>
</body>
</html>