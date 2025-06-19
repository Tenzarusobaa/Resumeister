<?php
require_once 'includes/auth_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if (validateLogin($username, $password)) {
        header("Location: http://localhost/Resumeister/jobs.php");
        exit();
    } else {
        header("Location: http://localhost/Resumeister/login.php?error=1");
        exit();
    }
} else {
    header("Location: http://localhost/Resumeister/login.php");
    exit();
}
?>