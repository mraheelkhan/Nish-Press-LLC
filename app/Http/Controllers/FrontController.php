<?php

namespace App\Http\Controllers;

use App\Models\Magazine;
use App\Models\Transaction;
use App\Models\User;
use Cartalyst\Stripe\Stripe;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $magazines = Magazine::where('is_active', true)->get();
        return view('front.magazines', compact('magazines'));
    }

    public function show(Magazine $magazine, $title)
    {
        $intent = auth()->user()->createSetupIntent();
        $purchased = $this->is_purchased($magazine->id);
        return view('front.show', compact('magazine', 'intent', 'purchased'));
    }

    private function is_purchased($magazine_id){
        $purchased = Transaction::where('user_id', auth()->user()->id)->where('magazine_id', $magazine_id)->exists();
        return $purchased;
    }
}
