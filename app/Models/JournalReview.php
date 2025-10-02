<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JournalReview extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($journalReview) {
            if (empty($journalReview->id)) {
                $journalReview->id = 'JOURNAL_REVIEW_' . strtoupper(Str::random(8));
                // Generates something like: USER_A1B2C3D4
            }
        });
    }

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
