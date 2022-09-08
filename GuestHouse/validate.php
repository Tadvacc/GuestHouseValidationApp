<?php error_reporting(E_ALL); ini_set('display_errors', 1); 
// DO NOT MODIFY THIS LINE 
?> 
<?php
// VALIDATE DATA
// "require" this file to check the submitted form data and set $valid to true or false
// feedback (if any) is placed in $feedback, keyed by column name

// For security, required PHP files should "die" if SAFE_TO_RUN is not defined
if (!defined('SAFE_TO_RUN')) {
    // Prevent this file run directly - show a warning instead
    die(basename(__FILE__)  . ' cannot be executed directly!');
}
?>

<div class="report file">
    Executing: <?php _e(basename(__FILE__)) ?>
</div>

<div class="report">
    Validating data submitted to the server
</div>

<?php
// Assume data is valid until we find an error
$valid = true;
// Start with no feedback
$feedback = [];

// These checks according to the columns/formats you expect
$value = $data['firstname'];
// ^$ = anchors, [a-zA-Z ] = letters/spaces, {1,30} = 1-30 characters
$format = "/^[a-zA-Z ]{1,30}$/";
// If value does NOT match the format then it is invalid
if (!preg_match($format, $value)) {
    $feedback['firstname'] = 'Server feedback: Only 1-30 letters/spaces are permitted';
    $valid = false;
}

$value = $data['lastname'];
// ^$ = anchors, [a-zA-Z ] = letters/spaces, {1,30} = 1-30 characters
$format = "/^[a-zA-Z ]{1,30}$/";
// If value does NOT match the format then it is invalid
if (!preg_match($format, $value)) {
    $feedback['lastname'] = 'Server feedback: Only 1-30 letters/spaces are permitted';
    $valid = false;
}

$value = $data['email'];
// If value does NOT match the filter then it is invalid
if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
    $feedback['email'] = 'Server feedback: Only valid email addresses are permitted';
    $valid = false;
}
// Also check the maximum length for this field as filter_var doesn't do this
if (strlen($value) > 50) {
    $feedback['email'] = 'Server feedback: Email must be 50 characters or less';
    $valid = false;
}

$value = $data['bookref'];
// ^$ = anchors, (ACF)(ABQ)(BXD) = must contain characteres, \- = must contain a dash, (6|9) = must iniciate with numbers 6 or 9, ([0-9]{5}) = numbers up to 6 characters
$format = "/((ACF)|(ABQ)|(BXD){1})\-(6|9{1})([0-9]{5})/";
// If value does NOT match the format then it is invalid
if (!preg_match($format, $value)) {
    $feedback['bookref'] = 'Server feedback:Must start with ACF, ABQ or BXD have a dash and start numbers with 6 or 9';
    $valid = false;
}

if (!$valid) {
    echo '<div class="report message always">Server message: Form data is invalid - please check and try again!</div>';
}
