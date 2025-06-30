<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobListing;
use App\Models\User;
use App\Models\Notification;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $searchQuery = $request->input('search', '');
        $matchWithExperience = $request->has('matchWithExperience');
        $currentPage = $request->input('page', 1);
        $resultsPerPage = 5;
        
        $query = JobListing::where('Status', '!=', 'Inactive');
        
        if (!empty($searchQuery)) {
            $query->where(function($q) use ($searchQuery) {
                $q->where('JobTitle', 'like', "%$searchQuery%")
                  ->orWhere('CompanyName', 'like', "%$searchQuery%")
                  ->orWhere('JobLocation', 'like', "%$searchQuery%")
                  ->orWhere('IndustryTag', 'like', "%$searchQuery%")
                  ->orWhere('CountryTag', 'like', "%$searchQuery%")
                  ->orWhere('TypeTag', 'like', "%$searchQuery%");
            });
        }
        
        if ($matchWithExperience) {
            $query->where('YearsRequired', '<=', $user->TotalYears);
        }
        
        $totalCount = $query->count();
        $totalPages = ceil($totalCount / $resultsPerPage);
        
        $jobListings = $query->orderBy('ListingDate', 'desc')
                            ->orderBy('ListingTime', 'desc')
                            ->skip(($currentPage - 1) * $resultsPerPage)
                            ->take($resultsPerPage)
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
        
        return view('jobs.index', compact(
            'jobListings',
            'notifications',
            'recentJobs',
            'totalPages',
            'currentPage',
            'searchQuery',
            'matchWithExperience',
            'user'
        ));
    }
    
    public function apply(Request $request)
    {
        $user = auth()->user();
        $jobID = $request->input('listing');
        
        $existing = Existing::where('UserID', $user->UserID)
                            ->where('JobListingID', $jobID)
                            ->exists();
        
        if ($existing) {
            return back()->with('error', 'Application already exists');
        }
        
        $job = JobListing::find($jobID);
        
        if ($job->StrictMode == "Enabled" && $user->TotalYears < 5) {
            return back()->with('error', 'Insufficient experience for this job');
        }
        
        Existing::create([
            'UserID' => $user->UserID,
            'JobListingID' => $jobID
        ]);
        
        return back()->with('success', 'Application submitted successfully');
    }
}