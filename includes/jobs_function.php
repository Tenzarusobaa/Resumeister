<?php
// includes/job_functions.php
function getUserExperience($connect, $UserID) {
    $query = "SELECT TotalYears, Picture FROM user WHERE UserID = $UserID";
    $result = mysqli_query($connect, $query);
    return mysqli_fetch_assoc($result);
}

function getJobListings($connect, $UserID, $searchQuery = '', $matchWithExperience = false, $startFrom = 0, $resultsPerPage = 5) {
    $additionalQuery = '';
    
    if (!empty($searchQuery)) {
        $escapedSearchQuery = mysqli_real_escape_string($connect, $searchQuery);
        $additionalQuery = " AND (joblisting.JobTitle LIKE '%$escapedSearchQuery%' 
            OR joblisting.CompanyName LIKE '%$escapedSearchQuery%'
            OR joblisting.JobLocation LIKE '%$escapedSearchQuery%'
            OR joblisting.IndustryTag LIKE '%$escapedSearchQuery%'
            OR joblisting.CountryTag LIKE '%$escapedSearchQuery%'
            OR joblisting.TypeTag LIKE '%$escapedSearchQuery%')";
    }
    
    if ($matchWithExperience) {
        $userExp = getUserExperience($connect, $UserID)['TotalYears'];
        $query = "SELECT * FROM joblisting 
                 WHERE Status != 'Inactive' 
                 AND YearsRequired <= $userExp
                 $additionalQuery 
                 ORDER BY ListingDate DESC, ListingTime DESC";
    } else {
        $query = "SELECT * FROM joblisting 
                 WHERE Status != 'Inactive' 
                 $additionalQuery 
                 ORDER BY ListingDate DESC, ListingTime DESC 
                 LIMIT $startFrom, $resultsPerPage";
    }
    
    return mysqli_query($connect, $query);
}

function getTotalJobCount($connect, $searchQuery = '') {
    $additionalQuery = '';
    
    if (!empty($searchQuery)) {
        $escapedSearchQuery = mysqli_real_escape_string($connect, $searchQuery);
        $additionalQuery = " AND (JobTitle LIKE '%$escapedSearchQuery%' 
            OR CompanyName LIKE '%$escapedSearchQuery%'
            OR JobLocation LIKE '%$escapedSearchQuery%'
            OR IndustryTag LIKE '%$escapedSearchQuery%'
            OR CountryTag LIKE '%$escapedSearchQuery%'
            OR TypeTag LIKE '%$escapedSearchQuery%')";
    }
    
    $countQuery = "SELECT COUNT(*) as totalCount FROM joblisting WHERE Status != 'Inactive' $additionalQuery";
    $countResult = mysqli_query($connect, $countQuery);
    $countRow = mysqli_fetch_assoc($countResult);
    return $countRow['totalCount'];
}
?>