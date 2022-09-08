<?php error_reporting(E_ALL); ini_set('display_errors', 1);
// DO NOT MODIFY THIS LINE
?> 
<?php
// 
// Version 2.0 - June 2021 - Tadeu Vaccari

// Allow debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define a constant to permit each file we "require" to execute
// For security, required PHP files should "die" if SAFE_TO_RUN is not defined
define('SAFE_TO_RUN', true);

// TODO: Change these values to configure the application
$database_table = ""; // name of database table to read/write
$app_title = 'Erehwon Guest House';
$css_file = "admin.css"; // name of CSS file to load
$js_file = "admin.js"; // name of JavaScript file to load

// Setup flags and other variables used in the application
$url = $_SERVER["PHP_SELF"]; // URL of this page for forms to POST to
$columns = []; // list of names of columns in database table
$task = ''; // task to carry out in response to form submission
$id = ''; // ID of row in table being viewed/edited (if any)
// Search criteria used by search form and data table
$search = ''; // value to search for
$sort = 'id'; // column to sort by
$order = 'ASC'; // order to sort by
// Data shown on data entry form
$data = []; // key/value data from form submission or row in database table
$valid = true; // whether data in $data is known to be valid
$feedback = []; // key/value feedback about invalid data

// Define _e and _x functions
require 'helpers.php';
// Output head of page
require 'tma02_head.php';
?>

<h1>
    <?php _e($app_title); ?>
</h1>

<input id="show_reports" type="checkbox" class="collapser" />
<label for="show_reports">
    Show/Hide: Script execution reports
</label>
<div class="report file">
    Executing: connect.php and credentials.php
</div>

<?php
// Connect to the database
require "connect.php";
?>

<div class="report">
    Connected to database: <?php _e($database_name) ?>
</div>

<div class="report">
    In a real application, we should also authenticate the user before we
    authorise viewing or changing data!
</div>

<?php
// Read column names from the database table into $columns
require "read-columns.php";
// Read the submitted form data into $data
require 'read-post.php';

// Read $task and $id (if any) from submitted form data
if (!empty($data['task'])) {
    $task = $data['task'];
}
if (!empty($data['id'])) {
    $id = $data['id'];
}
?>

<pre>
$task == <?php var_export($task) ?> and $id == <?php var_export($id) ?>
</pre>

<?php
// Submitted form data, carry out any tasks
// Task is to start editing a row...
if ($task == 'edit') {
    // So read the row from the database table into $data
    // This data will be presented by the data form
    require "read-row.php";
}

// Task is to save submitted form data to a row in the database table...
if ($task == 'save') {
    // So validate the form data
    require "validate.php";
    if ($valid) {
        // And save the row (this will clear $data and $id)
        require "save-row.php";
        // Row has been saved so reset task/data/id
        // so that the data table is shown again and the data form is empty
        $task = '';
        $data = [];
        $id = '';
    }
}

// Task is to delete a row from the database table...
if ($task == 'delete') {
    // So delete the row (this will clear $id)
    require "delete-row.php";
    // Row has been saved so reset task/data/id
    // so that the data table is shown again and the data form is empty
    $task = '';
    $id = '';
}

// Output a form to search or sort with
// This also processes search criteria used by the data table
require "search-form.php";

// Output a table of rows in the database table matching search criteria (if any)
require "data-table.php";

// Output a form to enter or edit data (using $data and $id)
require "data-form.php";
?>

<div class="report">
    Task completed!
</div>

