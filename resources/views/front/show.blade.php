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
    </style>
@endpush
@section('content')
    <div class="row mt-5 mb-5">
        <div class="col-md-12">
            <section class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="pro-img-details">
                                <img class="rounded shadow"
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
                                <a href="#" class="">
                                </a>
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
                                @else
                                    <span>This Magazine is free</span>
                                @endif
                            </div>
                            {{--<div class="form-group">
                                <label>Quantity</label>
                                <input type="quantiy" placeholder="1" class="form-control quantity">
                            </div>--}}
                            <p>
                                <button class="btn btn-round btn-pink _df_button"
                                        id="pop_flip_button"
                                        source="{{ asset("storage/pdf_files/$magazine->pdf_filename/$magazine->pdf_filename") }}">
                                    View Magazine
                                </button>

                            </p>

                            <div class="">
                                @if($magazine->price)
                                    <form action="{{ route('magazine.purchase') }}" method="post" id="payment-form"
                                          data-secret="{{ $intent->client_secret }}">
                                        @csrf
                                        <div class="form-row mb-3">
                                            <input type="text" class="form-control" name="card-holder-name"
                                                   id="card-holder-name">
                                            <label for="card-element">
                                                Credit or debit card
                                            </label>
                                            <div id="card-element" class="form-control">
                                                <!-- A Stripe Element will be inserted here. -->
                                            </div>

                                            <!-- Used to display Element errors. -->
                                            <div id="card-errors" role="alert"></div>
                                        </div>

                                        <button class="btn btn-round btn-pink" type="submit"><i
                                                class="fa fa-shopping-cart"></i> Buy Now
                                        </button>
                                    </form>

                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>
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


        var stripe = Stripe("pk_test_51IbXaZAntaUCH1j1UGEuB2PbXQo52EVvYGp5qczDAw1jxcLH19JzXeC9Mx2OX2MLy0Z0Yx353FQRSzub2Z3a0PxO00hjdIdGvw");
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
        var clientSecret = form.dataset.secret;
        form.addEventListener('submit', async function (event) {
            event.preventDefault();

            const {setupIntent, error} = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: card,
                        billing_details: {name: cardHolderName.value}
                    }
                }
            );

            if (error) {
                // Inform the customer that there was an error.
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;
            } else {
                // Send the token to your server.
                console.log(setupIntent);
                stripeTokenHandler(setupIntent);
            }
            /* stripe.createToken(card).then(function(result) {
                 if (result.error) {
                     // Inform the customer that there was an error.
                     var errorElement = document.getElementById('card-errors');
                     errorElement.textContent = result.error.message;
                 } else {
                     // Send the token to your server.
                     stripeTokenHandler(result.token);
                 }
             });*/
        });

        function stripeTokenHandler(setupIntent) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'paymentMethod');
            hiddenInput.setAttribute('value', setupIntent.payment_method);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }
    </script>

@endpush

