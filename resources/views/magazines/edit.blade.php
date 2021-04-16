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
                    <h3 class="card-title" style="float: left;">
                        {{ $magazine->title }}
                    </h3>
                    <div class="text-right">
                        <a href="{{ route('magazines.index') }}" class="btn btn-pink">
                            Back to list
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('magazines.update', $magazine->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4">
                                <label>
                                    Enter magazine title
                                </label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ old('title') ? old('title') : $magazine->title }}"/>
                                @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label>
                                    Enter magazine description
                                </label>
                                <input type="text" class="form-control" name="description" id="description" value="{{ old('description') ? old('description') : $magazine->description }}"/>
                                @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label>
                                    Enter price
                                </label>
                                <input type="text" class="form-control" name="price" id="price" value="{{ old('price') ? old('price') : $magazine->price }}"/>
                                @error('price')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-4">
                                <label>
                                    Upload Cover Image
                                </label>
                                <label> Current Image</label>
                                <img src="{{ asset("storage/$magazine->cover_image/$magazine->cover_image ") }}"
                                     class="w-25" alt="{{ $magazine->title }}"/>
                                <input type="file" name="cover_image" id="cover_image" value="{{ old('cover_image') }}"/>
                                @error('cover_image')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label>
                                    Upload magazine PDF
                                </label>
                                <input type="file" name="pdf_filename" id="pdf_filename" value="{{ old('pdf_filename') }}"/>
                                @error('pdf_filename')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label>
                                    Upload Paid magazine PDF
                                </label>
                                <input type="file" name="paid_pdf_filename" id="paid_pdf_filename" value="{{ old('paid_pdf_filename') }}"/>
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
    @if($magazine->price)
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Already added premium users</h3>
                    <p> to "{{ $magazine->title }}" magazine.</p>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($premium_users as $user)
                        <tr>
                            <td>{{ $user->premium_user->getName() }}</td>
                            <td>{{ $user->premium_user->email }}</td>
                            <td>
                                @if(\App\Core\HelperFunction::is_premium_access($magazine->id, $user->premium_user->id))
                                    <a href="{{ route('magazine.premiumAccessRemove', \App\Core\HelperFunction::premium_access_id($magazine->id, $user->premium_user->id)) }}" class="btn btn-danger">Remove Access</a>
                                @else
                                    <a href="{{ route('magazine.premiumAccess', ['magazine_id' => $magazine->id, 'user_id' => $user->premium_user->id, 'created_by' => auth()->user()->id]) }}" class="btn btn-pink">Give Access</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add premium users </h3>
                    <p> to "{{ $magazine->title }}" magazine.</p>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->getName() }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if(\App\Core\HelperFunction::is_premium_access($magazine->id, $user->id))
                                        <a href="{{ route('magazine.premiumAccessRemove', \App\Core\HelperFunction::premium_access_id($magazine->id, $user->id)) }}" class="btn btn-danger">Remove Access</a>
                                    @else
                                        <a href="{{ route('magazine.premiumAccess', ['magazine_id' => $magazine->id, 'user_id' => $user->id, 'created_by' => auth()->user()->id]) }}" class="btn btn-pink">Give Access</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
