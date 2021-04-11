@extends('layouts.app')
@section('content')
    <div class="row">
        {{--@if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif--}}
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title" style="float: left;">Magazines</h3>
                    <div class="text-right">
                        <a href="{{ route('magazines.index') }}" class="btn btn-pink">
                            Back to list
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('magazines.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label>
                                    Enter magazine title
                                </label>
                                <input type="text" class="form-control" name="title" id="title"
                                       value="{{ old('title') }}"/>
                                @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label>
                                    Enter price
                                </label>
                                <input type="text" class="form-control" name="price" id="price"
                                       value="{{ old('price') }}"/>
                                @error('price')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="description">
                                    Enter magazine description
                                </label>
                                <textarea class="form-control" name="description"
                                          id="description">{{ old('description') }}</textarea>
                                @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-4">
                                <label>
                                    Upload Cover Image
                                </label>
                                <input type="file" name="cover_image" id="cover_image"
                                       value="{{ old('cover_image') }}"/>
                                @error('cover_image')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label>
                                    Upload magazine PDF
                                </label>
                                <input type="file" name="pdf_filename" id="pdf_filename"
                                       value="{{ old('pdf_filename') }}"/>
                                @error('pdf_filename')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label>
                                    Upload Paid magazine PDF
                                </label>
                                <input type="file" name="paid_pdf_filename" id="paid_pdf_filename"
                                       value="{{ old('paid_pdf_filename') }}"/>
                                @error('paid_pdf_filename')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <input type="submit" class="btn btn-pink"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
