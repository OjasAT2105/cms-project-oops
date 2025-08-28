<?php 
require_once("init.php");

// Initialize objects
$database = new Database();
$page = new Page($database);

// Check if user is logged in
if (!$session->is_logged_in()) {
    header("Location: login.php");
    exit;
}

// Set default value for new_page
if (!isset($new_page)) { 
    $new_page = false; 
}
?>

<p>Page Name: 
    <input type="text" name="menu_name" 
           value="<?php echo isset($sel_page['menu_name']) ? FormValidator::sanitize_output($sel_page['menu_name']) : ''; ?>" />
</p>

<p>Position: 
    <select name="position">
        <?php
        if (!$new_page && isset($sel_page['subject_id'])) {
            $page_set = $page->get_for_subject($sel_page['subject_id'], false);
            $page_count = $database->num_rows($page_set);
        } elseif ($new_page && isset($sel_subject['id'])) {
            $page_set = $page->get_for_subject($sel_subject['id'], false);
            $page_count = $database->num_rows($page_set) + 1;
        } else {
            $page_count = 1; // Default fallback
        }
        
        for ($count = 1; $count <= $page_count; $count++) {
            echo "<option value=\"{$count}\"";
            if (isset($sel_page['position']) && $sel_page['position'] == $count) {
                echo " selected";
            }
            echo ">{$count}</option>";
        }
        ?>
    </select>
</p>

<p>Visible:
    <input type="radio" name="visible" value="0" 
        <?php if (isset($sel_page['visible']) && $sel_page['visible'] == 0) { echo "checked"; } ?> /> No
    &nbsp;
    <input type="radio" name="visible" value="1" 
        <?php if ((isset($sel_page['visible']) && $sel_page['visible'] == 1) || $new_page) { echo "checked"; } ?> /> Yes
</p>

<p>Content:<br />
    <textarea name="content" rows="20" cols="80"><?php 
        echo isset($sel_page['content']) ? FormValidator::sanitize_output($sel_page['content']) : ''; 
    ?></textarea>
</p>
