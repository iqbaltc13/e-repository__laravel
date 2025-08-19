<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Institution;
use App\Models\Faculty;
use App\Models\Department;


class Journal extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;




    protected $casts = [
        'publication_date' => 'date',
        //'keywords' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($journal) {
            if (empty($journal->id)) {
                $journal->id = 'JOURNAL_' . strtoupper(Str::random(8));
                // Generates something like: USER_A1B2C3D4
            }
            $journal->slug = Str::slug($journal->title);
        });

        static::updating(function ($journal) {
            if ($journal->isDirty('title')) {
                $journal->slug = Str::slug($journal->title);
            }
        });
    }

    protected function journalName(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => str_replace("\r\n"," ",$value),
        );
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(JournalCategory::class, 'category_id', 'id');
    }

    public function coAuthors()
    {
        return $this->hasMany(JournalAuthor::class)->orderBy('order');
    }



    public function isPublished()
    {
        return $this->status === 'published';
    }

    public function canBeEditedBy(User $user)
    {
        return $user->isAdmin() || $this->author_id === $user->id;
    }


    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function incrementDownloads()
    {
        $this->increment('downloads_count');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeByAuthor($query, $authorId)
    {
        return $query->where('author_id', $authorId);
    }
    public function universitas()
    {
        return $this->belongsTo(Institution::class, 'institution_code', 'institution_code');
    }
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_code', 'faculty_code');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_code', 'department_code');
    }

}
