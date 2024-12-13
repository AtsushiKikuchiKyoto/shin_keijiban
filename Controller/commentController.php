<?php
include 'Model/commentModel.php';

date_default_timezone_set('Asia/Tokyo');
ini_set('display_errors', "On");
$comments = array();
$dbh = null;
$stmt = null;

// index
  $comment = new Comment();
  $comments = $comment->getCommentAll();

  // post
if(isset($_POST["submitButton"])){
  if (empty($_POST["username"]) || empty($_POST["comment"])){
    echo "名前またはコメントが空です。";
  } else {
    $comment = new Comment();
    $postAction = $comment->postComment($_POST["username"], $_POST["comment"], $_POST["topic_id"]); 
    if ($postAction) {
      // フォーム送信後リダイレクト
      header("Location: " . $_SERVER['PHP_SELF']);
      exit;
    } else {
      echo "コメントを投稿できませんでした。";
    }
  }
}

// delete
if(isset($_POST["deleteButton"])){
  $comment = new Comment();
  $deleteAction = $comment->deleteComment($_POST["id"]);
  if ($deleteAction) {
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  } else {
    echo "コメントを削除できませんでした。";
  }
}

?>