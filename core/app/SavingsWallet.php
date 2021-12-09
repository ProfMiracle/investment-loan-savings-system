<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavingsWallet extends Model
{
    //
    protected $fillable = [
        'user_id','type','balance'
    ];

    public static function getBalance($user_id, $type)
    {
        return self::where('user_id', $user_id)->where('type', $type)->first();
    }
}
