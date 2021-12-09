<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autosave extends Model
{
    //
    protected $fillable = [
        'user_id','start','end','amount','how','when','reason','accumulated'
    ];
}
