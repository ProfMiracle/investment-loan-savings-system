<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Targetsave extends Model
{
    //
    protected $fillable = [
        'user_id','name','target','start','end','amount','how','when','reason','accumulated'
    ];
}
