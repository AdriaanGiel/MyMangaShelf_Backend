<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Generation extends Model
{
    protected $fillable = [
        'status',
        'prompt',
        'result',
        'error',
    ];
}
