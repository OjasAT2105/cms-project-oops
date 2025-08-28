<?php

class Page {
    private $db;
    
    public function __construct($database) {
        $this->db = $database;
    }
    
    // Get all pages for a subject (public or admin)
    public function get_for_subject($subject_id, $public = true) {
        $subject_id = $this->db->escape_value($subject_id);
        $sql = "SELECT * FROM pages WHERE subject_id = '{$subject_id}'";
        if ($public) {
            $sql .= " AND visible = 1";
        }
        $sql .= " ORDER BY position ASC";
        
        return $this->db->query($sql);
    }
    
    // Get page by ID
    public function find_by_id($id) {
        $id = $this->db->escape_value($id);
        $sql = "SELECT * FROM pages WHERE id = '{$id}' LIMIT 1";
        $result = $this->db->query($sql);
        
        if ($this->db->num_rows($result) == 1) {
            return $this->db->fetch_array($result);
        } else {
            return false;
        }
    }
    
    // Get default page for a subject (first visible page)
    public function get_default_for_subject($subject_id) {
        $subject_id = $this->db->escape_value($subject_id);
        $sql = "SELECT * FROM pages WHERE subject_id = '{$subject_id}' AND visible = 1 ORDER BY position ASC, id ASC LIMIT 1";
        $result = $this->db->query($sql);
        
        if ($this->db->num_rows($result) == 1) {
            return $this->db->fetch_array($result);
        } else {
            return false;
        }
    }
    
    // Create a new page
    public function create($subject_id, $menu_name, $position, $visible, $content) {
        $subject_id = $this->db->escape_value($subject_id);
        $menu_name = $this->db->escape_value($menu_name);
        $position = $this->db->escape_value($position);
        $visible = $this->db->escape_value($visible);
        $content = $this->db->escape_value($content);
        
        $sql = "INSERT INTO pages (subject_id, menu_name, position, visible, content) VALUES ({$subject_id}, '{$menu_name}', {$position}, {$visible}, '{$content}')";
        return $this->db->query($sql);
    }
    
    // Update a page
    public function update($id, $menu_name, $position, $visible, $content) {
        $id = $this->db->escape_value($id);
        $menu_name = $this->db->escape_value($menu_name);
        $position = $this->db->escape_value($position);
        $visible = $this->db->escape_value($visible);
        $content = $this->db->escape_value($content);
        
        $sql = "UPDATE pages SET menu_name = '{$menu_name}', position = {$position}, visible = {$visible}, content = '{$content}' WHERE id = {$id}";
        return $this->db->query($sql);
    }
    
    // Delete a page
    public function delete($id) {
        $id = $this->db->escape_value($id);
        $sql = "DELETE FROM pages WHERE id = {$id} LIMIT 1";
        return $this->db->query($sql);
    }
    
    // Count pages for a subject
    public function count_for_subject($subject_id) {
        $subject_id = $this->db->escape_value($subject_id);
        $sql = "SELECT COUNT(*) as count FROM pages WHERE subject_id = '{$subject_id}'";
        $result = $this->db->query($sql);
        $row = $this->db->fetch_array($result);
        return $row['count'];
    }
}
?>
