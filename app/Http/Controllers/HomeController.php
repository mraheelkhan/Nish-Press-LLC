<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $stripeCustomer = auth()->user()->createOrGetStripeCustomer();
        return view('home', compact('stripeCustomer'));
    }

    public function billing_portal(Request $request)
    {
        return $request->user()->redirectToBillingPortal(route('home.index'));
    }
}
