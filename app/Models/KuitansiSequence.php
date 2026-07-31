<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KuitansiSequence extends Model
{
    protected $fillable = [
        'period',
        'last_number',
    ];
}