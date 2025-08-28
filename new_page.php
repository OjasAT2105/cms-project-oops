<?php 
require_once("init.php");

// Initialize objects
$database = new Database();
$session = new Session();
$subject = new Subject($database);
$page = new Page($database);
$navigation = new Navigation($database);

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

$message = "";

// Start form processing
if (isset($_POST['submit'])) {
    $errors = array();
    
    $required_fields = array('menu_name', 'position', 'visible');
    $errors = array_merge($errors, FormValidator::check_required_fields($required_fields));
    
    $fields_with_lengths = array('menu_name' => 30);
    $errors = array_merge($errors, FormValidator::check_max_field_lengths($fields_with_lengths, $database));
    
    $subject_id = $database->escape_value($_GET['subj']);
    $menu_name = trim($database->escape_value($_POST['menu_name']));
    $position = $database->escape_value($_POST['position']);
    $visible = $database->escape_value($_POST['visible']);
    $content = $database->escape_value($_POST['content']);
    
    if (empty($errors)) {
        $result = $page->create($subject_id, $menu_name, $position, $visible, $content);
        
        if ($database->affected_rows() == 1) {
            $message = "The page was successfully created.";
        } else {
            $message = "The page could not be created.";
        }
    } else {
        $message = "There were " . count($errors) . " errors in the form.";
    }
}

// Find selected page and subject
$selected = $navigation->find_selected_page();
$sel_subject = $selected['subject'];
$sel_page = $selected['page'];
?>

<?php include("includes/header.php"); ?>

<table id="structure">
    <tr>
        <td id="navigation">
            <?php echo $navigation->admin_navigation($sel_subject, $sel_page); ?>
            <br />
            <a href="new_subject.php">+ Add a new subject</a>
        </td>
        <td id="page">
            <h2>Adding a new Page</h2>
            <?php if (!empty($message)) { echo "<p class=\"message\">" . $message . "</p>"; } ?>
            <?php if (!empty($errors)) { FormValidator::display_errors($errors); } ?>
            
            <form action="new_page.php?subj=<?php echo urlencode($sel_subject['id']); ?>" method="post">
                <?php $new_page = true; ?>
                <?php include "page_form.php"; ?>
                <input type="submit" name="submit" value="Create Page" />
            </form>
            <br/>
            <a href="edit_subject.php?subj=<?php echo $sel_subject['id']; ?>">Cancel</a>
        </td>
    </tr>
</table>

<?php include("includes/footer.php"); ?>
