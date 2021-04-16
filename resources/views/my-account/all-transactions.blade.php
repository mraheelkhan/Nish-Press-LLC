@extends('layouts.app')

@section('content')

    <div class="row">
        @if(session()->has('success'))
            <p class="alert alert-success">
                {{ session('success') }}
            </p>
        @endif
        @if(session()->has('error'))
            <p class="alert alert-error">
                {{ session('error') }}
            </p>
        @endif
    </div>
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title" style="float: left;">All Transactions</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Charge Id</th>
                                <th>Email</th>
                                <th>Card Used</th>
                                <th>Magazine Title</th>
                                <th>Magazine Price</th>
                                <th>Transaction At</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions as $record)
                                <tr>
                                    <td>{{ $record->stripe_charge_id }}</td>
                                    <td>{{ $record->user->email }}</td>
                                    <td>{{ (strtolower($record->stripe_object) == 'paypal') ? $record->stripe_object : $record->stripe_payment_details['card']['last4'] }}</td>
                                    <td>{{ $record->magazine->title }}</td>
                                    <td>{{ ($record->magazine->price ? _('$') . $record->magazine->price : '') }}</td>
                                    <td>{{(strtolower($record->stripe_object) == 'paypal') ? date('M d Y h:i a', strtotime($record->transaction_created_at)) : date('M d Y h:i a', $record->transaction_created_at) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
