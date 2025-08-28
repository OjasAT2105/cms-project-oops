<?php

class Subject {
    private $db;
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    // Get all subjects (public or admin)
    public function get_all($public = true) {
        $sql = "SELECT * FROM subjects";
        if ($public) {
            $sql .= " WHERE visible = 1";
        }
        $sql .= " ORDER BY position ASC";
        
        return $this->db->query($sql);
    }
    
    // Get subject by ID
    public function find_by_id($id) {
        $id = $this->db->escape_value($id);
        $sql = "SELECT * FROM subjects WHERE id = '{$id}' LIMIT 1";
        $result = $this->db->query($sql);
        
        if ($this->db->num_rows($result) == 1) {
            return $this->db->fetch_array($result);
        } else {
            return false;
        }
    }
    
    // Create a new subject
    public function create($menu_name, $position, $visible) {
        $menu_name = $this->db->escape_value($menu_name);
        $position = $this->db->escape_value($position);
        $visible = $this->db->escape_value($visible);
        
        $sql = "INSERT INTO subjects (menu_name, position, visible) VALUES ('{$menu_name}', {$position}, {$visible})";
        return $this->db->query($sql);
    }
    
    // Update a subject
    public function update($id, $menu_name, $position, $visible) {
        $id = $this->db->escape_value($id);
        $menu_name = $this->db->escape_value($menu_name);
        $position = $this->db->escape_value($position);
        $visible = $this->db->escape_value($visible);
        
        $sql = "UPDATE subjects SET menu_name = '{$menu_name}', position = '{$position}', visible = '{$visible}' WHERE id = {$id}";
        return $this->db->query($sql);
    }
    
    // Delete a subject and its pages
    public function delete($id) {
        $id = $this->db->escape_value($id);
        
        // First delete all pages in this subject
        $sql1 = "DELETE FROM pages WHERE subject_id = {$id}";
        $this->db->query($sql1);
        
        // Then delete the subject
        $sql2 = "DELETE FROM subjects WHERE id = {$id} LIMIT 1";
        return $this->db->query($sql2);
    }
    
    // Count total subjects
    public function count() {
        $sql = "SELECT COUNT(*) as count FROM subjects";
        $result = $this->db->query($sql);
        $row = $this->db->fetch_array($result);
        return $row['count'];
    }
}
?>
