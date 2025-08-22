<?php
require_once(__DIR__ . "/Database.php");

class Subject {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAllSubjects() {
        $sql = "SELECT * FROM subjects ORDER BY position ASC";
        return $this->db->query($sql);
    }
}
?>
