@extends('layouts.front')
@section('content')
    <div class="row mt-5">
        <div class="col-md-12">
            <h1 class="text-center">{{ _('Nish Press Magazines') }}</h1>
            <div class="masonry">
                @foreach($magazines as $magazine)
                    <a href="{{ route('front.magazine.show', [$magazine->id, $magazine->title]) }}">
                    <div class="item rounded">
                        <label>{{ $magazine->title }}</label>
                        <img
                            class="rounded"
                            src="{{ asset('storage/' . $magazine->cover_image . '/' . $magazine->cover_image ) }}">
                    </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

@endsection
