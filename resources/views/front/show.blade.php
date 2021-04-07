@extends('layouts.front')
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
                            <div class="m-bot15"> <strong>Price : </strong> <span class="pro-price">{{ _('$') . $magazine->price }}</span></div>
                            {{--<div class="form-group">
                                <label>Quantity</label>
                                <input type="quantiy" placeholder="1" class="form-control quantity">
                            </div>--}}
                            <p>
                                <button class="btn btn-round btn-pink _df_button"
                                        id="pop_flip_button"
                                        source="{{ asset("storage/pdf_files/$magazine->pdf_filename/$magazine->pdf_filename") }}">
                                    Open Book
                                </button>
                                @if($magazine->price)
                                    <button class="btn btn-round btn-danger" type="button"><i class="fa fa-shopping-cart"></i> Buy Now</button>
                                @endif
                            </p>
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
@endpush
