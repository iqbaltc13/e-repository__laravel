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

class JournalPublicController extends Controller
{
    //


    public function index(Request $request)
    {
        $query = Journal::with(['author', 'category', 'universitas', 'faculty', 'department'])->whereNotNull('journal_name');



        // Filter berdasarkan parameter
        if ($request->status) {
            $query->where('status', $request->status);
        }

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


        return view('journals_public.index', compact('journals', 'categories'));
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


}
