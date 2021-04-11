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
                        Editing {{ $user->getName() }}
                    </h3>
                    <div class="text-right">
                        <a href="{{ route('users.index') }}" class="btn btn-pink">
                            Back to list
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        Change User Role
                                        <select name="user_role" class="form-control">
                                            <option value="admin" {{ $user->user_role == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="premium" {{ $user->user_role == 'premium' ? 'selected' : '' }}>Premium User</option>
                                            <option value="user"  {{ $user->user_role == 'user' ? 'selected' : '' }}>User</option>
                                        </select>
                                    </label>
                                </div>
                                {{--<div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="is_active" class="custom-control-input" id="customSwitch1" {{ $user->is_active ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="customSwitch1">Activate / Deactivate</label>
                                    </div>
                                </div>--}}
                            </div>
                        </div>
                        <button type="submit" class="btn btn-pink">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
