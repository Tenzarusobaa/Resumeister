<?php
function validateLogin($username, $password) {
    $servername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $database = "resumeisterdb";
    
    $conn = mysqli_connect($servername, $dbusername, $dbpassword, $database);
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $username = mysqli_real_escape_string($conn, $username);
    $query = "SELECT * FROM user WHERE Username='$username'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['Password'])) {
            session_start();
            $_SESSION['UserID'] = $row['UserID'];
            $_SESSION['Username'] = $row['Username'];
            return true;
        }
    }
    
    mysqli_close($conn);
    return false;
}
?>