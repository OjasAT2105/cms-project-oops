<?php 
require_once("init.php");

// Initialize objects
$database = new Database();
$session = new Session();

// Logout the user
$session->logout();

// Redirect to login page
header("Location: login.php?logout=1");
exit;
?>
