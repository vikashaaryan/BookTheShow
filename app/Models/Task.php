<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{  protected $fillable = ['title', 'description', 'completed', 'translations'];

    protected $casts = [
        'completed' => 'boolean',
        'translations' => 'array',
    ];
}
