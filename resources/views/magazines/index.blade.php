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
                   <h3 class="card-title" style="float: left;">Magazines</h3>
                   <div class="text-right">
                       <a href="{{ route('magazines.create') }}" class="btn btn-pink">
                           Add Magazine
                       </a>
                   </div>
               </div>
               <div class="card-body">
                   <div class="table-responsive">
                       <table class="table table-hover">
                           <thead>
                           <tr>
                               <th>Id</th>
                               <th>Title</th>
                               <th>Cover</th>
                               <th>Price</th>
                               <th>Actions</th>
                           </tr>
                           </thead>
                           <tbody>
                           @foreach($magazines as $magazine)
                           <tr>
                               <td>{{ $magazine->id }}</td>
                               <td>{{ $magazine->title }}</td>
                               <td class="w-50">
                                   <img class="rounded shadow w-50"
                                        src="{{ asset('storage/' . $magazine->cover_image . '/' . $magazine->cover_image ) }}"
                                        alt="image"/>
                               </td>
                               <td>$20</td>
                               <td class="w-25">
                                   <a href="{{ route('magazines.edit', $magazine->id ) }}" class="btn btn-sm btn-pink">
                                       <i class="fa fa-edit"></i>
                                   </a>
                                   <a href="#" class="btn btn-sm btn-danger">
                                       <i class="fa fa-trash"></i>
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
