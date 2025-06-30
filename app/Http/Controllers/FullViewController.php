<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobListing;
use App\Models\User;
use App\Models\Existing;
use App\Models\Notification;

class FullViewController extends Controller
{
    public function show(Request $request)
    {
        $jobID = $request->input('listing');
        $user = auth()->user();
        
        if (!$jobID) {
            return redirect()->route('error');
        }
        
        $job = JobListing::find($jobID);
        
        if (!$job) {
            return redirect()->route('error');
        }
        
        $applicationExists = Existing::where('UserID', $user->UserID)
                                    ->where('JobListingID', $jobID)
                                    ->exists();
        
        $notifications = Notification::where('UserID', $user->UserID)
                                    ->orderBy('NotificationDate', 'desc')
                                    ->orderBy('NotificationTime', 'desc')
                                    ->get();
        
        $recentJobs = JobListing::where('Status', '!=', 'Inactive')
                                ->orderBy('ListingDate', 'desc')
                                ->orderBy('ListingTime', 'desc')
                                ->limit(5)
                                ->get();
        
        return view('jobs.full', compact(
            'job',
            'applicationExists',
            'notifications',
            'recentJobs',
            'user'
        ));
    }
}