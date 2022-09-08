<?php
// DATA TABLE
// "require" this file to output a HTML table of data in the database table

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
    Generating a HTML table of rows in the database table
</div>

<?php
$sql = "SELECT id, firstname, lastname, email, bookref";
$sql = $sql . " FROM $database_table";
$sql = $sql . " WHERE firstname LIKE ? OR lastname LIKE ? OR email LIKE ? OR bookref LIKE ?";
$sql = $sql . " ORDER BY $sort $order";
?>

<pre class="report">
$sql == <?php _e($sql) ?>
</pre>

<?php
// Prepare statement using SQL command
if (!($stmt = $database->prepare($sql))) {
    die("Error preparing statement ($sql): $database->error");
}

// Add wildcards to search value (% is a wildcard when using SQL LIKE)
$term = '%' . $search . '%';

// Bind parameters for SELECT statement ('s' for each column, $term for each column )
if (!$stmt->bind_param('ssss', $term, $term, $term, $term)) {
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

// If there is no task, or if searching, show the table by default
if ($task == '' or $task == 'search') {
    $checked = 'checked';
} else {
    $checked = '';
}
?>

<input <?php _e($checked) ?> id="show_table" type="checkbox" class="collapser" />
<label for="show_table">
    Show/Hide: Data from database table
</label>
<table>
    <thead>
        <tr>
            <th>firstname</th>
            <th>lastname</th>
            <th>email</th>
            <th>bookref</th>
        </tr>
    </thead>
    <tbody>
        <!-- Read each row as an array indexed by column names -->
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <!-- TODO: Change table data to output the columns you expect -->
                <td><?php _e($row, 'firstname') ?></td>
                <td><?php _e($row, 'lastname') ?></td>
                <td><?php _e($row, 'email') ?></td>
                <td><?php _e($row, 'bookref') ?></td>
                <td>
                    <form method="POST" action="<?php _e($url); ?>">
                        <input type="hidden" name="id" value="<?php _e($row, 'id') ?>" />
                        <input type="submit" name="task" value="delete" />
                    </form>
                </td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <?php _e($result->num_rows) ?> results
            </td>
            <!-- Output the search term if there is one -->
            <?php if ($search) { ?>
                <td>
                    for "<?php _e($search) ?>"
                </td>
            <?php } ?>
            <td>
                <form method="POST" action="<?php _e($url); ?>">
                    <input type="submit" name="task" value="add" />
                </form>
            </td>
        </tr>
    </tfoot>
</table>

<div class="report">
    Completed generating a HTML table of rows in the database table
</div>
