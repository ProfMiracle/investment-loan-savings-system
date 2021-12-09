<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CronHolder extends Model
{
    //
    protected $fillable = [
        'user_id','start','end','amount','how','when','authorization'
    ];
}
