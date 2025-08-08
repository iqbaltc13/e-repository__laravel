<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Journal;


class JournalAuthor extends Model
{
    use HasFactory;
    protected $casts = [
        'is_corresponding' => 'boolean'
    ];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }
    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = 'AUTHOR_' . strtoupper(Str::random(8));
                // Generates something like: USER_A1B2C3D4
            }
        });
    }

}
