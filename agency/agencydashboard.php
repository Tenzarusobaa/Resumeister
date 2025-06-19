<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
require_once 'includes/agency_functions.php';

session_start();
if (!isset($_SESSION['AgencyID'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

$connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

$AgencyID = $_SESSION['AgencyID'];
$AgencyName = getAgencyName($connect, $AgencyID);
$result = getApplications($connect);
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../agency/css/gency-styles.css">
        <link rel="stylesheet" href="../agency/css/dashboard-table.css">
        <link rel ="stylesheet" href ="../agency/dashboard-status.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <script src="script.js"></script>
        <style>
            .search-bar {
                margin-bottom: 20px;
            }
            #search-input {
                padding: 5px;
                border: 1px solid #ccc;
                border-radius: 3px;
            }
            #search-button {
                padding: 5px 10px;
                background-color: #007BFF;
                color: white;
                border: none;
                border-radius: 3px;
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="agency-header">
                <div class="header-right">
                    <div class="dropdown">
                        <button class="profile">
                            <?php echo $AgencyName; ?>
                        </button>
                        <div class="dropdown-content">
                            <a href="#">Dashboard</a>
                            <a href="#">Profile Settings</a>
                            <a href="?logout=true">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
            <aside class="side-navigation">
                <div class ="head">
                </div>
                <div class="create-listing">
                    <a href="createlisting.php" class="status"><i class="fas fa-pen-nib"></i>
                        <p>Create New Listing</p>
                    </a>
                </div>
                <hr>
                <ul>
                    <li><a href="agencydashboard.php" class="status"><i class="fas fa-file"></i> Current Applications</a></li>
                    <li><a href="archivedapplications.php" class="status"><i class="fas fa-archive"></i> Archived Applications</a></li>
                    <li><a href="agencydashboard.html" class="status"><i class="fas fa-list-alt"></i> Job Listings</a></li>
                    <li><a href="agencydashboard.html" class="status"><i class="fas fa-cog"></i> Settings</a></li>
                </ul>
            </aside>
            <div class="dashboard-center" id ="dashboard-column-a">
                <br>
                <div class="dashboard-main-content">
                    <h1>Current Applications</h1>
                    <div class="table-container">
                        <div class="search-bar">
                            <input type="text" id="search-input" placeholder="Search...">
                            <button type="button" id="search-button">Search</button>
                        </div>
                        <form method="post" action="updatestatus.php">
                            <table>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Application Date</th>
                                    <th>Status</th>
                                    <th>Company</th>
                                    <th>Job Title</th>
                                    <th>Resume</th>
                                    <th>Action</th>
                                </tr>
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['ApplicationID'] . "</td>";
                                    echo "<td>" . $row['UserName'] . " " . $row['FamilyName'] . "</td>";
                                    echo "<td>" . $row['ApplicationDate'] . "</td>";
                                    echo "<td>";
                                    echo '<input type="hidden" name="applicationID[]" value="' . $row['ApplicationID'] . '">';
                                    if ($row['Status'] == 'Rejected') {
                                        echo '<input type="text" class="updated-button" name="status[]" id ="rejected-button" value="Rejected" readonly>'; 
                                    } 
                                    else if ($row['Status'] == 'Approved') {
                                        echo '<input type="text" class="updated-button" name="status[]" id="approved-status" value="Approved" readonly>'; 
                                    }
                                    else {
                                        echo '<select name="status[]" class="status-dropdown">';
                                        echo '<option value="Pending" ' . ($row['Status'] == 'Pending' ? 'selected' : '') . '>Pending</option>';
                                        echo '<option value="Approved" ' . ($row['Status'] == 'Approved' ? 'selected' : '') . '>Approved</option>';
                                        echo '<option value="Rejected" ' . ($row['Status'] == 'Rejected' ? 'selected' : '') . '>Rejected</option>';
                                        echo '</select>';
                                    }
                                    echo "</td>";
                                    echo "<td>" . $row['CompanyName'] . "</td>";
                                    echo "<td>" . $row['JobApplied'] . "</td>";
                                    echo "<td>" . $row['Resume'] . "</td>";
                                    
                                    if ($row['Status'] == 'Rejected') {
                                        echo '<td><button type="button" disabled>Update</button></td>';
                                    }
                                    else if ($row['Status'] == 'Approved') {
                                        echo '<td><button type="button" disabled>Update</button></td>';
                                    }
                                    else {
                                        echo '<td><button type="submit" class="update-button">Update</button></td>';
                                    }
                                    
                                    echo "</tr>";
                                }
                                ?>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php 
mysqli_close($connect); 
?>