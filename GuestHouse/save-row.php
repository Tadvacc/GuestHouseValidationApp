<?php
// SAVE ROW TO DATABASE TABLE
// "require" this file to save the data in $data to a row in the database table

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
    Saving data from $data array to row in database table
</div>

<?php
//Change SQL according to the columns you expect
if ($id) {
    // Update existing row
    $sql = "UPDATE $database_table SET firstname=?, lastname=?, email=?, bookref=? WHERE id=?";
} else {
    // Create new row
    $sql = "INSERT INTO $database_table (firstname, lastname, email, bookref) VALUES (?,?,?,?)";
}
?>

<pre class="report">
$sql == <?php _e($sql) ?>
</pre>

<?php
// Prepare statement using SQL command
if (!($stmt = $database->prepare($sql))) {
    die("Error preparing statement ($sql): $database->error");
}

// Calls according to the columns you expect
if ($id) {
    // Bind parameters for UPDATE statement ('s' for each column plus 's' for id)
    if (!$stmt->bind_param('sssss', $data['firstname'], $data['lastname'], $data['email'], $data['bookref'], $id)) {
        die("Error binding statement ($sql): $stmt->error");
    }
} else {
    // Bind parameters for INSERT statement ('s' for each column)
    if (!$stmt->bind_param('ssss', $data['firstname'], $data['lastname'], $data['email'], $data['bookref'])) {
        die("Error binding statement ($sql): $stmt->error");
    }
}

// Execute statement and count inserted/updated rows
if ($stmt->execute()) {
    $rows = $stmt->affected_rows;
} else {
    die("Error executing statement ($sql): $stmt->error");
}

if ($id and $rows == 0) {
    echo '<div class="report message always">
        Server message: Row with id=' . _x($id) . ' was not changed - either it does not exist or its values did not change
    </div>';
}

if (!$id and $rows == 0) {
    die("No row was inserted ($sql)");
}
?>

<div class="report message always">
    Server message: Completed saving data to row in database table
</div>
