<?php
namespace App\Services;

use App\Models\Journal;
use App\Models\JournalAuthor;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class JournalService
{
    public function createJournal(array $data, UploadedFile $pdfFile, ?UploadedFile $otherFile = null): Journal
    {
        // Upload PDF file
        $data['pdf_file'] = $pdfFile->store('journals/pdf', 'public');

        // Upload other document if provided
        if ($otherFile) {
            $data['other_document_file'] = $otherFile->store('journals/documents', 'public');
        }

        // Generate slug
        $data['slug'] = $this->generateUniqueSlug($data['journal_name']);

        return Journal::create($data);
    }

    public function updateJournal(Journal $journal, array $data, ?UploadedFile $pdfFile = null, ?UploadedFile $otherFile = null): Journal
    {
        // Update PDF file if new file provided
        if ($pdfFile) {
            // Delete old file
            if ($journal->pdf_file) {
                Storage::disk('public')->delete($journal->pdf_file);
            }
            $data['pdf_file'] = $pdfFile->store('journals/pdf', 'public');
        }

        // Update other document file if new file provided
        if ($otherFile) {
            // Delete old file
            if ($journal->other_document_file) {
                Storage::disk('public')->delete($journal->other_document_file);
            }
            $data['other_document_file'] = $otherFile->store('journals/documents', 'public');
        }

        $journal->update($data);
        return $journal;
    }

    public function deleteJournal(Journal $journal): bool
    {
        // Delete associated files
        if ($journal->pdf_file) {
            Storage::disk('public')->delete($journal->pdf_file);
        }
        if ($journal->other_document_file) {
            Storage::disk('public')->delete($journal->other_document_file);
        }

        return $journal->delete();
    }

    public function publishJournal(Journal $journal): Journal
    {
        $journal->update([
            'status' => 'published',
            'publication_date' => now()
        ]);

        return $journal;
    }

    public function addAuthorToJournal(Journal $journal, array $authorData): JournalAuthor
    {
        return $journal->journalAuthors()->create($authorData);
    }

    public function reorderAuthors(Journal $journal, array $authorOrders): void
    {
        foreach ($authorOrders as $authorId => $order) {
            $journal->journalAuthors()->where('id', $authorId)->update(['order' => $order]);
        }
    }

    private function generateUniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (Journal::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function getJournalStatistics(): array
    {
        return [
            'total' => Journal::count(),
            'published' => Journal::where('status', 'published')->count(),
            'under_review' => Journal::where('status', 'under_review')->count(),
            'draft' => Journal::where('status', 'draft')->count(),
            'submitted' => Journal::where('status', 'submitted')->count(),
            'accepted' => Journal::where('status', 'accepted')->count(),
            'rejected' => Journal::where('status', 'rejected')->count(),
        ];
    }
}
