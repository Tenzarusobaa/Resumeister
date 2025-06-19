<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'includes/auth_functions.php';
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if (validateLogin($username, $password)) {
        header("Location: http://localhost/Resumeister/jobs.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Resumeister</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <form method="POST" action="login.php">
        <div class="login">
            <div class="header" style="margin-top: 40px">
                <img src ="http://localhost/Resumeister/assets/img-bg/resumeister.png">
            </div>
            <div class="header">
                <h1>Welcome Back</h1>
            </div>
            <br><br>
            <?php if (isset($error)): ?>
            <div class="error">
                <p><?php echo $error; ?></p>
            </div>
            <br>
            <?php endif; ?>
            <div class="input">
                <input type="text" name="username" placeholder="Username" required>
            </div><br><br>
            <div class="input">
                <input type="password" name="password" placeholder="Password" required>
            </div><br><br><br>
            <div class="input">
                <button type="submit" name="submit">Log in</button>
            </div>   
            <div class="signup">
                <p>Sign Up</p>
            </div>            
        </div>
    </form>
    </div>
</body>
</html>