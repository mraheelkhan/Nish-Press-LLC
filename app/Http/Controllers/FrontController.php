<?php

namespace App\Http\Controllers;

use App\Models\Magazine;
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
        return view('front.show', compact('magazine', 'intent'));
    }
}
