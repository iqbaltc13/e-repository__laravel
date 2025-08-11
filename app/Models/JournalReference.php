<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JournalReference extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($journalReference) {
            if (empty($journalReference->id)) {
                $journalReference->id = 'JOURNAL_REFERENCE_' . strtoupper(Str::random(8));
                // Generates something like: USER_A1B2C3D4
            }
        });
    }

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }


}
