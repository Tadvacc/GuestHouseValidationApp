<?php
// TABLE MANAGER
// Version 2.0 - June 2021 - Tadeu Vaccari

// Allow debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define a constant to permit each file we "require" to execute
// For security, required PHP files should "die" if SAFE_TO_RUN is not defined
define('SAFE_TO_RUN', true);

$database_table = "tt284_tv436"; // name of database table to create/drop

$create_sql = "CREATE TABLE $database_table (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    bookref VARCHAR(10) NOT NULL
    )";

// SQL to delete table
$drop_sql = "DROP TABLE $database_table";

// Setup variables used in the application
$url = $_SERVER["PHP_SELF"]; // URL of this page for forms to POST to
$tables = []; // list of names of tables in database
$columns = []; // list of names of columns in database table (if it exists)
$task = ''; // task to carry out in response to form submission

// Define _e and _x functions
require 'helpers.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>TT284 Table manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
</head>

<body>
<header>
    Share problems and solutions in the <em>Block 2 Practical activities forum</em>
</header>

<h1>TT284 Block 2 - Table manager</h1>

<input id="show_reports" type="checkbox" class="collapser" />
<label for="show_reports">
    Show/Hide: Script execution reports
</label>
<div class="report file">
    Executing: <?php _e(basename(__FILE__)) ?>
</div>

<?php if (!file_exists('connect.php')) { ?>
    <div class="report always">
        This file requires connect.php from Block 2 Part 5 resources to be uploaded to the server!
    </div>
<?php }?>

<?php if (!file_exists('credentials.php')) { ?>
    <div class="report always">
        This file requires credentials.php from Block 2 Part 5 resources to be uploaded to the server!
    </div>
<?php }?>

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
    Processing submitted form data
</div>

<?php
// Read $task from submitted form data
if (!empty($_POST['task'])) {
    $task = $_POST['task'];
}

// Task is to create the table...
if ($task == 'create') {
    echo '<div class="report">';
    echo 'Creating table "' . _x($database_table) . '"';
    echo '</div>';

    // So execute the SQL to create the table
    if ($database->query($create_sql)) {
        echo '<div class="report always">';
        echo 'Created table "' . _x($database_table) . '"';
        echo '</div>';
    } else {
        echo '<div class="report always">';
        echo 'Error creating table: ' . _x($database->error);
        echo '</div>';
    }
}

// Task is to drop the table...
if ($task == 'drop') {
    echo '<div class="report">';
    echo 'Dropping table "' . _x($database_table) . '"';
    echo '</div>';

    // So execute the SQL to create the table
    if ($database->query($drop_sql)) {
        echo '<div class="report always">';
        echo 'Dropped table "' . _x($database_table) . '"';
        echo '</div>';
    } else {
        echo '<div class="report always">';
        echo 'Error dropping table: ' . _x($database->error);
        echo '</div>';
    }
}

?>
<div class="report">
    Reading database tables
</div>

<?php
$sql = "SHOW TABLES";
$result = $database->query($sql);

if (!$result) {
    die("Could not execute SQL \"$sql\"");
}

// Read each row as an array indexed by numbers
while ($row = $result->fetch_row()) {
    // Put the first item in each row into the tables array
    $tables[] = $row[0];
}
?>

<div class="report">
    Reading table columns (if any)
</div>

<?php
// Check if table exists
if (array_search($database_table, $tables) !== false) {
    $sql = "SHOW COLUMNS FROM $database_table";
    $result = $database->query($sql);

    if (!$result) {
        die("Could not execute SQL \"$sql\"");
    }

    // Read each row as an array indexed by numbers
    while ($row = $result->fetch_row()) {
        // Put the first item in each row into the columns array
        $columns[] = $row[0];
    }
}

echo '<h2>The following tables currently exist:</h2>';

echo '<ul>';
// Loop through each value in $tables
foreach ($tables as $table) {
    echo '<li>' . _x($table) . '</li>';
}
echo '</ul>';

if (empty($columns)) {
    echo '<h2>Table "' . _x($database_table) . '" does NOT exist!</h2>';
} else {
    echo '<h2>Table "' . _x($database_table) . '" exists with columns:</h2>';
    echo '<ul>';
    // Loop through each value in $columns
    foreach ($columns as $column) {
        echo '<li>' . _x($column) . '</li>';
    }
    echo '</ul>';
}

// Present a form with buttons to execute the SQL
echo '<h2>Create or drop "' . _x($database_table) . '":</h2>';
?>

<p>
    If you need to change this SQL, edit <?php _e(basename(__FILE__)) ?>
    then click: <a href="<?php _e($url) ?>">reload the page</a>.
</p>

<form method="POST" action="<?php _e($url); ?>">
    <table>
        <tr>
            <th>CREATE</th>
            <th>DROP</th>
        </tr>
        <tr>
            <td><pre><?php _e($create_sql) ?></pre></td>
            <td><pre><?php _e($drop_sql) ?></pre></td>
        </tr>
        <tr>
            <td>
                <input type="submit" name="task" value="create" />
            </td>
            <td>
                <input type="submit" name="task" value="drop" />
                CAREFUL! NO UNDO!
            </td>
        </tr>
    </table>
</form>
</body>
</html>