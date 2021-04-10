<?php

namespace App\Core;

use App\Models\Transaction;

class HelperFunction
{
    public static function is_purchased($magazine_id){
        $purchased = Transaction::where('user_id', auth()->user()->id)->where('magazine_id', $magazine_id)->exists();
        return $purchased;
    }
}
