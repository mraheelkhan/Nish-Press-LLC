@extends('layouts.app')

@section('content')

    <div class="row">
        @if(session()->has('success'))
            <p class="alert alert-success">
                {{ session('success') }}
            </p>
        @endif
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title" style="float: left;">My Account</h3>
                </div>
                <div class="card-body">
                    <div class="form-inline">
                        <div class="form-group">
                            <label> Email </label>
                            <input type="text" class="form-control ml-3 mr-3" value="{{ auth()->user()->email }}" readonly/>
                        </div>
                        <div class="form-group">
                            <label> Role </label>
                            <input type="text" class="form-control ml-3 mr-3" value="{{ auth()->user()->user_role }}" readonly/>
                        </div>
                        <div class="form-group">
                            <label> My Customer Id </label>
                            <input type="text" class="form-control ml-3 mr-3" value="{{ auth()->user()->stripe_id }}" readonly/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title" style="float: left;">My Transactions</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Charge Id</th>
                                <th>Card Used</th>
                                <th>Magazine Title</th>
                                <th>Transaction At</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions as $record)
                                <tr>
                                    <td>{{ $record->stripe_charge_id }}</td>
                                    <td>{{ (strtolower($record->stripe_object) == 'paypal') ? $record->stripe_object : $record->stripe_payment_details['card']['last4'] }}</td>
                                    <td>{{ $record->magazine->title }}</td>
                                    <td>{{(strtolower($record->stripe_object) == 'paypal') ? date('M d Y h:i a', strtotime($record->transaction_created_at)) : date('M d Y h:i a', $record->transaction_created_at) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title" style="float: left;">My Paid Magazines</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Cover Image</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($magazines as $magazine)
                                <tr>
                                    <td>{{ $magazine->title }}</td>
                                    <td class="">
                                        <img class="rounded shadow w-50"
                                             src="{{ asset('storage/' . $magazine->cover_image . '/' . $magazine->cover_image ) }}"
                                             alt="image"/>
                                    </td>
                                    <td>{{ _('$') . $magazine->price }}</td>
                                    <td class="w-25">
                                        <a href="{{ route('front.magazine.show', [$magazine->id, $magazine->title] ) }}"
                                           class="btn btn-sm btn-pink">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
