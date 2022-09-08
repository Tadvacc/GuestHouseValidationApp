<?php
// READ COLUMNS
// "require" this file to create an array named $columns

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
    Reading column names from the database table into $columns array
</div>

<div class="report">
    Reading column names from table: <?php _e($database_table) ?>
</div>

<?php
// Read columns for table from database
$sql = "SHOW COLUMNS FROM $database_table";
$result = $database->query($sql);

if (!$result) { ?>
    <div class="report always">
        Table "<?php _e($database_table) ?>"" does not exist -
        create the table first using <a href="table-manager.php">table-manager.php</a>
    </div>
    <?php die("Could not execute SQL \"$sql\"");
}

// Reset to empty array
$columns = [];

// Read each row as an array indexed by numbers
while ($row = $result->fetch_row()) {
    // Put the first item in each row into the columns array
    $columns[] = $row[0];
}
?>

<input id="show_columns" type="checkbox" class="collapser" />
<label for="show_columns">
    Show/Hide: Column names read from database table
</label>
<pre><?php var_export($columns) ?></pre>

<div class="report">
    Completed reading column names into $columns array
</div>