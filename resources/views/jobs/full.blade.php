@extends('layouts.app')

@section('content')
<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/job-styles.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>
    <body>
        <header>
            <div class="header-container">
            <div class="site-logo">
                <a href="{{ route('jobs') }}">
                <img src="{{ asset('assets/img-bg/Resumeister.png') }}">
                </a>
                <div class = "navigation_container">
                <nav>
                    <ul>
                        <li><a href="{{ route('user.profile') }}">Homepage</a></li>
                        <li class="current"><a href="{{ route('user.documents') }}">Documents</a></li>
                        <li><a href="{{ route('user.career') }}">Career</a></li>
                        <li><a href="{{ route('user.inbox') }}">Inbox</a></li>
                        <li><a href="{{ route('user.settings') }}">Settings</a></li>
                    </ul>
                </nav>
            </div>
            </div>
            
           <div class="profile-section">
                <div class="utilities">
                    <i class="fa-solid fa-bell"></i>
                    <i class="fa-solid fa-envelope"></i>
                </div>
                    <a href="{{ route('user.profile') }}"><div class="profile-picture" style="background-image: url(data:image/jpeg;base64,{{ base64_encode($user->Picture) }})">
                    </div>
                </a>
            </div>
        </div>
        <div class="popup-container" id="popupContainer">
                        <div class="popup-content">
                            <div class="popup-heading">
                                <h3>Notifications</h3>
                                <form method="post" action="{{ route('notifications.markAsRead') }}">
                                    <button class="submit" name="submi"><i class="fa-regular fa-envelope-open"></i></button>
                                </form>
                            </div>
                            <hr>
                            <div class="notification-content">
                                <div class="notification-row">
                                    @foreach($notifications as $notification)
                                    <a href="{{ route('notifications.show', $notification->NotificationID) }}">
                                        <div class='notification-item'>
                                            <div class='notification-picture'>
                                                @if($notification->Status == "Unread")
                                                    <i class='fa-solid fa-circle-exclamation'></i>
                                                @else
                                                    <i class='fa-regular fa-circle-check'></i>
                                                @endif
                                            </div>
                                            <div class='name-content'>
                                                <div class='heading-date'>
                                                    <h4>{{ $notification->NotificationSubject }}</h4>
                                                    <h4>{{ $notification->NotificationDate }}</h4>
                                                </div>
                                                <p @if($notification->Status == "Unread") style='font-weight: bold;' @else style='color: gray;' @endif>
                                                    {{ substr($notification->NotificationContent, 0, 90) }}...
                                                </p>
                                            </div>
                                        </div> 
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                            <hr>
                            <div class="popup-footer">
                                <a href="{{ route('notifications.index') }}">
                                    <h3>View all notifications</h3>
                                </a>
                            </div>
                        </div>
                    </div>
        </header>
        <br><br>
        <div class="container">
            <div class="column-a">
                <div class="content-container">
                    <div class="content">
                        <div class="content-top-section">
                            <div class="company-profile-details">
                                <div class="company-image">
                                    <img src="{{ asset('assets/' . $job->ImgPath) }}">
                                    <h1></h1>
                                </div>
                                <div class="company-name">
                                    <h3>{{ $job->CompanyName }}</h3>
                                    <p>{{ $job->ParentAgencyName }}</p>
                                </div>
                            </div>
                            <div class="utility">
                                <div class="buttons">
                                    <div class="buttons">
                                        @if (!$applicationExists)
                                            @if ($job->StrictMode == "Enabled" && $user->TotalYears < 5)
                                                <button class="disabled-button" disabled>Insufficient Experience</button>
                                            @else
                                                <a href="{{ route('jobs.apply', ['listing' => $job->JobListingID]) }}">
                                                <button class="apply-button">Apply</button>
                                                </a>
                                            @endif
                                        @else
                                            <button class="disabled-button" disabled>Application Exists</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="date-time">
                            <p>{{ $job->ListingDate }}</p>
                        </div>
                        @if ($job->StrictMode == "Enabled")
                            <p style='color: red; margin: 20px'>
                            NOTE: Please be advised that the employer requires the Expertise Mode enabled. Only applicants with a minimum of five years less than the specified years of experience <strong>({{ $job->YearsRequired }})</strong> are eligible to apply.</p>
                        @endif
                        <hr class="content-divider">
                        <div class="job-info">
                            <div class="name-location">
                                <div class="name">
                                    <h1>{{ $job->JobTitle }}</h1>
                                    <p>{{ $job->JobLocation }}</p>
                                </div>
                            </div>
                            <div class="tags">
                                <div class="tags-row">
                                    <div class="tags-cell">
                                        <button id="tag-element">{{ $job->IndustryTag }}</button>
                                    </div>
                                </div>
                                <div class="tags-row">
                                    <div class="tags-cell">
                                        <button id="tag-element">{{ $job->CountryTag }}</button>
                                    </div>
                                </div>
                                <div class="tags-row">
                                    <div class="tags-cell">
                                        <button id="tag-element">{{ $job->TypeTag }}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="description">
                                <div class="description-heading">
                                    <h2>Job Details</h2>
                                </div>
                                <div class="description-text">
                                    <p>{{ $job->JobDetails }}</p>
                                </div>
                            </div>
                            <hr class="sub-content-divider">
                            <div class="description">
                                <div class="description-heading">
                                    <h2>Responsibilities</h2>
                                </div>
                                <div class="description-text">
                                    <ul>
                                        @foreach(explode(".", $job->Responsibilities) as $responsibility)
                                            <li>{{ $responsibility }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <hr class="sub-content-divider">
                            <div class="description">
                                <div class="description-heading">
                                    <h2>Qualifications</h2>
                                </div>
                                <div class="description-text">
                                    <ul>
                                        @foreach(explode(".", $job->Requirements) as $qualification)
                                            <li>{{ $qualification }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
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
                                    <form method="GET" action="{{ route('jobs') }}">
                                        <input id ="menu-search" name="search" class="menu-search" type="text" placeholder='...'>
                                        <i class="menu-search-icon fa fa-search"></i>
                                        <a href="{{ route('jobs') }}"><i id ="clear-button" class="fa-solid fa-xmark"></i></a>
                                    </form>
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
                            @foreach($recentJobs as $recentJob)
                            <a href="{{ route('jobs.full', ['listing' => $recentJob->JobListingID]) }}">
                                <div class='job-listing-item'>
                                    <div class='recent-image'>
                                        <img src ="{{ asset('assets/' . $recentJob->ImgPath) }}">
                                    </div>
                                    <div class='recent-text'>
                                        <h3><strong>{{ $recentJob->JobTitle }}</strong></h3> 
                                        <p>{{ $recentJob->CompanyName }} - {{ $recentJob->CountryTag }}</p>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
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
    </script>
</html>
@endsection