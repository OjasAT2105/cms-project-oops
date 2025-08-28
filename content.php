<?php 
require_once("init.php");

// Initialize objects
$database = new Database();
$session = new Session();
$navigation = new Navigation($database);

// Check if user is logged in
if (!$session->is_logged_in()) {
    header("Location: login.php");
    exit;
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
            <br/>
            <a href="new_subject.php">+Add a new Subject</a>
        </td>
        <td id="page"> 
            <?php if (!is_null($sel_subject)) { ?>
                <h2><?php echo FormValidator::sanitize_output($sel_subject['menu_name']); ?></h2>
                <?php if ($sel_page) { ?>
                    <div class="page-content">
                        <h3><?php echo FormValidator::sanitize_output($sel_page['menu_name']); ?></h3>
                        <?php echo $sel_page['content']; ?>
                        <br/><br/>
                        <a href="edit_page.php?page=<?php echo $sel_page['id']; ?>&subj=<?php echo $sel_subject['id']; ?>">+ Edit Page</a>
                    </div>
                <?php } else { ?>
                    <p>No pages available for this subject.</p>
                    <a href="new_page.php?subj=<?php echo $sel_subject['id']; ?>">+ Add a new page</a>
                <?php } ?>
            <?php } elseif (!is_null($sel_page)) { ?>
                <h2><?php echo FormValidator::sanitize_output($sel_page['menu_name']); ?></h2>
                <div class="page-content">
                    <?php echo $sel_page['content']; ?>
                    <br/><br/>
                    <a href="edit_page.php?page=<?php echo $sel_page['id']; ?>&subj=<?php echo $sel_subject['id']; ?>">Edit Page</a>
                </div>
            <?php } else { ?>
                <h2>Select a subject or a page to edit</h2>
            <?php } ?>
        </td>
    </tr>
</table>

<?php include("includes/footer.php"); ?>
