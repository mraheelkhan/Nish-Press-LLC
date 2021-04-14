@extends('layouts.front')
@push('style')
    <style>
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
        .pro-price {
            font-size: 24px;
            color: #f87ca3;
        }
    </style>
@endpush
@section('content')
    <div class="row mt-5 mb-5">
        <div class="col-md-12">
            <section class="card">
                @if(session()->has('error'))
                    <p class="alert alert-danger">
                        {{ session('error') }}
                    </p>
                @endif
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-right">
                                <a href="{{ route('front.index') }}" class="btn btn-pink">Back to List</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="pro-img-details">
                                <img class="rounded shadow w-100"
                                     src="{{ asset("storage/$magazine->cover_image/$magazine->cover_image") }}" alt="">
                            </div>
                            {{--<div class="pro-img-list">
                                <a href="#">
                                    <img src="https://via.placeholder.com/115x100/87CEFA/000000" alt="">
                                </a>
                                <a href="#">
                                    <img src="https://via.placeholder.com/115x100/FF7F50/000000" alt="">
                                </a>
                                <a href="#">
                                    <img src="https://via.placeholder.com/115x100/20B2AA/000000" alt="">
                                </a>
                                <a href="#">
                                    <img src="https://via.placeholder.com/120x100/20B2AA/000000" alt="">
                                </a>
                            </div>--}}
                        </div>
                        <div class="col-md-6">
                            <h4 class="pro-d-title">
                                {{ ucwords($magazine->title) }}
                            </h4>
                            <p>
                                {{ $magazine->description }}
                            </p>
                            {{--<div class="product_meta">
                                <span class="posted_in"> <strong>Categories:</strong> <a rel="tag" href="#">Jackets</a>, <a rel="tag" href="#">Men</a>, <a rel="tag" href="#">Shirts</a>, <a rel="tag" href="#">T-shirt</a>.</span>
                                <span class="tagged_as"><strong>Tags:</strong> <a rel="tag" href="#">mens</a>, <a rel="tag" href="#">womens</a>.</span>
                            </div>--}}
                            <div class="m-bot15">
                                @if($magazine->price)
                                    <strong>Price : </strong>
                                    <span class="pro-price">{{ _('$') . $magazine->price }}</span>
                                    <hr>
                                @else
                                    <span>This Magazine is free</span>
                                @endif
                            </div>
                            {{--<div class="form-group">
                                <label>Quantity</label>
                                <input type="quantiy" placeholder="1" class="form-control quantity">
                            </div>--}}

                            <div class="mt-3 mb-3">
                                @if(auth()->check() && \App\Core\HelperFunction::is_purchased($magazine->id))
                                <button class="btn btn-round btn-pink _df_button"
                                        id="pop_flip_button"
                                        source="{{ asset("storage/paid_pdf_files/$magazine->paid_pdf_filename/$magazine->paid_pdf_filename") }}">
                                    View Magazine
                                </button>
                                @else
                                    <button class="btn btn-round btn-pink _df_button"
                                            id="pop_flip_button"
                                            source="{{ asset("storage/pdf_files/$magazine->pdf_filename/$magazine->pdf_filename") }}">
                                        Preview Magazine
                                    </button>
                                @endif
                                @if($magazine->price)
                                    @if($purchased)
                                        Looks like already purchased, <a href="#" class="btn-link">Click here</a> to open magazine.
                                    @else
                                        <button type="button" class="btn btn-pink" data-toggle="modal" data-target="#buyMagazine">
                                            Purchase Now
                                        </button>
                                    @endif
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>

    @if($magazine->price)
    <div class="modal fade" id="buyMagazine" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Purchase {{ $magazine->title }}</h5>
                   {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>--}}
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img src="{{ asset('images/mastercard.png') }}"/>
                        <img src="{{ asset('images/visa02.png') }}"/>
                    </div>
                    <form action="{{ route('magazine.purchase') }}" method="post" id="payment-form"
                          data-secret="{{ $intent->client_secret }}">
                        @csrf
                        <input type="hidden" name="magazine_id" value="{{ $magazine->id }}">
                        <input type="hidden" id="email" value="{{ auth()->user()->email }}">
                        <input type="hidden" id="phone" value="{{ !empty(auth()->user()->phone) ? auth()->user()->phone : "01" }}">
                        <input type="hidden" id="city" value="{{ auth()->user()->city }}">
                        <input type="hidden" id="country" value="{{ auth()->user()->country }}">
                        <input type="hidden" id="address_line1" value="{{ auth()->user()->address }}">
                        <div class="form mb-3">

                            <div class="form-group">
                                <label>Pay with Paypal</label>
                                <a href="{{ route('paypal.payment', ['magazine_id' => $magazine->id]) }}" class="btn btn-success">Pay {{$magazine->price}} with Paypal</a>
                            </div>
                            <div class="form-group">
                            <label class="font-weight-bold">Name on card</label>
                            <input type="text" class="form-control" name="card-holder-name"
                                   id="card-holder-name" placeholder="Card holder name" required>

                            </div>
                            <div class="form-group">

                            <label for="card-element" class="font-weight-bold">
                                Credit or debit card
                            </label>
                            <div id="card-element" class="form-control">
                                <!-- A Stripe Element will be inserted here. -->
                            </div>
                            </div>

                            <!-- Used to display Element errors. -->
                            <div id="card-errors" role="alert"></div>
                        </div>

                        <div class="text-center">
                        <button class="btn btn-round btn-pink" type="submit"><i
                                class="fa fa-credit-card"></i> Pay ${{ $magazine->price }}
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
@push('script')
    <script>
        var option_pop_flip_button = {
            // enableDownload of PDF files (true|false)
            enableDownload: false,
        }
    </script>
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        var stripe = Stripe("{{env('STRIPE_KEY')}}");
        var elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        let style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        }

        // Create an instance of the card Element.
        var card = elements.create('card', {style: style});

        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');

        // Create a token or display an error when the form is submitted.
        var form = document.getElementById('payment-form');
        var cardHolderName = document.getElementById('card-holder-name');

        var email = document.getElementById('email').value;
        var phone = document.getElementById('phone').value;
        var address_line1 = document.getElementById('address_line1').value;
        var country = document.getElementById('country').value;
        var city = document.getElementById('city').value;

        var clientSecret = form.dataset.secret;
        form.addEventListener('submit', async function (event) {
            event.preventDefault();

            stripe.createSource(card, {
                    type: 'card',
                    currency: 'usd',
                    owner: {
                        address: {
                            "city": city,
                            "country": country,
                            "line1": address_line1,
                        },
                        name: cardHolderName,
                        email: email,
                        phone: phone
                    },
                })
                .then(function(result) {
                    if(result.error){
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                    } else {
                        console.log(result.source)
                        stripeTokenHandler(result.source)
                    }
                });
        });

        function stripeTokenHandler(source) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');

            // hidden input for source id created by stripe
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'sourceId');
            hiddenInput.setAttribute('value', source.id);

            form.appendChild(hiddenInput);
            // Submit the form
            form.submit();
        }
    </script>

@endpush

