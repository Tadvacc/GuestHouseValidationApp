<?php
// HELPER FUNCTIONS
// "require" this file to make use of these functions

// For security, required PHP files should "die" if SAFE_TO_RUN is not defined
if (!defined('SAFE_TO_RUN')) {
    // Prevent this file run directly - show a warning instead
    die(basename(__FILE__)  . ' cannot be executed directly!');
}

function _x($variable)
{
    return htmlspecialchars($variable);
}

function _e($variable, $key = null)
{
    if (is_array($variable) and $key != null) {
        if (!empty($variable[$key])) {
            echo _x($variable[$key]);
        }
    } else {
        echo _x($variable);
    }
}
