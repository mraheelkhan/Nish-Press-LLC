<?php

namespace App\Core;

use App\Models\PremiumAccess;
use App\Models\Transaction;

class HelperFunction
{
    public static function is_purchased($magazine_id){
        $purchased = Transaction::where('user_id', auth()->user()->id)->where('magazine_id', $magazine_id)->exists();
        return $purchased;
    }
    public static function is_premium_access($magazine_id, $user_id){
        $premium = PremiumAccess::where('user_id', $user_id)->where('magazine_id', $magazine_id)->exists();
        return $premium;
    }

    public static function premium_access_id($magazine_id, $user_id){
        $premium = PremiumAccess::where('user_id', $user_id)->where('magazine_id', $magazine_id)->first();
        return $premium->id;
    }
}
