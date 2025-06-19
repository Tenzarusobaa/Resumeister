<?php
// includes/auth.php
session_start();

if (!isset($_SESSION['UserID'])) {
    header("Location: http://localhost/Resumeister/login.php");
    exit();
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: http://localhost/Resumeister/login.php");
    exit();
}

$UserID = $_SESSION['UserID'];
?>