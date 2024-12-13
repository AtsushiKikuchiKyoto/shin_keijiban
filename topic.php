<?php
try{
  $dbh = new PDO('mysql:host=localhost;dbname=shin_keijiban', "root", "");
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // for error

  $sql = "SELECT * FROM topic WHERE id = 1";
  $stmt = $dbh->query($sql);

  $topic = $stmt->fetch(PDO::FETCH_ASSOC); //return 1row

  if ($topic) {
    echo $topic["topic"];
  } else {
    echo "Topicがありません";
  }
  
  $dbh = null;
} catch (PDOException $e) {
  echo $e->getMessage();
};
?>