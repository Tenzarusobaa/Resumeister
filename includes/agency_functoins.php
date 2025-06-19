<?php
function getAgencyName($connect, $AgencyID) {
    $query = "SELECT AgencyName FROM agency WHERE AgencyID = $AgencyID";
    $result = mysqli_query($connect, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['AgencyName'];
}

function getApplications($connect) {
    $query = "SELECT application.ApplicationID, application.UserID, user.FirstName AS UserName, 
              user.LastName AS FamilyName, agency.AgencyName, application.CompanyName, 
              application.ApplicationDate, application.Status, application.JobApplied, application.Resume
              FROM application 
              LEFT JOIN agency ON application.AgencyID = agency.AgencyID
              LEFT JOIN user ON application.UserID = user.UserID
              WHERE application.Status != 'Archived'";
    return mysqli_query($connect, $query);
}
?>