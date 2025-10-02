<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    use HasFactory;
    protected $guarded = [];
    const CREATED_AT = null;
    const UPDATED_AT = null;

    public function user()
    {

        return $this->belongsTo(User::class);

    }
}
