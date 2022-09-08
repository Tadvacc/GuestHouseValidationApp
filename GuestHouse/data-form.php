<?php
// DATA ADD/EDIT FORM
// "require" this file to output a form to add or edit data

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
    Generating a HTML form to match the columns in the database table
</div>

<?php
// If adding, editing or saving, show the form by default
if ($task == 'add' or $task == 'edit' or $task == 'save') {
    $checked = 'checked';
} else {
    $checked = '';
}
?>

<input <?php _e($checked) ?> id="show_form" type="checkbox" class="collapser" />
<label for="show_form">
    Show/Hide: Data entry form
</label>
<form method="POST" action="<?php _e($url); ?>" onsubmit="return validateForm()">
    <input type="hidden" name="id" value="<?php _e($id) ?>" />
    <p>
        <label for="firstname">First name:</label>
        <input
            type="text"
            id="firstname"
            name="firstname"
            value="<?php _e($data, "firstname") ?>"
            onchange="validate(event.target)"
        />
        <span id="feedback_firstname" class="invalid">
            <?php _e($feedback, "firstname") ?>
        </span>
    </p>

    <p>
        <label for="lastname">Last name:</label>
        <input
            type="text"
            id="lastname"
            name="lastname"
            value="<?php _e($data, "lastname") ?>"
            onchange="validate(event.target)"
        />
        <span id="feedback_lastname" class="invalid">
            <?php _e($feedback, "lastname") ?>
        </span>
    </p>

    <p>
        <label for="email">Email:</label>
        <input
            type="text"
            id="email"
            name="email"
            value="<?php _e($data, "email") ?>"
            onchange="validate(event.target)"
        />
        <span id="feedback_email" class="invalid">
            <?php _e($feedback, "email") ?>
        </span>
    </p>
    
    <p>
        <label for="bookref">Booking Reference:</label>
        <input
            type="text"
            id="bookref"
            name="bookref"
            maxlength="10"
            value="<?php _e($data, "bookref") ?>"
            onchange="validate(event.target)"
        />
        <span id="feedback_bookref" class="invalid">
            <?php _e($feedback, "bookref") ?>
        </span>
    </p>

    <p>
        <label for="save">Submit:</label>
        <input type="submit" id="save" name="task" value="save" />
        <a class="cancel" href="<?php _e($url) ?>">cancel</a>
    </p>
</form>

<div class="report">
    Completed generating a HTML form to match the columns in the database table
</div>