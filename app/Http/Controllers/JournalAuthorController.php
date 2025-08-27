<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\JournalAuthor;
use Illuminate\Http\Request;

class JournalAuthorController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Journal $journal)
    {
        //$this->authorize('view', $journal);

        $authors = $journal->coAuthors()->orderBy('order')->get();
        return view('journal-authors.index', compact('journal', 'authors'));
    }

    public function create(Journal $journal)
    {
        //$this->authorize('update', $journal);

        return view('journal-authors.create', compact('journal'));
    }

    public function store(Request $request, Journal $journal)
    {
        $this->authorize('update', $journal);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'institution' => 'required|string|max:255',
            'order' => 'required|integer|min:1',
            'is_corresponding' => 'boolean',
        ]);

        $journal->coAuthors()->create($request->all());

        return redirect()->route('journal-authors.index', $journal)->with('success', 'Author berhasil ditambahkan!');
    }

    public function edit(Journal $journal, JournalAuthor $journalAuthor)
    {
        //$this->authorize('update', $journal);

        return view('journal-authors.edit', compact('journal', 'journalAuthor'));
    }

    public function update(Request $request, Journal $journal, JournalAuthor $journalAuthor)
    {
        //$this->authorize('update', $journal);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'institution' => 'nullable|string|max:255',
            'order' => 'required|integer|min:1',
            'is_corresponding' => 'boolean',
        ]);

        $journalAuthor->update($request->all());

        return redirect()->route('journal-authors.index', $journal)->with('success', 'Author berhasil diupdate!');
    }

    public function destroy(Journal $journal, JournalAuthor $journalAuthor)
    {
        //$this->authorize('update', $journal);

        $journalAuthor->delete();

        return redirect()->route('journal-authors.index', $journal)->with('success', 'Author berhasil dihapus!');
    }
}
