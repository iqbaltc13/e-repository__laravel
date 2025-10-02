<?php
namespace App\Helpers;

class JournalHelper
{
    public static function getStatusBadgeClass(string $status): string
    {
        return match($status) {
            'published' => 'success',
            'accepted' => 'info',
            'under_review' => 'warning',
            'submitted' => 'primary',
            'rejected' => 'danger',
            'draft' => 'secondary',
            default => 'secondary'
        };
    }

    public static function getStatusLabel(string $status): string
    {
        return match($status) {
            'published' => 'Dipublikasi',
            'accepted' => 'Diterima',
            'under_review' => 'Sedang Review',
            'submitted' => 'Disubmit',
            'rejected' => 'Ditolak',
            'draft' => 'Draft',
            default => ucfirst($status)
        };
    }

    public static function getLanguageLabel(string $language): string
    {
        return match($language) {
            'id' => 'Indonesia',
            'en' => 'English',
            'es' => 'Español',
            'fr' => 'Français',
            'de' => 'Deutsch',
            'ja' => '日本語',
            'ko' => '한국어',
            'pt' => 'Português',
            'ru' => 'Русский',
            'zh' => '中文',
            default => strtoupper($language)
        ];
    }

    public static function formatFileSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $unitIndex = 0;

        while ($bytes >= 1024 && $unitIndex < count($units) - 1) {
            $bytes /= 1024;
            $unitIndex++;
        }

        return round($bytes, 2) . ' ' . $units[$unitIndex];
    }

    public static function generateCitation(Journal $journal, string $format = 'apa'): string
    {
        $authors = $journal->journalAuthors->sortBy('order');
        $authorNames = $authors->map(function ($author) {
            return $author->last_name . ', ' . substr($author->first_name, 0, 1) . '.';
        })->join(', ');

        if ($authorNames === '') {
            $authorNames = $journal->author->fullname;
        }

        $year = $journal->publication_date ? $journal->publication_date->format('Y') : $journal->created_at->format('Y');
        $title = $journal->journal_name;
        $institution = $journal->institution->institution_name;

        switch ($format) {
            case 'apa':
                return "{$authorNames} ({$year}). {$title}. {$institution}.";
            case 'mla':
                return "{$authorNames} \"{$title}.\" {$institution}, {$year}.";
            case 'chicago':
                return "{$authorNames} \"{$title}.\" {$institution} ({$year}).";
            default:
                return "{$authorNames} ({$year}). {$title}. {$institution}.";
        }
    }
}
