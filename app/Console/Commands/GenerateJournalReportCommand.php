<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Journal;
use App\Models\User;
use Carbon\Carbon;

class GenerateJournalReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'journal:report {--period=monthly}';
    protected $description = 'Generate journal submission and activity report';

    public function handle()
    {
        $period = $this->option('period');

        $this->info("Generating {$period} journal report...");

        $startDate = match($period) {
            'daily' => Carbon::today(),
            'weekly' => Carbon::now()->startOfWeek(),
            'monthly' => Carbon::now()->startOfMonth(),
            'yearly' => Carbon::now()->startOfYear(),
            default => Carbon::now()->startOfMonth()
        };

        $journals = Journal::where('created_at', '>=', $startDate)->get();
        $totalSubmissions = $journals->count();
        $publishedCount = $journals->where('status', 'published')->count();
        $underReviewCount = $journals->where('status', 'under_review')->count();

        $this->table(
            ['Metric', 'Count'],
            [
                ['Total Submissions', $totalSubmissions],
                ['Published', $publishedCount],
                ['Under Review', $underReviewCount],
                ['Total Downloads', $journals->sum('downloads_count')],
                ['Total Views', $journals->sum('views_count')],
            ]
        );

        // Top authors by submission count
        $topAuthors = User::withCount(['journals' => function($query) use ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }])
        ->having('journals_count', '>', 0)
        ->orderBy('journals_count', 'desc')
        ->limit(5)
        ->get();

        if ($topAuthors->count() > 0) {
            $this->info("\nTop Authors (by submission count):");
            $this->table(
                ['Author', 'Submissions'],
                $topAuthors->map(fn($author) => [$author->fullname, $author->journals_count])
            );
        }

        $this->info("\nReport generated successfully!");
    }
}
