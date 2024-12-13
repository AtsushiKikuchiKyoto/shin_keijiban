<?php
class Topic {
  function getTopicAll() {
    try {
      $dbh = new PDO('mysql:host=localhost;dbname=shin_keijiban', "root", "");
      $sql = "SELECT * FROM topic ORDER BY id DESC";
      $stmt = $dbh->query($sql);
      $topics = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $topics;
    } catch (PDOException $e) {
      echo $e->getMessage();
      return [];
    } finally {
      $dbh = null;
    }
  }

  function postTopic($username, $topic) {
    try {
      $postDate = date("Y-m-d H:i:s");
      $dbh = new PDO('mysql:host=localhost;dbname=shin_keijiban', "root", "");
      $stmt = $dbh->prepare("INSERT INTO `topic` (`username`, `topic`, `postDate`) VALUES (:username, :topic, :postDate)");
      $stmt->bindParam(':username', htmlentities($username));
      $stmt->bindParam(':topic', htmlspecialchars($topic, ENT_QUOTES, 'utf-8'), PDO::PARAM_STR);
      $stmt->bindParam(':postDate', $postDate, PDO::PARAM_STR);
      $stmt->execute();
      $dbh = null;
      return true;
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  function deleteTopic($id) {
    try {
      $dbh = new PDO('mysql:host=localhost;dbname=shin_keijiban', "root", "");
      $stmt = $dbh->prepare("DELETE FROM `topic` WHERE id=:id");
      $stmt->bindParam(':id', $id, PDO::PARAM_STR);
      $stmt->execute();
      $stmt = $dbh->prepare("DELETE FROM `keijiban` WHERE topic_id=:id");
      $stmt->bindParam(':id', $id, PDO::PARAM_STR);
      $stmt->execute();
      $dbh = null;
      return true;
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }
}

?>