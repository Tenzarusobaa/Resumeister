@extends('layouts.app')

@section('content')
<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/job-styles.css') }}">
        <link rel="stylesheet" href="{{ asset('css/article-styles.css') }}">
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
                <img src="{{ asset('assets/logo/header_logo.png') }}">
                <div class = "navigation_container">
                    <nav>
                        <ul>
                            <li><a href="{{ route('jobs') }}">Jobs</a></li>
                            <li class="current"><a href="{{ route('community') }}">Community</a></li>
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
                <a href="{{ route('user.profile') }}">
                    <div class="profile-picture" style="background-image: url(data:image/jpeg;base64,{{ base64_encode($user->Picture) }})">
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
                            <div class="article-container">
                                <div class="article-box">
                                    <div class="post-head">
                                        <div class="post-head-left">
                                            <div class="profile-name">
                                                <div class="profile-picture" style="background-image: url({{ asset('assets/profile-photo/user/' . $post->user->PicturePath) }});">
                                                </div>
                                                <div class="poster-name">
                                                    <h4>{{ $post->user->DisplayName }}</h4>
                                                    <p>{{ $post->DatePost }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-head-right">
                                            <i class="fa-regular fa-bell"></i>
                                            <i class="fa-solid fa-ellipsis"></i>
                                        </div>
                                    </div>
                                    <div class="post-body">
                                        <h2>{{ $post->Title }}</h2>
                                        <p>{{ $post->Content }}</p>
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
                                        <form method="post" action="{{ route('community.comment') }}">
                                            @csrf
                                            <input type="hidden" name="ArticleID" value="{{ $post->PostID }}">
                                            <div class="comment">
                                                <input type="hidden" name="PostID" value="{{ $post->PostID }}">
                                                <div class="profile-picture" style="background-image: url(data:image/jpeg;base64,{{ base64_encode($user->Picture) }})">
                                                </div>
                                                <div class="comment">
                                                    <textarea name="Comment" placeholder="Share your thoughts" onclick="showComment()"></textarea>
                                                    <br>
                                                </div>
                                            </div>
                                            <div class="new-comment" id="new-comment" style="display:none;">
                                                <br>
                                                <button class="new-comment">Comment</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @foreach($comments as $comment)
                                <div class="comment-section">
                                    <div class="post-head">
                                        <div class="post-head-left">
                                            <div class="profile-name">
                                                <div class="profile-picture" style="background-image: url({{ asset('assets/profile-photo/user/' . $comment->user->PicturePath) }});">
                                                </div>
                                                <div class="commenter-name">
                                                    <h4 style="margin-bottom: -15px">{{ $comment->user->DisplayName }}</h4>
                                                    <p>{{ $comment->DateComment }},{{ $comment->TimeComment }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-head-right">
                                            <i class="fa-solid fa-ellipsis"></i>
                                        </div>
                                    </div>
                                    <div class="article-body">
                                        <p>{{ $comment->CommentText }}</p>
                                        <div class="engagement-icons" style="margin-top: -20px">
                                            <div class="engagement-item">
                                                <i class="fa-regular fa-heart"></i>
                                                <p>Like</p>
                                                <input type="text" value="{{ $comment->CommentID }}" style="display:none;">
                                            </div>
                                            <a href="javascript:openReply({{ $comment->CommentID }})">
                                                <div class="engagement-item">
                                                    <i class="fa-regular fa-comments"></i>
                                                    <p>Reply</p>
                                                </div>
                                            </a>
                                            <div class="engagement-item">
                                                <i class="fa-regular fa-share-from-square"></i>
                                                <p>Share</p>
                                            </div>
                                        </div>
                                        <div id="reply-nest-{{ $comment->CommentID }}" style="display: none;">
                                            <form method="post" action="{{ route('community.reply') }}">
                                            @csrf
                                            <input type="hidden" name="ArticleID" value="{{ $post->PostID }}">
                                                <input type="hidden" name="CommentID" value="{{ $comment->CommentID }}">
                                                <input type="hidden" name="UserCommentReply" value="{{ $user->UserID }}">
                                                <div class="comment">
                                                    <div class="profile-picture" style="background-image: url(data:image/jpeg;base64,{{ base64_encode($user->Picture) }})">
                                                    </div>
                                                    <textarea name="Reply" placeholder="Share your thoughts" style="width: 400px"></textarea>
                                                    <br>
                                                </div>
                                                <div class="new-reply" id="new-reply">
                                                    <br>
                                                    <button class="new-reply">Reply</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="nested-replies">
                                            @foreach($comment->replies as $reply)
                                            <div class="reply-container">
                                                <div class="reply-head">
                                                    <div class="reply-head-left">
                                                        <div class="profile-name">
                                                            <div class="profile-picture" style="background-image: url({{ asset('assets/profile-photo/user/' . $reply->user->PicturePath) }});">
                                                            </div>
                                                            <div class="replier-name">
                                                                <h4 style="margin-bottom: -15px">{{ $reply->user->DisplayName }}</h4>
                                                                <p>{{ $reply->DateReply }},{{ $reply->TimeReply }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="reply-body">
                                                    <p style="margin-left: 30px; margin-right: 30px">{{ $reply->ReplyText }}</p>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <hr style="width: 90%">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
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
        function showComment() {
            const newComment = document.getElementById('new-comment');
            if (newComment.style.display === 'none' || newComment.style.display === '') {
                newComment.style.display = 'flex';
            } else {
                newComment.style.display = 'none';
            }
        }
        function openReply(commentID) {
            const replyNest = document.getElementById('reply-nest-' + commentID);
            console.log('reply' + commentID + 'found');
            if (replyNest.style.display === 'none' || replyNest.style.display === '') {
                replyNest.style.display = 'block';
            } else {
                replyNest.style.display = 'none';
            }
        }
    </script>
</html>
@endsection