<?php

date_default_timezone_set('Asia/Tokyo');
ini_set('display_errors', "On");
$topics = array();
$dbh = null;
$stmt = null;

try{
  $dbh = new PDO('mysql:host=localhost;dbname=shin_keijiban', "root", "");
  $sql = "SELECT * FROM topic ORDER BY id DESC";
  $topics = $dbh->query($sql);
  $dbh = null;
  if ($topics) {
  } else {
    echo "Topicがありません";
  }
  
  $dbh = null;
} catch (PDOException $e) {
  echo $e->getMessage();
};
?>