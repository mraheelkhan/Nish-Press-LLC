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
                    <h3 class="card-title" style="float: left;">Users</h3>
                    <div class="text-right">
                        {{--<a href="{{ route('magazines.create') }}" class="btn btn-pink">
                            Add Magazine
                        </a>--}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->getName() }}</td>
                                    <td>
                                       {{ $user->email }}
                                    </td>
                                    <td>{{ $user->user_role }}</td>
                                    <td class="w-25">
                                        @if($user->id != auth()->user()->id)
                                        <a href="{{ route('users.edit', $user->id ) }}" class="btn btn-sm btn-pink">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                            <a href="{{ route('users.delete', $user->id) }}" class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </a>
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
    </div>
@endsection
