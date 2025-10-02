<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JournalCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($journalCategory) {
            if (empty($journalCategory->id)) {
                $journalCategory->id = 'JOURNAL_CATEGORY_' . strtoupper(Str::random(8));
                // Generates something like: USER_A1B2C3D4
            }
        });
    }

    public function journals()
    {
        return $this->hasMany(Journal::class);
    }
}
