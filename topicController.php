<?php
include 'topicModel.php';

date_default_timezone_set('Asia/Tokyo');
ini_set('display_errors', "On");
$topics = array();
$dbh = null;
$stmt = null;

// input DB
if(isset($_POST["topicButton"])){
  if(empty($_POST["username"]) or empty($_POST["topic"])){
    echo "名前またはトピックが空です。";
  } else {
    $topic = new Topic();
    $postAction = $topic->postTopic($_POST["username"], $_POST["topic"]);
    if ($postAction) {
      header("Location: " . $_SERVER['PHP_SELF']);
      exit;
    } else {
      echo "トピックを立てられませんでした。";
    }
  }
}

// Topic削除とコメントも削除
if(isset($_POST["deleteTopic"])){
  $topic = new Topic();
  $deleteAction = $topic->deleteTopic($_POST["id"]);
  if ($deleteAction) {
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
  } else {
    echo "トピックを削除できませんでした。";
  }
}

// DB出力
try{
  $topic = new Topic();
  $topics = $topic->getTopicAll();
} catch (PDOException $e) {
  echo $e->getMessage();
}
?>