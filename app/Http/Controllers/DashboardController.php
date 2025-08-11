<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\User;
use App\Models\JournalCategory;
use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        // Statistics
        $totalJournals = Journal::count();
        $totalUsers = User::where('role','|=' ,'admin')->count();
        $totalCategories = JournalCategory::count();
        $totalInstitutions = Institution::count();

        // User specific stats
        $userJournals = $user->journals()->count();
        $publishedJournals = Journal::where('status', 'published')->count();
        $underReviewJournals = Journal::where('status', 'under_review')->count();

        // Recent journals
        $recentJournals = Journal::with(['author', 'category'])
            ->latest()
            ->limit(5)
            ->get();

        // Most viewed journals
        $popularJournals = Journal::with(['author', 'category'])
            ->orderBy('views_count', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalJournals', 'totalUsers', 'totalCategories', 'totalInstitutions',
            'userJournals', 'publishedJournals', 'underReviewJournals',
            'recentJournals', 'popularJournals'
        ));
    }
}
