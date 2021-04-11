<?php

namespace App\Http\Controllers;

use App\Models\Magazine;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Gate;

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

    public function my_account(Request $request)
    {
        $stripe_customer = auth()->user()->createOrGetStripeCustomer();
        $transactions = Transaction::with('user')->where('user_id', auth()->user()->id)->get();

        $trans_magazines = Transaction::where('user_id', auth()->user()->id)->pluck('magazine_id');
        $magazines = Magazine::whereIn('id', $trans_magazines)->get();
        return view('my-account.index', compact('transactions', 'magazines'));
    }
}
