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

$errors = array();

// Form Validation
$required_fields = array('menu_name', 'position', 'visible');
foreach ($required_fields as $fieldname) {
    if (!isset($_POST[$fieldname]) || (empty($_POST[$fieldname]) && $_POST[$fieldname] != 0)) {
        $errors[] = $fieldname;
    }
}

$fields_with_lengths = array('menu_name' => 30);
foreach ($fields_with_lengths as $fieldname => $maxlength) {
    if (strlen(trim($database->escape_value($_POST[$fieldname]))) > $maxlength) {
        $errors[] = $fieldname;
    }
}

if (empty($errors)) {
    $menu_name = $database->escape_value($_POST['menu_name']);
    $position = $database->escape_value($_POST['position']);
    $visible = $database->escape_value($_POST['visible']);
    
    $result = $subject->create($menu_name, $position, $visible);
    
    if ($result) {
        // Success
        header("Location: content.php");
        exit;
    } else {
        // Display error message
        echo "<p>Subject creation failed.</p>";
        echo "<a href=\"content.php\">Return to Main Page</a>";
    }
} else {
    // Display validation errors
    echo "<p>There were " . count($errors) . " errors in the form.</p>";
    echo "<a href=\"new_subject.php\">Go back and fix the errors</a>";
}
?>
