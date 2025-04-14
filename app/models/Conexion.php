<?php
require_once 'app/config/config.php';

class Database {
    protected $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=". DB_HOST .";dbname=". DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->conn->exec("SET NAMES 'utf8mb4'");
            
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    }
}
?>