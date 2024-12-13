<?php

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
    try {
      $postDate = date("Y-m-d H:i:s");
      $dbh = new PDO('mysql:host=localhost;dbname=shin_keijiban', "root", "");
      $stmt = $dbh->prepare("INSERT INTO `topic` (`username`, `topic`, `postDate`) VALUES (:username, :topic, :postDate)");
      $stmt->bindParam(':username', htmlentities($_POST["username"]));
      $stmt->bindParam(':topic', htmlspecialchars($_POST["comment"], ENT_QUOTES, 'utf-8'), PDO::PARAM_STR);
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

// DB出力
try{
  $dbh = new PDO('mysql:host=localhost;dbname=shin_keijiban', "root", "");
  $sql = "SELECT * FROM topic ORDER BY id DESC";
  $stmt = $dbh->query($sql);
  $topics = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $dbh = null;
  // if ($topics) {
  // } else {
  //   echo "Topicがありません";
  // }
  
  $dbh = null;
} catch (PDOException $e) {
  echo $e->getMessage();
};
?>