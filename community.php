<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
require_once 'includes/community_functions.php';

$userData = getUserProfile($connect, $UserID);
$base64Image = base64_encode($userData['Picture']);
$YearExperience = $userData['TotalYears'];
$UserPhoto = $userData['PicturePath'];
$DisplayName = $userData['DisplayName'];

$resultPost = getCommunityPosts($connect);
$resultNotification = getNotifications($connect, $UserID);
$resultRecent = getRecentJobListings($connect);
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
                            <li><a href="http://localhost/Resumeister/jobs.php">Jobs</a></li>
                            <li class="current"><a href="http://localhost/Resumeister/community.php">Community</a></li>
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
                <div class='content-container'>
                    <div class="post-container">
                        <div class="post-container-header">
                            <div class="create-post">
                                <div class="profile-picture" style="background-image: url(data:image/jpeg;base64,<?php echo $base64Image; ?>)">
                                </div>
                                <div class="create-post-input">
                                    <input class="create" placeholder="Engage with the community as '<?php echo $DisplayName;?>'" onclick="openNewPost()">
                                </div>
                            </div>
                            <hr>
                            <div class="text-boxes-container">
                                <?php
                                    while($postRow = mysqli_fetch_assoc($resultPost)) {
                                        $PostID = $postRow['PostID'];
                                        $PosterName = $postRow['PosterName'];
                                        $PostDate = $postRow['DatePost'];
                                        $PostTitle = $postRow['Title'];
                                        $PostContent = $postRow['Content'];
                                        $PostPicture = $postRow['UserPicturePath'];
                                    echo '
                                            <a href="http://localhost/Resumeister/community/article.php?article='. $PostID .'">
                                        <div class="text-box">
                                            <div class="post-head">
                                                <div class="post-head-left">
                                                    <div class="profile-name">
                                                         <div class="profile-picture" style="background-image: url(http://localhost/Resumeister/assets/profile-photo/user/' . $PostPicture . ');">
                                                        </div>
                                                        <div class="user-name">
                                                            <h4>'.$PosterName . '</h4>
                                                            <p>'.$PostDate .'</p>
                                    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="post-head-right">
                                                    <i class="fa-regular fa-bell"></i>
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </div>
                                            </div>
                                            <div class="post-body">
                                                <h2>'.$PostTitle.'</h2>
                                                <p>'. $PostContent.'</p>
                                                <hr>
                                                <div class="engagement-icons">
                                                    <div class="engagement-item">
                                                        <i class="fa-regular fa-heart"></i>
                                                        <p>Like</p>
                                                    </div>
                                                    <div class="engagement-item">
                                                        <i class="fa-regular fa-comments"></i>
                                                        <p>Comment</p>
                                                    </div>
                                                    <div class="engagement-item">
                                                        <i class="fa-regular fa-share-from-square"></i>
                                                        <p>Share</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </a>';
                                    }
                                    ?>
                                <div class="new-post" id="new-post" style="display:none">
                                    <form method="post" action="http://localhost/Resumeister/admin/php/user/new-post.php">
                                        <input type="text" name="UserID" value="<?php echo $UserID; ?>" style="display:none;">
                                        <input type="text" name ="PicturePath" value="<?php echo $UserPhoto?>" style="display:none;">
                                        <div class="new-post-container">
                                            <div class="new-post-heading">
                                                <h1>Community Post</h1>
                                                <i class="fa-solid fa-circle-xmark" onclick="openNewPost()"></i>
                                            </div>
                                            <hr>
                                            <div class="new-post-input">
                                                <label for="Title">Title</label>
                                                <input type="text" name="Title" placeholder="Add title">
                                                <br><br>
                                            </div>
                                            <div class="new-post-input">
                                                <label for="Content">Content</label>
                                                <br>
                                                <textarea name="Content">Add text</textarea>
                                                <br>
                                            </div>
                                            <div class="submit-post">
                                                <button class="submit" name="submit">Create Post</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="overlay" id="overlay" style="display:none">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                        <div class="button-container">
                            <button class="create-button" onclick="openNewPost()">Create Post<i class="fa-solid fa-pen-nib"></i></button>
                        </div>
                    </div>
                </div>
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
                            <h1>Interest Corners</h1>
                        </div>
                        <div class="interest-corner">
                            <div class="interest-item">
                                <div class="interest">
                                    <img src="https://previews.123rf.com/images/timplaruovidiu/timplaruovidiu1905/timplaruovidiu190500305/122163766-recruiting-concept-human-resource-hiring-concept-for-banner-web-page-presentation-iluustration-in.jpg">
                                </div>
                                <div class="interest-text">
                                    <h3>Ask a Recruiter</h3>
                                </div>
                            </div>
                            <div class="interest-item">
                                <div class="interest">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/7/76/Map_Flags_of_the_Middle_East.png">
                                </div>
                                <div class="interest-text">
                                    <h3>Middle East Applicants</h3>
                                </div>
                            </div>
                            <div class="interest-item">
                                <div class="interest">
                                    <img src="https://i.pinimg.com/564x/72/56/a4/7256a4673ca4077713c8568ee797cb5c.jpg">
                                </div>
                                <div class="interest-text">
                                    <h3>Tech Board</h3>
                                </div>
                            </div>
                        </div>
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
            
            function openNewPost() {
            const postBox = document.getElementById('new-post');
            const overlay = document.getElementById('overlay');
            if (postBox.style.display === 'none' || postBox.style.display === '') {
                postBox.style.display = 'block';
                overlay.style.display = 'block';
            } else {
                postBox.style.display = 'none';
                overlay.style.display = 'none';
            }
            }
            
        </script>
    </body>
</html>
<?php 
    mysqli_close($connect); 
?>