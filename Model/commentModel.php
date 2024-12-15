<?php
require_once 'DB.php';

class Comment {
  public function getCommentAll(){
    try {
      $dbh = DbConnection::getInstance();
      $sql = "SELECT * FROM keijiban 
              ORDER BY id DESC";
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

  public function postComment($username, $comment, $topic_id) {
    try {
      $postDate = date("Y-m-d H:i:s");
      $usernameParam = htmlentities($username);
      $commentParam = nl2br(htmlspecialchars($comment, ENT_QUOTES, 'utf-8'));
      $dbh = DbConnection::getInstance();
      $sql = "INSERT INTO keijiban (username, comment, postDate, topic_id) 
              VALUES (:username, :comment, :postDate, :topic_id)";
      $stmt = $dbh->prepare($sql);
      $stmt->bindParam(':username', $usernameParam);
      $stmt->bindParam(':comment', $commentParam, PDO::PARAM_STR);
      $stmt->bindParam(':postDate', $postDate, PDO::PARAM_STR);
      $stmt->bindParam(':topic_id', $topic_id, PDO::PARAM_INT);
      
      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      error_log("Database error: " . $e->getMessage());
      return false;
    }
  }

  public function deleteComment($id) {
    try {
      $dbh = DbConnection::getInstance();
      $sql = "DELETE FROM keijiban WHERE id=:id";
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