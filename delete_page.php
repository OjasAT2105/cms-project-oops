<?php 
require_once("init.php");

// Initialize objects
$database = new Database();
$session = new Session();
$page = new Page($database);

// Check if user is logged in
if (!$session->is_logged_in()) {
    header("Location: login.php");
    exit;
}

// Check if page ID is provided
if (intval($_GET['page']) == 0) {
    header("Location: content.php");
    exit;
}

$id = $database->escape_value($_GET['page']);

// Check if page exists
if ($page->find_by_id($id)) {
    $result = $page->delete($id);
    
    if ($result && $database->affected_rows() == 1) {
        // Success
        header("Location: content.php");
        exit;
    } else {
        // Failure
        echo "<p>Page deletion failed</p>";
        echo "<a href=\"content.php\">Return to Main Page</a>";
    }
} else {
    // Page didn't exist in database
    header("Location: content.php");
    exit;
}
?>
