<?php
require_once(__DIR__ . "/Database.php");

class Page {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getPagesForSubject($subject_id) {
        $subject_id = $this->db->escape_value($subject_id);
        $sql = "SELECT * FROM pages WHERE subject_id = '{$subject_id}' ORDER BY position ASC";
        return $this->db->query($sql);
    }
}
?>
