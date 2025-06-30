<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\JobListing;
use App\Models\User;
use App\Models\Notification;

class CommunityController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $searchQuery = $request->input('search', '');
        $matchWithExperience = $request->has('matchWithExperience');
        $currentPage = $request->input('page', 1);
        $resultsPerPage = 5;
        
        $posts = Post::with('user')
                    ->orderBy('DatePost', 'desc')
                    ->orderBy('TimePost', 'desc')
                    ->paginate($resultsPerPage);
        
        $notifications = Notification::where('UserID', $user->UserID)
                                    ->orderBy('NotificationDate', 'desc')
                                    ->orderBy('NotificationTime', 'desc')
                                    ->get();
        
        $recentJobs = JobListing::where('Status', '!=', 'Inactive')
                                ->orderBy('ListingDate', 'desc')
                                ->orderBy('ListingTime', 'desc')
                                ->limit(5)
                                ->get();
        
        return view('community.index', compact(
            'posts',
            'notifications',
            'recentJobs',
            'user'
        ));
    }
    
    public function storePost(Request $request)
    {
        $request->validate([
            'Title' => 'required',
            'Content' => 'required',
        ]);
        
        Post::create([
            'UserID' => auth()->id(),
            'Title' => $request->Title,
            'Content' => $request->Content,
            'DatePost' => now()->format('Y-m-d'),
            'TimePost' => now()->format('H:i:s'),
        ]);
        
        return back()->with('success', 'Post created successfully');
    }
    
    public function storeComment(Request $request)
    {
        $request->validate([
            'Comment' => 'required',
            'PostID' => 'required|exists:posts,PostID',
        ]);
        
        Comment::create([
            'UserID' => auth()->id(),
            'PostID' => $request->PostID,
            'Comment' => $request->Comment,
            'DateComment' => now()->format('Y-m-d'),
            'TimeComment' => now()->format('H:i:s'),
        ]);
        
        return back()->with('success', 'Comment added successfully');
    }
    
    public function storeReply(Request $request)
    {
        $request->validate([
            'Reply' => 'required',
            'CommentID' => 'required|exists:comments,CommentID',
        ]);
        
        Reply::create([
            'UserID' => auth()->id(),
            'CommentID' => $request->CommentID,
            'Reply' => $request->Reply,
            'DateReply' => now()->format('Y-m-d'),
            'TimeReply' => now()->format('H:i:s'),
        ]);
        
        return back()->with('success', 'Reply added successfully');
    }
}