<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AutosavePlan extends Model
{
    protected $fillable = [
        'interval', 'duration', 'max', 'min', 'interest'
    ];
}
