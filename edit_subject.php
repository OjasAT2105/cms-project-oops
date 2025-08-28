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

// Check if subject ID is provided
if (intval($_GET['subj']) == 0) {
    header("Location: content.php");
    exit;
}

// Handle form submission
if (isset($_POST['submit'])) {
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
        $id = $database->escape_value($_GET['subj']);
        $menu_name = $database->escape_value($_POST['menu_name']);
        $position = $database->escape_value($_POST['position']);
        $visible = $database->escape_value($_POST['visible']);
        
        $result = $subject->update($id, $menu_name, $position, $visible);
        
        if ($database->affected_rows() == 1) {
            $message = "The subject was successfully updated.";
        } else {
            $message = "The subject update failed";
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
        </td>
        <td id="page"> 
            <h2>Edit Subject: <?php echo FormValidator::sanitize_output($sel_subject['menu_name']); ?></h2>
            <?php if (!empty($message)) { echo "<p class=\"message\">" . $message . "</p>"; } ?>
            
            <form action="edit_subject.php?subj=<?php echo urlencode($sel_subject['id']); ?>" method="post">
                <p>Subject Name: <input type="text" name="menu_name" value="<?php echo FormValidator::sanitize_output($sel_subject['menu_name']); ?>" id="menu_name"/></p>
                <p>Position:
                    <select name="position">
                        <?php 
                        $subject_set = $subject->get_all(false);
                        $subject_count = $database->num_rows($subject_set);
                        for ($count = 1; $count <= $subject_count; $count++) {
                            echo "<option value=\"{$count}\"";
                            if ($sel_subject['position'] == $count) {
                                echo " selected";
                            }
                            echo ">{$count}</option>";
                        }
                        ?>
                    </select>
                </p>
                <p>Visible:
                    <input type="radio" name="visible" value="0" <?php if ($sel_subject['visible'] == 0) { echo "checked"; } ?> /> No 
                    &nbsp;
                    <input type="radio" name="visible" value="1" <?php if ($sel_subject['visible'] == 1) { echo "checked"; } ?> /> Yes
                </p>
                <input type="submit" name="submit" value="Edit Subject" />
                &nbsp;&nbsp;
                <a href="delete_subject.php?subj=<?php echo urlencode($sel_subject['id']); ?>" onClick="return confirm('Are you Sure?');">Delete Subject</a>
            </form>
            <br/>
            <a href="content.php">Cancel</a>
            
            <div style="margin-top:2em; border-top:1px solid #000000">
                <h3>Pages in this subject:</h3>
                <ul>
                    <?php 
                    $subject_pages = $page->get_for_subject($sel_subject['id'], false);
                    while ($page_item = $database->fetch_array($subject_pages)) {
                        echo "<li><a href=\"content.php?page={$page_item['id']}\">{$page_item['menu_name']}</a></li>";
                    }
                    ?>
                </ul>
                <br/>
                + <a href="new_page.php?subj=<?php echo $sel_subject['id']; ?>">Add a new page to this subject</a>
            </div>
        </td>
    </tr>
</table>

<?php include("includes/footer.php"); ?>
