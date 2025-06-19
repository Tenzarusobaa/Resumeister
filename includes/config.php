<?php
// includes/config.php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'resumeisterdb');

// Establish database connection
$connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}
?>