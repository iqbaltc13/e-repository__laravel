<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Journal;
use Illuminate\Database\Eloquent\SoftDeletes;


class JournalAuthor extends Model
{
    use HasFactory, SoftDeletes;
    protected $casts = [
        'is_corresponding' => 'boolean'
    ];


    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $appends = ['full_name'];

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

    public function journal()
    {
        return $this->belongsTo(Journal::class, 'journal_id', 'id');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

}
