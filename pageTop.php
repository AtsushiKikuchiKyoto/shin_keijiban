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

  <?php foreach ($topics as $topic) : ?>

    <div class="boardWrapper">

      <div class="topic-wrapper">
        <p class="topic-title">トピック：<?php echo $topic["topic"] ?></p>
        <div>
          <p class="topic-name">名前：<?php echo $topic["username"] ?></p>
          <p class="topic-date">立てた日：<?php echo $topic["postDate"] ?></p>
        </div>
      </div>

      <form class="formWrapper" method="POST">
        <div>
          <input type="submit" value="書き込む" name="submitButton">
          <label for="usernameLabel">名前：</label>
          <input type="text" name="username">
          <input type="hidden" name="topic_id" value="<?php echo $topic["id"] ?>">
        </div>
        <div>
          <textarea class="commentTextArea" name="comment"></textarea>
        </div>
      </form>

      <section>
        <?php foreach ($comment_array as $comment) : ?>
        <?php if ($topic["id"] == $comment["topic_id"]) :?>
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
        <?php endif ?>
        <?php endforeach; ?>
      </section>
    </div>

  <?php endforeach; ?>

</body>
</html>