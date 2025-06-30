<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\User;
use App\Models\JobListing;
use App\Models\Notification;

class ArticleController extends Controller
{
    public function show(Request $request)
    {
        $articleID = $request->input('article');
        $user = auth()->user();
        
        $post = Post::with('user')->findOrFail($articleID);
        
        $comments = Comment::with(['user', 'replies.user'])
                        ->where('PostID', $articleID)
                        ->get();
        
        $notifications = Notification::where('UserID', $user->UserID)
                                    ->orderBy('NotificationDate', 'desc')
                                    ->orderBy('NotificationTime', 'desc')
                                    ->get();
        
        $recentJobs = JobListing::where('Status', '!=', 'Inactive')
                                ->orderBy('ListingDate', 'desc')
                                ->orderBy('ListingTime', 'desc')
                                ->limit(5)
                                ->get();
        
        return view('community.article', compact(
            'post',
            'comments',
            'notifications',
            'recentJobs',
            'user'
        ));
    }
}