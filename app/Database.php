<?php
class Database {
    private static $servername = "localhost";
    private static $username = "root";
    private static $password = "";
    private static $dbname = "dataware_db";
    public static $conn;

    public static function getConnection() {
        if (!isset(self::$conn)) {
            try {
                self::$conn = new PDO("mysql:host=".self::$servername.";dbname=".self::$dbname, self::$username, self::$password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}
?>
