<?php

namespace App\Http\Controllers;

use App\Core\HelperFunction;
use App\Models\Magazine;
use App\Models\Transaction;
use App\Models\User;
use Cartalyst\Stripe\Stripe;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $magazines = Magazine::where('is_active', true)->orderBy('id', 'desc')->get();
        return view('front.magazines', compact('magazines'));
    }

    public function show(Magazine $magazine, $title)
    {
        $intent = auth()->user()->createSetupIntent();
        $purchased = HelperFunction::is_purchased($magazine->id);
        return view('front.show', compact('magazine', 'intent', 'purchased'));
    }

}
