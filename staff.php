<?php 
require_once("init.php");

// Initialize objects
$database = new Database();
$session = new Session();

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
            &nbsp;
        </td>
        <td id="page">
            <h2>Staff Menu</h2>
            <p>Welcome to the staff area, <?php echo FormValidator::sanitize_output($session->user_id); ?></p>
            <ul>
                <li><a href="content.php">Manage Content</a></li>
                <li><a href="new_user.php">Manage Users</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </td>
    </tr>
</table>

<?php include("includes/footer.php"); ?>
