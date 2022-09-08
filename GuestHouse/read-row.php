<?php
// READ ROW FROM DATABASE TABLE
// "require" this file to read the row with id == $id into an array named $data

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
    Reading row from database table into $data array
</div>

<?php
// Reset to empty array
$data = [];

// Read a row from the table
$sql = "SELECT * FROM $database_table WHERE id=?";

// Prepare statement using SQL command
if (!($stmt = $database->prepare($sql))) {
    die("Error preparing statement ($sql): $database->error");
}

// Bind one string ('s') parameter:
// Replace the first '?' in $sql with the value in $id
if (!$stmt->bind_param('s', $id)) {
    die("Error binding statement ($sql): $stmt->error");
}

// Execute statement and get result
if ($stmt->execute()) {
    $result = $stmt->get_result();
} else {
    die("Error executing statement ($sql): $stmt->error");
}

if (!$result) {
    die("Error obtaining result ($sql): $stmt->error");
}

// Check that at least one row is returned
if ($result->num_rows == 0) {
    die("No rows match query ($sql)");
}

// Read the first row as an array indexed by column names
$data = $result->fetch_assoc();
?>

<input id="show_row" type="checkbox" class="collapser" />
<label for="show_row">
    Show/Hide: Data read from row in database table
</label>
<pre><?php var_export($data) ?></pre>

<div class="report">
    Completed reading row from database table into $data array
</div>