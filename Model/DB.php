<?php
class DbConnection {
    private static $instance = null; // PDOインスタンスを保存するプロパティ

    // コンストラクタを private にして外部から直接インスタンス化できないようにする
    private function __construct() {}

    public static function getInstance() {
        if (self::$instance === null) {
            try {
                $host = $_ENV['DB_HOST']; 
                $dbname = $_ENV['DB_NAME'];
                $user = $_ENV['DB_USER'];
                $pass = $_ENV['DB_PASS'];
                // $host = 'localhost';
                // $dbname = 'shin_keijiban';
                // $user = 'root';
                // $pass = '';
                self::$instance = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('データベース接続失敗: ' . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
?>