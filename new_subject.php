<?php 
require_once("init.php");

// Initialize objects
$database = new Database();
$session = new Session();
$subject = new Subject($database);
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
        </td>
        <td id="page"> 
            <h2>Add Subject</h2>
            <form action="create_subject.php" method="post">
                <p>Subject Name: <input type="text" name="menu_name" value="" id="menu_name"/></p>
                <p>Position:
                    <select name="position">
                        <?php 
                        $subject_set = $subject->get_all(false);
                        $subject_count = $database->num_rows($subject_set);
                        // subject count + 1 because we are adding the subject
                        for ($count = 1; $count <= $subject_count + 1; $count++) {
                            echo "<option value=\"{$count}\">{$count}</option>";
                        }
                        ?>
                    </select>
                </p>
                <p>Visible:
                    <input type="radio" name="visible" value="0" /> No 
                    &nbsp;
                    <input type="radio" name="visible" value="1" /> Yes
                </p>
                <input type="submit" value="Add Subject" />
            </form>
            <br/>
            <a href="content.php">Cancel</a>
        </td>
    </tr>
</table>

<?php include("includes/footer.php"); ?>
