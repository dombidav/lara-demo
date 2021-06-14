@extends('layouts.app')

@section('content')
   <div class="container my-2 my-lg-5">
       <table class="table-responsive mx-auto">
           <thead>
           <tr>
               <th colspan="2" class="h3">{{ $user->name }}</th>
           </tr>
           </thead>
           <tbody>
           <tr>
               <th scope="row" class="text-end p-1">Email:</th>
               <td class="p-1">{{ $user->email }}</td>
           </tr>
           <tr>
               <th scope="row" class="text-end p-1">Registered at:</th>
               <td class="p-1">{{ $user->created_at }}</td>
           </tr>
           </tbody>
       </table>

       <table class="table-responsive mx-auto mt-2 mt-md-5">
           <thead>
           <tr>
               <th colspan="2" class="h4">Roles:</th>
           </tr>
           <tr>
               <th scope="col" class="text-end p-3">Role name:</th>
               <th scope="col" class="p-3">Provides:</th>
           </tr>
           </thead>
           <tbody>
           @foreach($user->roles as $role)
               <tr>
                   <td class="text-end p-3">{{ $role->title }}</td>
                   <td class="p-3">{{ $role->abilities->implode('title', ', ') }}</td>
               </tr>
           @endforeach
           </tbody>
       </table>
   </div>
@endsection
