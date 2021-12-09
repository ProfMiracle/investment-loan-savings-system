<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavingsTempDump extends Model
{
    //
    protected $fillable = [
        'trx', 'type', 'data'
    ];
}
