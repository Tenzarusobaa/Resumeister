<?php
// includes/notifications.php
function getNotifications($connect, $UserID) {
    $query = "SELECT * FROM notification 
              WHERE UserID = $UserID 
              ORDER BY NotificationDate DESC, NotificationTime DESC";
    return mysqli_query($connect, $query);
}
?>