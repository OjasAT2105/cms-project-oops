<?php

class Navigation {
    private $db;
    private $subject;
    private $page;
    
    public function __construct($database) {
        $this->db = $database;
        $this->subject = new Subject($database);
        $this->page = new Page($database);
    }
    
    // Generate admin navigation
    public function admin_navigation($sel_subject, $sel_page) {
        $output = "<ul class=\"subjects\">";
        
        $subject_set = $this->subject->get_all(false); // Get all subjects (including invisible)
        
        while ($subject = $this->db->fetch_array($subject_set)) {
            $output .= "<li";
            if ($sel_subject && $subject['id'] == $sel_subject['id']) {
                $output .= " class=\"selected\"";
            }
            $output .= "><a href=\"edit_subject.php?subj=" . urlencode($subject["id"]) . "\">{$subject["menu_name"]}</a></li>";
            
            $output .= "<ul class=\"pages\">";
            $page_set = $this->page->get_for_subject($subject["id"], false); // Get all pages (including invisible)
            
            while ($page = $this->db->fetch_array($page_set)) {
                $output .= "<li";
                if ($sel_page && $page['id'] == $sel_page['id']) {
                    $output .= " class=\"selected\"";
                }
                $output .= "><a href=\"content.php?page=" . urlencode($page["id"]) . "&subj=" . urlencode($subject["id"]) . "\">{$page["menu_name"]}</a></li>";
            }
            $output .= "</ul>";
        }
        $output .= "</ul>";
        
        return $output;
    }
    
    // Generate public navigation
    public function public_navigation($sel_subject, $sel_page) {
        $output = "<ul class=\"subjects\">";
        
        $subject_set = $this->subject->get_all(true); // Get only visible subjects
        
        while ($subject = $this->db->fetch_array($subject_set)) {
            $output .= "<li";
            if ($sel_subject && $subject['id'] == $sel_subject['id']) {
                $output .= " class=\"selected\"";
            }
            $output .= "><a href=\"index.php?subj=" . urlencode($subject["id"]) . "\">{$subject["menu_name"]}</a></li>";
            
            $page_set = $this->page->get_for_subject($subject["id"], true); // Get only visible pages
            $output .= "<ul class=\"pages\">";
            
            while ($page = $this->db->fetch_array($page_set)) {
                $output .= "<li";
                if ($sel_page && $page['id'] == $sel_page['id']) {
                    $output .= " class=\"selected\"";
                }
                $output .= "><a href=\"index.php?page=" . urlencode($page["id"]) . "&subj=" . urlencode($subject["id"]) . "\">{$page["menu_name"]}</a></li>";
            }
            $output .= "</ul>";
        }
        $output .= "</ul>";
        
        return $output;
    }
    
    // Find selected page and subject based on URL parameters
    public function find_selected_page() {
        $sel_subject = null;
        $sel_page = null;
        
        if (isset($_GET['subj'])) {
            $sel_subject = $this->subject->find_by_id($_GET['subj']);
            if ($sel_subject) {
                // If no specific page is selected, get the default page for this subject
                if (!isset($_GET['page'])) {
                    $sel_page = $this->page->get_default_for_subject($sel_subject['id']);
                } else {
                    $sel_page = $this->page->find_by_id($_GET['page']);
                }
            }
        } elseif (isset($_GET['page'])) {
            $sel_page = $this->page->find_by_id($_GET['page']);
            if ($sel_page) {
                // Get the subject for this page
                $sel_subject = $this->subject->find_by_id($sel_page['subject_id']);
            }
        }
        
        return array('subject' => $sel_subject, 'page' => $sel_page);
    }
}
?>
