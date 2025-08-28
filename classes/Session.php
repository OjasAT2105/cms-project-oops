<?php

class Session {
    private $logged_in = false;
    public $user_id;
    public $message;

    public function __construct() {
        session_start();   // start PHP session automatically
        $this->check_login();
        $this->check_message();
    }

    // Store a flash message in session
    public function set_message($msg = "") {
        if (!empty($msg)) {
            $_SESSION['message'] = $msg;
        }
    }

    // Retrieve flash message
    private function check_message() {
        if (isset($_SESSION['message'])) {
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);  // only show once
        } else {
            $this->message = "";
        }
    }

    // Login a user (store ID in session)
    public function login($user) {
        if ($user) {
            $this->user_id = $_SESSION['user_id'] = $user['id']; // or $user->id if it's an object
            $this->logged_in = true;
        }
    }

    // Logout user
    public function logout() {
        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->logged_in = false;
    }

    // Check if someone is logged in
    private function check_login() {
        if (isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
            $this->logged_in = true;
        } else {
            $this->logged_in = false;
        }
    }

    public function is_logged_in() {
        return $this->logged_in;
    }
}
