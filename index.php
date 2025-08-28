<?php 
require_once("init.php");

// Initialize objects
$database = new Database();
$session = new Session();
$navigation = new Navigation($database);

// Find selected page and subject
$selected = $navigation->find_selected_page();
$sel_subject = $selected['subject'];
$sel_page = $selected['page'];

// Check if user is logged in
if (!$session->is_logged_in()) {
    header("Location: login.php");
    exit;
}
?>

<?php include("includes/header.php"); ?>

<table id="structure">
    <tr>
        <td id="navigation">
            <?php echo $navigation->public_navigation($sel_subject, $sel_page); ?>
        </td>
        <td id="page"> 
            <?php if ($sel_subject) { ?>
                <h2><?php echo FormValidator::sanitize_output($sel_subject['menu_name']); ?></h2>
                <?php if ($sel_page) { ?>
                    <div class="page-content">
                        <h3><?php echo FormValidator::sanitize_output($sel_page['menu_name']); ?></h3>
                        <?php echo FormValidator::strip_tags($sel_page['content']); ?>
                    </div>
                <?php } else { ?>
                    <p>No pages available for this subject.</p>
                <?php } ?>
            <?php } elseif ($sel_page) { ?>
                <h2><?php echo FormValidator::sanitize_output($sel_page['menu_name']); ?></h2>
                <div class="page-content">
                    <?php echo FormValidator::strip_tags($sel_page['content']); ?>
                </div>
            <?php } else { ?>
                <h2>Welcome to Widget Corp</h2>
                <p>Please select a subject from the navigation menu to view content.</p>
            <?php } ?>
        </td>
    </tr>
</table>

<?php include("includes/footer.php"); ?>
