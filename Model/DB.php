<?php
class DbConnection {
    private static $instance = null; // PDOインスタンスを保存するプロパティ

    // コンストラクタを private にして外部から直接インスタンス化できないようにする
    private function __construct() {}

    public static function getInstance() {
        if (self::$instance === null) {
            try {
                $dsn = 'mysql:host=localhost;dbname=shin_keijiban';
                $username = 'root';
                $password = '';
                self::$instance = new PDO($dsn, $username, $password);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('データベース接続失敗: ' . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
?>