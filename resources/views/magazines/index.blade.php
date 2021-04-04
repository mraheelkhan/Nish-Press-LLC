@extends('layouts.app')

@section('content')
   <div class="row">
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
                           <tr>
                               <td>1</td>
                               <td>Title of magazine</td>
                               <td><img src="https://picsum.photos/100/200"/></td>
                               <td>$20</td>
                               <td>
                                   <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> </a>
                                   <a href="#" class="btn btn-sm btn-pink"><i class="fa fa-edit"></i> </a>
                               </td>
                           </tr>
                           </tbody>
                       </table>
                   </div>
               </div>
           </div>
       </div>
   </div>
@endsection
