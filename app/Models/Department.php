<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($department) {
            if (empty($department->id)) {
                $department->id = 'DEPARTMENT_' . strtoupper(Str::random(8));
                // Generates something like: USER_A1B2C3D4
            }
        });
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_code', 'faculty_code');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'department_code', 'department_code');
    }

    public function journals()
    {
        return $this->hasMany(Journal::class, 'department_code', 'department_code');
    }


}
