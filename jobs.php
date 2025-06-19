<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
require_once 'includes/job_functions.php';
require_once 'includes/notifications.php';

$userData = getUserExperience($connect, $UserID);
$base64Image = base64_encode($userData['Picture']);
$YearExperience = $userData['TotalYears'];

$searchQuery = $_GET['search'] ?? '';
$matchWithExperience = isset($_GET['matchWithExperience']);
$currentPage = $_GET['page'] ?? 1;
$resultsPerPage = 5;
$startFrom = ($currentPage - 1) * $resultsPerPage;

$resultJobListings = getJobListings($connect, $UserID, $searchQuery, $matchWithExperience, $startFrom, $resultsPerPage);

$totalCount = getTotalJobCount($connect, $searchQuery);
$totalPages = ceil($totalCount / $resultsPerPage);

$resultRecent = getRecentListings($connect);

$resultNotification = getNotifications($connect, $UserID);
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="http://localhost/Resumeister/css/job-styles.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <style>
            .full-view-button {
            background-color: #2253ab;
            border: none;
            color: white;
            border-radius: 10px;
            padding: 5px;
            }
        </style>
    </head>
    <body>
        <header>
            <div class="header-container">
            <div class="site-logo">
                <img src="http://localhost/Resumeister/assets/img-bg/Resumeister.png">
                <div class = "navigation_container">
                    <nav>
                        <ul>
                            <li class="current"><a href="http://localhost/Resumeister/jobs.php">Jobs</a></li>
                            <li><a href="http://localhost/Resumeister/community.php">Community</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            
            <div class="search-bar">
                <div class="searchInputWrapper">
                    <input class="searchInput" type="text" placeholder='Placeholder logo'>
                    <i class="searchInputIcon fa fa-search"></i>
                </div>
            </div>
            <div class="profile-section">
                <div class="utilities">
                    <i class="fa-solid fa-bell"></i>
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <a href="http://localhost/Resumeister/user/index.php">
                    <div class="profile-picture" style="background-image: url(data:image/jpeg;base64,<?php echo $base64Image; ?>)">
                    </div>
                </a>
            </div>
        </header>
        <br><br>
        <div class="container">
            <div class="column-a">
                <?php
                    while ($row = mysqli_fetch_assoc($resultJobListings)) {
                        $companyName = $row['CompanyName'];
                        $agencyName = $row['ParentAgencyName'];
                        $jobTitle = $row['JobTitle'];
                        $jobLocation = $row['JobLocation'];
                        $industryTag = $row['IndustryTag'];
                        $countryTag = $row['CountryTag'];
                        $typeTag = $row['TypeTag'];
                        $jobDetails = $row['JobDetails'];
                        $img = $row['ImgPath'];
                        $jobID = $row['JobListingID'];
                        $date = $row['ListingDate'];
                        $time = $row['ListingTime'];
                        $StrictMode = $row['StrictMode'];
                    
                        echo "<a href='http://localhost/Resumeister/jobs/full.php?listing=$jobID'>
                            <div class='content-container'>
                                <div class='content'>
                                    <div class='content-top-section'>
                                        <div class='company-profile-details'>
                                            <div class='company-image'>
                                              <img src ='http://localhost/Resumeister/assets/$img'>
                                                <h1></h1>
                                            </div>
                                            <div class='company-name'>
                                                <h3>$companyName</h3>
                                                <p>$agencyName</p>
                                            </div>
                                        </div>
                                        <div class='utility'>
                                            <div class='buttons'>
                                                <div class='full-view-button'>
                                                    <button class='full-view-button'>Full View</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='date-time'>
                                            <p>$date</p>
                                    </div>";
                                    if ($StrictMode == "Enabled") {
                                        echo "<p style='color: red; margin: 20px'>
                                        NOTE: Please be advised that the employer requires the Expertise Mode enabled. Only applicants with a minimum of five years less than the specified years of experience are eligible to apply.</p>";
                                    }
                                echo "
                                    <hr class='content-divider'>
                                    <div class='job-info'>
                                        <div class='name-location'>
                                            <div class='name'>
                                                <h1>$jobTitle</h1>
                                                <p>$jobLocation</p>
                                            </div>
                                        </div>
                                        <div class='tags'>
                                            <div class='tags-row'>
                                                <div class='tags-cell'>
                                                    <button id='tag-element'>$industryTag</button>
                                                </div>
                                            </div>
                                            <div class='tags-row'>
                                                <div class='tags-cell'>
                                                    <button id='tag-element'>$countryTag</button>
                                                </div>
                                            </div>
                                            <div class='tags-row'>
                                                <div class='tags-cell'>
                                                    <button id='tag-element'>$typeTag</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='description'>
                                            <div class='description-heading'>
                                                <h2>Job Details</h2>
                                            </div>
                                            <div class='description-text'>
                                                <p>$jobDetails</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>";
                    }
                    ?>
                <div class="popup-container" id="popupContainer">
                    <div class="popup-content">
                        <div class="popup-heading">
                            <h3>Notifications</h3>
                            <form method="post" action="http://localhost/Resumeister/admin/php/mail/user/update-status.php">
                                <button class="submit" name="submi"><i class="fa-regular fa-envelope-open"></i></button>
                            </form>
                        </div>
                        <hr>
                        <div class="notification-content">
                            <div class="notification-row">
                                <?php
                                    while ($NotificationRow = mysqli_fetch_assoc($resultNotification)) {
                                        $NotificationID = $NotificationRow['NotificationID'];
                                        $NotificationSubject = $NotificationRow['NotificationSubject'];
                                        $NotificationContent =  substr($NotificationRow['NotificationContent'], 0, 90);
                                        $NotificationStatus = $NotificationRow['Status'];
                                        $NotificationDate = $NotificationRow['NotificationDate'];
                                        if ($NotificationStatus == "Unread") {
                                             echo "<a href='http://localhost/Resumeister/user/full.php?mail=$NotificationID'>";
                                                echo "<div class='notification-item'>";
                                                    echo "<div class='notification-picture'>";
                                                        echo "<i class='fa-solid fa-circle-exclamation'></i>";
                                                    echo "</div>";
                                                    echo "<div class='name-content'>";
                                                        echo "<div class='heading-date'>
                                                            <h4>$NotificationSubject</h4>
                                                            <h4>$NotificationDate</h4>
                                                        </div>";
                                                        echo "<p style='font-weight: bold;'>$NotificationContent...</p>";
                                                    echo "</div>";
                                                echo "</div>"; 
                                                echo "</a>";
                                            }
                                            else if ($NotificationStatus == "Read") {
                                                echo "<a href='http://localhost/Resumeister/user/full.php?mail=$NotificationID'>";
                                                 echo "<div class='notification-item'>";
                                                    echo "<div class='notification-picture'>";
                                                        echo "<i class='fa-regular fa-circle-check'></i>";
                                                    echo "</div>";
                                                    echo "<div class='name-content'>";
                                                        echo "<div class='heading-date'>
                                                            <h4>$NotificationSubject</h4>
                                                            <h4>$NotificationDate</h4>
                                                        </div>";
                                                        echo "<p style='color: gray;'>$NotificationContent...</p>";
                                                    echo "</div>";
                                                echo "</div>"; 
                                                echo "</a>";
                                            }
                                        }
                                    ?>
                            </div>
                        </div>
                        <hr>
                        <div class="popup-footer">
                            <a href="http://localhost/Resumeister/user/inbox.php">
                                <h3>View all notifications</h3>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column-b">
                <div class="menu-container">
                    <div class="menu">
                        <div class="menu-heading">
                            <h1>Personal Navigation</h1>
                        </div>
                        <div class="navigation">
                            <div class="icon-text">
                                <i class="fa-regular fa-file" id="applications"></i>
                                <p>Applications</p>
                            </div>
                            <div class="icon-text">
                                <i class="fa-regular fa-user" id="homepage"></i>
                                <p>Homepage</p>
                            </div>
                            <div class="icon-text">
                                <i class="fa-solid fa-cog" id="settings"></i>
                                <p>Settings</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="menu-container">
                    <div class="menu">
                        <div class="menu-heading">
                            <h1>Page Navigation</h1>
                        </div>
                        <div class="site-navigation">
                            <div class="search-bar">
                                <div class="searchInputWrapper">
                                    <form method="GET" action="jobs.php">
                                        <input id ="menu-search" name="search" class="menu-search" type="text" placeholder='...'>
                                        <i class="menu-search-icon fa fa-search"></i>
                                        <a href="http://localhost/Resumeister/jobs.php?search"><i id ="clear-button" class="fa-solid fa-xmark"></i></a>
                                    </form>
                                </div>
                            </div>
                            <?php
                                echo "<div class='pagination'>";
                                for ($i = 1; $i <= $totalPages; $i++) {
                                echo "<a href='http://localhost/Resumeister/jobs.php?page=$i'>$i</a> ";
                                }
                                echo "</div>";
                                ?>
                        </div>
                    </div>
                </div>
                <div class="menu-container">
                    <div class="menu">
                        <div class="menu-heading">
                            <h1>Filter</h1>
                            <i id="filterBtn" class="fa-solid fa-filter"></i>
                        </div>
                        <form id="filterForm" method="GET" action="jobs.php?<?php echo http_build_query(array_merge($_GET, ['page' => $currentPage])); ?>">
                            <div class="filter">
                                <div class="filter-list">
                                    <input type="checkbox" name="matchWithExperience" <?php echo isset($_GET['matchWithExperience']) ? 'checked' : ''; ?>>
                                    <label class="label">Match with Years of Experience</label>
                                </div>
                                <div class="filter-list">
                                    <input type="checkbox" name="matchWithEducation">
                                    <label class="label">Match with Educational Attainment</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="menu-container">
                    <div class="menu">
                        <div class="menu-heading">
                            <h1>Recent Vacancies</h1>
                        </div>
                        <div class="recent-listings">
                            <?php
                                while ($row = mysqli_fetch_assoc($resultRecent)) {
                                    $jobTitle = $row['JobTitle'];
                                    $companyName = $row['CompanyName'];
                                    $agencyName = $row['ParentAgencyName'];
                                    $companyLogo = $row['ImgPath'];
                                    $country = $row['CountryTag'];
                                    $jobID =$row['JobListingID'];
                                
                                    echo "<a href='http://localhost/Resumeister/jobs/full.php?listing=$jobID'>
                                              <div class='job-listing-item'>
                                            <div class='recent-image'>
                                                <img src ='http://localhost/Resumeister/assets/$companyLogo'>
                                            </div>
                                            <div class='recent-text'>
                                                <h3><strong>$jobTitle</strong></h3> 
                                                <p>$companyName - $country</p>
                                            </div>
                                        </div>
                                              </a>";
                                }
                                ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            const bellIcon = document.querySelector('.fa-bell');
            const popupContainer = document.getElementById('popupContainer');
            let isMouseInBellIcon = false;
            let isMouseInPopupContainer = false;
            bellIcon.addEventListener('mouseenter', () => {
                isMouseInBellIcon = true;
                showPopup();
            });
            bellIcon.addEventListener('mouseleave', () => {
                isMouseInBellIcon = false;
                hidePopup();
            });
            popupContainer.addEventListener('mouseenter', () => {
                isMouseInPopupContainer = true;
                showPopup();
            });
            popupContainer.addEventListener('mouseleave', () => {
                isMouseInPopupContainer = false;
                hidePopup();
            });
            
            function showPopup() {
                if (isMouseInBellIcon || isMouseInPopupContainer) {
                    const bellIconRect = bellIcon.getBoundingClientRect();
                    popupContainer.style.left = bellIconRect.left - 530 + 'px';
                    popupContainer.style.top = bellIconRect.bottom + 'px';
                    popupContainer.style.display = 'block';
                }
            }
            
            function hidePopup() {
                if (!isMouseInBellIcon && !isMouseInPopupContainer) {
                    popupContainer.style.display = 'none';
                }
            }
            document.getElementById('filterBtn').addEventListener('click', function() {
                document.getElementById('filterForm').submit();
            });
        </script>
    </body>
</html>
<?php 
mysqli_close($connect); 
?>