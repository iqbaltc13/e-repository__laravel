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
        $totalJournals = Journal::whereNotNull('journal_name')->whereIn('status', [ 'submitted',  'published'])->count();
        $totalUsers = User::where('role','|=' ,'admin')->count();
        $totalCategories = JournalCategory::count();
        $totalInstitutions = Institution::count();

        // User specific stats
        $userJournals = $user->journals()->count();
        $publishedJournals = Journal::whereNotNull('journal_name')->where('status', 'published')->count();
        $underReviewJournals = Journal::whereNotNull('journal_name')->where('status', 'under_review')->count();
        $submittedJournals = Journal::whereNotNull('journal_name')->where('status', 'submitted')->count();
        // Recent journals
        $recentJournals = Journal::with(['author', 'category'])->whereNotNull('journal_name')->whereIn('status', [ 'submitted',  'published'])
            ->latest()
            ->limit(5)
            ->get();

        // Most viewed journals
        $popularJournals = Journal::with(['author', 'category'])
            ->whereNotNull('journal_name')
            ->whereIn('status', [ 'submitted',  'published'])
            ->orderBy('views_count', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalJournals', 'totalUsers', 'totalCategories', 'totalInstitutions',
            'userJournals', 'publishedJournals', 'underReviewJournals',
            'recentJournals', 'popularJournals','submittedJournals'
        ));
    }

    public function indexUser()
    {
        $user = auth()->user();

        $stats = [];

        if ($user->isAdmin()) {
            $stats = [
                'total_users' => User::count(),
                'total_admins' => User::where('role', 'admin')->count(),
                'total_editors' => User::where('role', 'editor')->count(),
                'total_members' => User::where('role', 'member')->count(),
                'verified_users' => User::whereNotNull('email_verified_at')->count(),
                'unverified_users' => User::whereNull('email_verified_at')->count(),
                'recent_users' => User::latest()->take(5)->get(),
            ];
        }

        return view('dashboard', compact('user', 'stats'));
    }
}
