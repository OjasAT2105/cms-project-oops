<?php 
require_once("init.php");

// Initialize objects
$database = new Database();
$session = new Session();
$user = new User($database);

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
        // Check database to see if username and the hashed password exist there
        $found_user = $user->authenticate($username, $password);
        
        if ($found_user) {
            // Username/password authenticated
            $session->login($found_user);
            header("Location: staff.php");
            exit;
        } else {
            $message = "Username/password combination incorrect.<br/>Please make sure your caps lock key is off and try again.";
        }
    } else {
        // Errors occurred
        $message = "There were " . count($errors) . " errors in the form.";
    }
} else {
    if (isset($_GET['logout']) && $_GET['logout'] == 1) {
        $message = "You have been logged out.";
    }
}
?>

<?php include("includes/header.php"); ?>

<table id="structure">
    <tr>
        <td id="navigation">
            <a href="staff.php">Return to Menu</a><br/>
            <br/>
        </td>
        <td id="page">
            <h2>Staff Login</h2>
            <?php if (!empty($message)) { echo "<p class=\"message\">" . $message . "</p>"; } ?>
            <form action="login.php" method="post">
                <p>Username: <input type="text" name="username" value="<?php echo FormValidator::sanitize_output($username); ?>" /></p>
                <p>Password: <input type="password" name="password" value="<?php echo FormValidator::sanitize_output($password); ?>" /></p>
                <p><input type="submit" name="submit" value="Login" /></p>
            </form>
        </td>
    </tr>
</table>

<?php include("includes/footer.php"); ?>
