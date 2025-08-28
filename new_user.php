<?php 
require_once("init.php");

// Initialize objects
$database = new Database();
$session = new Session();
$user = new User($database);

// Check if user is logged in
if (!$session->is_logged_in()) {
    header("Location: login.php");
    exit;
}

$message = "";
$username = "";
$password = "";

// Start Processing
if (isset($_POST['submit'])) {
    // Form has been submitted
    $errors = array();
    
    // Perform validations on the form data
    $required_fields = array('username', 'password');
    $errors = array_merge($errors, FormValidator::check_required_fields($required_fields));
    
    $fields_with_lengths = array('username' => 30, 'password' => 30);
    $errors = array_merge($errors, FormValidator::check_max_field_lengths($fields_with_lengths, $database));
    
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if (empty($errors)) {
        $result = $user->create($username, $password);
        
        if ($result) {
            // Success
            header("Location: staff.php");
            exit;
        } else {
            // Display error message
            $message = "User creation failed.";
        }
    } else {
        // Errors occurred
        $message = "There were " . count($errors) . " errors in the form.";
    }
}
?>

<?php include("includes/header.php"); ?>

<table id="structure">
    <tr>
        <td id="navigation">
            <a href="staff.php">Return to Menu</a><br/>
        </td>
        <td id="page">
            <h2>Create New User</h2>
            <?php if (!empty($message)) { echo "<p class=\"message\">" . $message . "</p>"; } ?>
            <form action="new_user.php" method="post">
                <p>Username: <input type="text" name="username" maxlength="30" value="<?php echo FormValidator::sanitize_output($username); ?>" /></p>
                <p>Password: <input type="password" name="password" maxlength="30" value="<?php echo FormValidator::sanitize_output($password); ?>" /></p>
                <p><input type="submit" name="submit" value="Create User" /></p>
            </form>
        </td>
    </tr>
</table>

<?php include("includes/footer.php"); ?>
