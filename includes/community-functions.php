<?php
function getCommunityPosts($connect) {
    $query = "SELECT post.PostID, post.Title, post.Content, post.DatePost, post.TimePost,
              user.DisplayName AS PosterName, user.UserID, user.PicturePath AS UserPicturePath
              FROM post
              LEFT JOIN user ON post.UserID = user.UserID 
              ORDER BY post.DatePost DESC, post.TimePost DESC";
    return mysqli_query($connect, $query);
}

function getUserProfile($connect, $UserID) {
    $query = "SELECT * FROM user WHERE UserID = $UserID";
    $result = mysqli_query($connect, $query);
    return mysqli_fetch_assoc($result);
}

function getRecentJobListings($connect, $limit = 5) {
    $query = "SELECT * FROM joblisting WHERE Status != 'Inactive' ORDER BY ListingDate DESC, ListingTime DESC LIMIT $limit";
    return mysqli_query($connect, $query);
}

function getNotifications($connect, $UserID) {
    $query = "SELECT * FROM notification WHERE UserID = $UserID ORDER BY NotificationDate DESC, NotificationTime DESC";
    return mysqli_query($connect, $query);
}
?>