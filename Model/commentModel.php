<?php
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

  public function postComment($username, $comment, $topic_id) {
    try {
      $postDate = date("Y-m-d H:i:s");
      $dbh = new PDO('mysql:host=localhost;dbname=shin_keijiban', "root", "");
      $stmt = $dbh->prepare("INSERT INTO `keijiban` (`username`, `comment`, `postDate`, `topic_id`) VALUES (:username, :comment, :postDate, :topic_id)");
      $stmt->bindParam(':username', htmlentities($username));
      $stmt->bindParam(':comment', nl2br(htmlspecialchars($comment, ENT_QUOTES, 'utf-8')), PDO::PARAM_STR);
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
      $dbh = new PDO('mysql:host=localhost;dbname=shin_keijiban', "root", "");
      $stmt = $dbh->prepare("DELETE FROM `keijiban` WHERE id=:id");
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