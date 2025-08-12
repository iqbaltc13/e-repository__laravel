<?php

namespace App\Observers;

use App\Models\Journal;
use Illuminate\Support\Facades\Log;

class JournalObserver
{
    //
    public function creating(Journal $journal): void
    {
        // Set default values
        if (empty($journal->views_count)) {
            $journal->views_count = 0;
        }
        if (empty($journal->downloads_count)) {
            $journal->downloads_count = 0;
        }
        if (empty($journal->revision_number)) {
            $journal->revision_number = 0;
        }
    }

    public function created(Journal $journal): void
    {
        Log::info("Journal created: {$journal->journal_name} by user {$journal->author->fullname}");
    }

    public function updated(Journal $journal): void
    {
        if ($journal->wasChanged('status')) {
            Log::info("Journal status changed: {$journal->journal_name} from {$journal->getOriginal('status')} to {$journal->status}");
        }
    }

    public function deleted(Journal $journal): void
    {
        Log::info("Journal deleted: {$journal->journal_name}");
    }
}
