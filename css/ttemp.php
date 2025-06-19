<?php
session_start();
if (!isset($_SESSION['AgencyID'])) {
    header("Location: ../login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "resumeisterdb";

$connect = mysqli_connect($servername, $username, $password, $database);

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['update'])) {
    $AgencyID = $_SESSION['AgencyID'];

    // Handle the form data for updating the agency's basic information
    if (isset($_POST['agency-name']) && isset($_POST['license-number']) && isset($_POST['address'])) {
    $AgencyName = $_POST['agency-name'];
    $LicenseNumber = $_POST['license-number'];
    $Address = $_POST['address'];

    // Prepare the query with placeholders
    $updateBasicInfoQuery = "UPDATE agency SET AgencyName = ?, LicenseNumber = ?, Address = ? WHERE AgencyID = ?";

    // Create a prepared statement
    $stmt = mysqli_prepare($connect, $updateBasicInfoQuery);

    if ($stmt) {
        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "sssi", $AgencyName, $LicenseNumber, $Address, $AgencyID);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Query executed successfully
            header("Location: http://localhost/Resumeister/agency/agency-settings.php");
            exit();
        } else {
            // Query execution failed
            header("Location: ../agency/agency-settings.php?message=Failed to update basic information");
            exit();
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);

    // Handle the form data for updating the agency's account settings
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
        $AgencyUsername = $_POST['username'];
        $Email = $_POST['email'];
        $Password = $_POST['password']; // Note: You might want to hash the password for security.

        $updateAccountSettingsQuery = "UPDATE agency SET Username = '$AgencyUsername', Email = '$Email', Password = '$Password' WHERE AgencyID = $AgencyID";

        if (mysqli_query($connect, $updateAccountSettingsQuery)) {
            header("Location: http://localhost/Resumeister/agency/agency-settings.php");
            exit();
        } else {
           
            exit();
        }
    }
}
}
}
mysqli_close($connect);
?>
