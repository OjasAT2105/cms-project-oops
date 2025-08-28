<?php

class FormValidator {
    
    // Check required fields
    public static function check_required_fields($required_array) {
        $field_errors = array();
        foreach ($required_array as $fieldname) {
            if (!isset($_POST[$fieldname]) || (empty($_POST[$fieldname]) && $_POST[$fieldname] != 0)) {
                $field_errors[] = $fieldname;
            }
        }
        return $field_errors;
    }
    
    // Check maximum field lengths
    public static function check_max_field_lengths($field_length_array, $database) {
        $field_errors = array();
        foreach ($field_length_array as $fieldname => $maxlength) {
            if (strlen(trim($database->escape_value($_POST[$fieldname]))) > $maxlength) {
                $field_errors[] = $fieldname;
            }
        }
        return $field_errors;
    }
    
    // Display errors
    public static function display_errors($error_array) {
        echo "<p class=\"errors\">";
        echo "Please review the following fields:<br />";
        foreach ($error_array as $error) {
            echo " - " . $error . "<br />";
        }
        echo "</p>";
    }
    
    // Sanitize output
    public static function sanitize_output($value) {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    
    // Strip HTML tags for content display
    public static function strip_tags($value) {
        return strip_tags($value);
    }
}
?>
