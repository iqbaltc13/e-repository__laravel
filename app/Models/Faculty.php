<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Faculty extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($faculty) {
            if (empty($faculty->id)) {
                $faculty->id = 'FACULTY_' . strtoupper(Str::random(8));
                // Generates something like: USER_A1B2C3D4
            }

        });


    }

    public function faculties()
    {
        return $this->hasMany(Faculty::class, 'institution_code', 'institution_code');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'institution_code', 'institution_code');
    }

    public function journals()
    {
        return $this->hasMany(Journal::class, 'institution_code', 'institution_code');
    }
}
