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

class JournalController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Journal::with(['author', 'category', 'institution', 'faculty', 'department']);

        // Filter berdasarkan role
        if (Auth::user()->isMember()) {
            $query->where('author_id', Auth::id());
        }

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
                  ->orWhere('keyword', 'LIKE', "%{$request->search}%");
            });
        }

        $journals = $query->paginate(10);
        $categories = JournalCategory::all();

        return view('journals.index', compact('journals', 'categories'));
    }

    public function create()
    {
        $this->authorize('create', Journal::class);

        $categories = JournalCategory::all();
        $institutions = Institution::where('status', 'aktif')->get();
        $faculties = Faculty::where('status', 'aktif')->get();
        $departments = Department::all();

        return view('journals.create', compact('categories', 'institutions', 'faculties', 'departments'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Journal::class);

        $request->validate([
            'journal_name' => 'required|string|max:255',
            'abstract' => 'required|string',
            'keyword' => 'required|string',
            'category_id' => 'required|exists:journal_categories,id',
            'institution_code' => 'required|exists:institutions,institution_code',
            'faculty_code' => 'required|exists:faculties,faculty_code',
            'department_code' => 'required|exists:departments,department_code',
            'pdf_file' => 'required|file|mimes:pdf|max:10240',
            'other_document_file' => 'nullable|file|max:10240',
            'language' => 'required|in:id,en,es,fr,de,ja,ko,pt,ru,zh',
            'status' => 'required|in:draft,submitted,under_review,accepted,published,rejected',
        ]);

        $data = $request->all();
        $data['author_id'] = Auth::id();
        $data['slug'] = Str::slug($request->journal_name . '-' . time());

        // Upload PDF file
        if ($request->hasFile('pdf_file')) {
            $data['pdf_file'] = $request->file('pdf_file')->store('journals/pdf', 'public');
        }

        // Upload other document file
        if ($request->hasFile('other_document_file')) {
            $data['other_document_file'] = $request->file('other_document_file')->store('journals/documents', 'public');
        }

        $journal = Journal::create($data);

        return redirect()->route('journals.show', $journal)->with('success', 'Journal berhasil dibuat!');
    }

    public function show(Journal $journal)
    {
        $journal->load(['author', 'category', 'institution', 'faculty', 'department', 'journalAuthors']);
        $journal->incrementViews();

        return view('journals.show', compact('journal'));
    }

    public function edit(Journal $journal)
    {
        $this->authorize('update', $journal);

        $categories = JournalCategory::all();
        $institutions = Institution::where('status', 'aktif')->get();
        $faculties = Faculty::where('status', 'aktif')->get();
        $departments = Department::all();

        return view('journals.edit', compact('journal', 'categories', 'institutions', 'faculties', 'departments'));
    }

    public function update(Request $request, Journal $journal)
    {
        $this->authorize('update', $journal);

        $request->validate([
            'journal_name' => 'required|string|max:255',
            'abstract' => 'required|string',
            'keyword' => 'required|string',
            'category_id' => 'required|exists:journal_categories,id',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'other_document_file' => 'nullable|file|max:10240',
            'language' => 'required|in:id,en,es,fr,de,ja,ko,pt,ru,zh',
            'status' => 'required|in:draft,submitted,under_review,accepted,published,rejected',
        ]);

        $data = $request->all();

        // Update PDF file if new file uploaded
        if ($request->hasFile('pdf_file')) {
            // Delete old file
            if ($journal->pdf_file) {
                Storage::disk('public')->delete($journal->pdf_file);
            }
            $data['pdf_file'] = $request->file('pdf_file')->store('journals/pdf', 'public');
        }

        // Update other document file if new file uploaded
        if ($request->hasFile('other_document_file')) {
            // Delete old file
            if ($journal->other_document_file) {
                Storage::disk('public')->delete($journal->other_document_file);
            }
            $data['other_document_file'] = $request->file('other_document_file')->store('journals/documents', 'public');
        }

        $journal->update($data);

        return redirect()->route('journals.show', $journal)->with('success', 'Journal berhasil diupdate!');
    }

    public function destroy(Journal $journal)
    {
        $this->authorize('delete', $journal);

        // Delete files
        if ($journal->pdf_file) {
            Storage::disk('public')->delete($journal->pdf_file);
        }
        if ($journal->other_document_file) {
            Storage::disk('public')->delete($journal->other_document_file);
        }

        $journal->delete();

        return redirect()->route('journals.index')->with('success', 'Journal berhasil dihapus!');
    }

    public function download(Journal $journal)
    {
        if (!$journal->pdf_file || !Storage::disk('public')->exists($journal->pdf_file)) {
            return redirect()->back()->with('error', 'File tidak ditemukan!');
        }

        $journal->incrementDownloads();

        return Storage::disk('public')->download($journal->pdf_file, $journal->journal_name . '.pdf');
    }

    public function publish(Journal $journal)
    {
        $this->authorize('publish', $journal);

        $journal->update(['status' => 'published', 'publication_date' => now()]);

        return redirect()->back()->with('success', 'Journal berhasil dipublish!');
    }

}
