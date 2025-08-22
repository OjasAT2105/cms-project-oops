<?php
class Database {
    private $connection;
    private static $instance;
    private function __construct() {
        $this->open_connection();
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    private function open_connection() {
        $this->connection = new mysqli("localhost", "root", "", "widget_corp");
        if ($this->connection->connect_errno) {
            die("Database connection failed: " . $this->connection->connect_error);
        }
    }

    public function query($sql) {
        $result = $this->connection->query($sql);
        if (!$result) {
            die("Database query failed: " . $this->connection->error);
        }
        return $result;
    }

    public function escape_value($value) {
        return $this->connection->real_escape_string($value);
    }

    public function close_connection() {
        if (isset($this->connection)) {
            $this->connection->close();
            unset($this->connection);
        }
    }
}
?>
