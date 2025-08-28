<?php 
require_once("init.php");

// Initialize objects
$database = new Database();
$session = new Session();
$subject = new Subject($database);

// Check if user is logged in
if (!$session->is_logged_in()) {
    header("Location: login.php");
    exit;
}

// Check if subject ID is provided
if (intval($_GET['subj']) == 0) {
    header("Location: content.php");
    exit;
}

$id = $database->escape_value($_GET['subj']);

// Check if subject exists
if ($subject->find_by_id($id)) {
    $result = $subject->delete($id);
    
    if ($result && $database->affected_rows() == 1) {
        // Success
        header("Location: content.php");
        exit;
    } else {
        // Failure
        echo "<p>Subject deletion failed</p>";
        echo "<a href=\"content.php\">Return to Main Page</a>";
    }
} else {
    // Subject didn't exist in database
    header("Location: content.php");
    exit;
}
?>
