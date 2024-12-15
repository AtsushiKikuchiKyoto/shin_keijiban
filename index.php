<!-- http://localhost/shin_keijiban/ -->
<!-- http://localhost/phpmyadmin/ -->

<?php
require_once __DIR__ . '/vendor/autoload.php';
  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
  $dotenv->load();
include 'Controller/commentController.php';
include 'Controller/topicController.php';
include 'View/pageTop.php';
?>