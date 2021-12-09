<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardAuthorization extends Model
{
    //
    protected $fillable = [
        'user_id','authorization','for','for_id'
    ];

    public static function getSignature($signature, $for)
    {
        return self::where('for', $for)->where('authorization->authorization->signature', $signature)->first();
    }
}
