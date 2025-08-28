<?php

class Database {
    private $connection;

    public function __construct() {
        $this->open_connection();
    }

    private function open_connection() {
        $this->connection = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

        if ($this->connection->connect_error) {
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

    public function fetch_array($result) {
        return $result->fetch_assoc();
    }

    public function num_rows($result) {
        return $result->num_rows;
    }

    public function insert_id() {
        return $this->connection->insert_id;
    }

    public function affected_rows() {
        return $this->connection->affected_rows;
    }

    public function __destruct() {
        if (isset($this->connection)) {
            $this->connection->close();
        }
    }
}
