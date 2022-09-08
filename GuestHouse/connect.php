<?php
// CONNECT TO DATABASE
// "require" this file to create a database connection named $database

// For security, required PHP files should "die" if SAFE_TO_RUN is not defined
if (!defined('SAFE_TO_RUN')) {
    // Prevent this file run directly - show a warning instead
    die(basename(__FILE__)  . ' cannot be executed directly!');
}

// Obtain database credentials from credentials.php
require 'credentials.php';

// Check credentials
if (empty($database_user) or $database_user == '***********') {
    die('$database_user in credentials.php is not set');
}
if (empty($database_password) or $database_password == '***********') {
    die('$database_password in credentials.php is not set');
}

// Connect to server and select database
$database = mysqli_connect($database_host, $database_user, $database_password);
if (!$database) {
    echo '<pre>host: ' . htmlspecialchars($database_host) . '</pre>';
    echo '<pre>user: ' . htmlspecialchars($database_user) . '</pre>';
    echo '<pre>password: ' . htmlspecialchars($database_password) . '</pre>';
    die('Unable to connect to database server!');
}
if (!$database->select_db($database_name)) {
    echo '<pre>name: ' . htmlspecialchars($database_name) . '</pre>';
    die('Unable to select database: ' . $database->error);
}
