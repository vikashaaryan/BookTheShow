<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
     protected $guarded = [];

    protected $casts = [
        'completed' => 'boolean',
        'translations' => 'array',
    ];
}
