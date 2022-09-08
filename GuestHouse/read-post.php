<?php
// READ POST DATA
// "require" this file to read submitted form data into an array named $data

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
    Reading form data from $_POST into $data array
</div>

<?php
// Reset data to empty array
$data = [];

// Read each key (input name) and value from the submitted form data
// "Flattens" multiple inputs e.g. "option[1]=foo" becomes "option__1=foo"
foreach ($_POST as $key => $value) {
    // Checkboxes or radio buttons may be sent as an array
    if (is_array($value)) {
        // "Flatten" checkbox or radio button values
        foreach ($value as $index => $index_value) {
            // Store each value in its own key
            $data["$key__$index"] = $index_value;
        }
    } else {
        // For all other data, just store it in $data by key
        $data[$key] = $value;
    }
}

if (empty($_POST)) {
    echo '<div class="report">No form data received!</div>';
}
?>

<input id="show_post" type="checkbox" class="collapser" />
<label for="show_post">
    Show/Hide: Form data submitted by browser
</label>
<pre><?php var_export($data) ?></pre>

<div class="report">
    Completed reading form data from $_POST into $data array
</div>