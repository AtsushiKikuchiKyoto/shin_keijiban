<?php
require_once 'DB.php';

class Topic {
  function getTopicAll() {
    try {
      $dbh = DbConnection::getInstance();
      $sql = "SELECT * FROM topic 
              ORDER BY id DESC";
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
      $dbh = DbConnection::getInstance();
      $sql = "INSERT INTO topic (username, topic, postDate) 
              VALUES (:username, :topic, :postDate)";
      $stmt = $dbh->prepare($sql);
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
      $dbh = DbConnection::getInstance();
      $sql = "DELETE FROM topic 
              WHERE id=:id";
      $stmt = $dbh->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_STR);
      $stmt->execute();
      $sql = "DELETE FROM keijiban 
              WHERE topic_id=:id";
      $stmt = $dbh->prepare($sql);
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