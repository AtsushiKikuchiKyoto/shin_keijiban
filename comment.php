<?php

date_default_timezone_set('Asia/Tokyo');
ini_set('display_errors', "On");
$comments = array();
$dbh = null;
$stmt = null;

class Comment {
  public function getCommentAll(){
    try {
      $dbh = new PDO('mysql:host=localhost;dbname=shin_keijiban', "root", "");
      $sql = "SELECT * FROM keijiban ORDER BY id DESC";
      $stmt = $dbh->query($sql);
      $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $comments;
    } catch (PDOException $e) {
      echo $e->getMessage();
      return [];
    } finally {
      $dbh = null;
    }
  }

  public function postComment(){
    try {
      $postDate = date("Y-m-d H:i:s");
      $dbh = new PDO('mysql:host=localhost;dbname=shin_keijiban', "root", "");
      $stmt = $dbh->prepare("INSERT INTO `keijiban` (`username`, `comment`, `postDate`, `topic_id`) VALUES (:username, :comment, :postDate, :topic_id)");
      $stmt->bindParam(':username', htmlentities($_POST["username"]));
      $stmt->bindParam(':comment', nl2br(htmlspecialchars($_POST["comment"], ENT_QUOTES, 'utf-8')), PDO::PARAM_STR);
      $stmt->bindParam(':postDate', $postDate, PDO::PARAM_STR);
      $stmt->bindParam(':topic_id', $_POST["topic_id"], PDO::PARAM_INT);
      
      $stmt->execute();
      $dbh = null;

      // フォーム送信後リダイレクト
      header("Location: " . $_SERVER['PHP_SELF']);
      exit;
    } catch (PDOException $e) {
      echo $e->getMessage();
    };
  }
}

// input DB
if(isset($_POST["submitButton"])){
  if(empty($_POST["username"]) or empty($_POST["comment"])){
    echo "名前またはコメントが空です。";
  } else {
    $comment = new Comment();
    $comment->postComment();
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
  $comment = new Comment();
  $comments = $comment->getCommentAll();
?>