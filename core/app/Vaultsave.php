<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vaultsave extends Model
{
    //
    protected $fillable = [
        'user_id','amount','end','reason','accumulated'
    ];
}
