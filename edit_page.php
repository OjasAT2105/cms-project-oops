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

$message = "";

// Start form processing
if (isset($_POST['submit'])) {
    $errors = array();
    
    $required_fields = array('menu_name', 'position', 'visible');
    $errors = array_merge($errors, FormValidator::check_required_fields($required_fields));
    
    $fields_with_lengths = array('menu_name' => 30);
    $errors = array_merge($errors, FormValidator::check_max_field_lengths($fields_with_lengths, $database));
    
    $page_id = $database->escape_value($_GET['page']);
    $subject_id = $database->escape_value($_GET['subj']);
    $menu_name = trim($database->escape_value($_POST['menu_name']));
    $position = $database->escape_value($_POST['position']);
    $visible = $database->escape_value($_POST['visible']);
    $content = $database->escape_value($_POST['content']);
    
    if (empty($errors)) {
        $result = $page->update($page_id, $menu_name, $position, $visible, $content);
        
        if ($database->affected_rows() == 1) {
            $message = "The page was successfully updated.";
        } else {
            $message = "The page could not be updated.";
        }
    } else {
        if (count($errors) == 1) {
            $message = "There was 1 error in the form.";
        } else {
            $message = "There were " . count($errors) . " errors in the form.";
        }
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
            <h2>Edit Page: <?php echo FormValidator::sanitize_output($sel_page['menu_name']); ?></h2>
            <?php if (!empty($message)) { echo "<p class=\"message\">" . $message . "</p>"; } ?>
            <?php if (!empty($errors)) { FormValidator::display_errors($errors); } ?>
            
            <form action="edit_page.php?page=<?php echo $sel_page['id']; ?>&subj=<?php echo $sel_subject['id']; ?>" method="post">
                <?php include "page_form.php"; ?>
                <input type="submit" name="submit" value="Update Page" />
                &nbsp;&nbsp;
                <a href="delete_page.php?page=<?php echo $sel_page['id']; ?>&subj=<?php echo $sel_subject['id']; ?>" onClick="return confirm('Are you sure want to delete this page?');">Delete page</a>
            </form>
            <br />
            <a href="content.php?page=<?php echo $sel_page['id']; ?>&subj=<?php echo $sel_subject['id']; ?>">Cancel</a>
        </td>
    </tr>
</table>

<?php include("includes/footer.php"); ?>
