<?php
// DELETE ROW FROM DATABASE TABLE
// "require" this file to delete the row with id == $id from the database table

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
    Deleting a row from the database table
</div>

<?php
// Delete a row from the table
$sql = "DELETE FROM $database_table WHERE id=?";

// Prepare statement using SQL command
if (!($stmt = $database->prepare($sql))) {
    die("Error preparing statement ($sql): $database->error");
}

// Bind one string ('s') parameter:
// Replace the first '?' in $sql with the value in $id
if (!$stmt->bind_param('s', $id)) {
    die("Error binding statement ($sql): $stmt->error");
}

// Execute statement and count deleted rows
if ($stmt->execute()) {
    $rows = $stmt->affected_rows;
} else {
    die("Error executing statement ($sql): $stmt->error");
}

if ($rows == 0) {
    echo '<div class="report message always">
        Server message: Row with id=' . _x($id) . ' was not deleted - was it already deleted?
    </div>';
}
?>

<div class="report message always">
    Server message: Completed deleting a row from the database table
</div>
