<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\JournalCategory;
use App\Models\Institution;
use App\Models\Faculty;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;
use Intervention\Image\Colors\Rgb\Channels\Red;

class JournalPublicController extends Controller
{
    //


    public function index(Request $request)
    {
        $query = Journal::with(['author','coAuthors', 'category', 'universitas', 'faculty', 'department'])->whereNotNull('journal_name');



        // Filter berdasarkan parameter
        $status = 'published';
        if ($request->status) {
            $status = $request->status;
        }
        $query->where('status', $status);
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('journal_name', 'LIKE', "%{$request->search}%")
                  ->orWhere('abstract', 'LIKE', "%{$request->search}%")
                  ->orWhere('keywords', 'LIKE', "%{$request->search}%");
            });
        }

        $journals = $query->paginate(10);
        $categories = JournalCategory::all();

        $totalJournals = Journal::whereNotNull('journal_name')->whereIn('status', [ 'submitted',  'published'])->count();
        $totalUsers = User::where('role','|=' ,'admin')->count();
        $totalCategories = JournalCategory::count();
        $totalInstitutions = Institution::count();

        // User specific stats

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
            ->whereIn('status', [ 'published'])
            ->orderBy('views_count', 'desc')
            ->limit(5)
            ->get();



        return view('journals_public.index', compact('journals', 'categories', 'totalJournals', 'totalUsers', 'totalCategories', 'totalInstitutions',
            'publishedJournals', 'underReviewJournals',
            'recentJournals', 'popularJournals','submittedJournals'));
    }


    public function show(Journal $journal)
    {
        $journal->load(['author', 'category', 'universitas', 'faculty', 'department', 'coAuthors']);
        $journal->incrementViews();
        $filesPendukung  = isset($journal->other_document_file) ? explode('|', $journal->other_document_file) : [];
        return view('journals_public.show', compact('journal', 'filesPendukung'));
    }



    public function download(Journal $journal)
    {
        if (!$journal->pdf_file ) {
            return redirect()->back()->with('error', 'File tidak ditemukan!');
        }

        $journal->incrementDownloads();

        return redirect()->away($journal->pdf_file);

    }

    public function dashboard(Request $request)
    {


        // Statistics
        $totalJournals = Journal::whereNotNull('journal_name')->whereIn('status', [ 'submitted',  'published'])->count();
        $totalUsers = User::where('role','|=' ,'admin')->count();
        $totalCategories = JournalCategory::count();
        $totalInstitutions = Institution::count();

        // User specific stats

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

        return view('journals_public.dashboard', compact(
            'totalJournals', 'totalUsers', 'totalCategories', 'totalInstitutions',
            'publishedJournals', 'underReviewJournals',
            'recentJournals', 'popularJournals','submittedJournals'
        ));
    }



}
