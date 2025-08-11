<?php

namespace App\Http\Controllers;

use App\Models\JournalCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class JournalCategoryController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:manage-categories');
    }

    public function index()
    {
        $categories = JournalCategory::paginate(10);
        return view('journal-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('journal-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:journal_categories',
            'description' => 'nullable|string',
        ]);

        JournalCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('journal-categories.index')->with('success', 'Kategori berhasil dibuat!');
    }

    public function show(JournalCategory $journalCategory)
    {
        $journals = $journalCategory->journals()->with(['author', 'faculty', 'department'])->paginate(10);
        return view('journal-categories.show', compact('journalCategory', 'journals'));
    }

    public function edit(JournalCategory $journalCategory)
    {
        return view('journal-categories.edit', compact('journalCategory'));
    }

    public function update(Request $request, JournalCategory $journalCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:journal_categories,name,' . $journalCategory->id,
            'description' => 'nullable|string',
        ]);

        $journalCategory->update([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('journal-categories.index')->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy(JournalCategory $journalCategory)
    {
        if ($journalCategory->journals()->count() > 0) {
            return redirect()->back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki jurnal!');
        }

        $journalCategory->delete();

        return redirect()->route('journal-categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
