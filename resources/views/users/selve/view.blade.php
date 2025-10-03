@extends('layouts.main', [
    'title' => $user->name,
])

@section('header')
  <nav>
        <ul>

            <li>
                <a href="{{ session()->get('bookmarks.users.selves.view', route('products.list')) }}">&lt; Back</a>
            </li>

            
            <li>
                <a
                    href="{{route('users.selves.updateForm',['user'=>$user->id])}}">Update</a>
            </li>
            
           
        </ul>
    </nav> 
@endsection

@section('content')
    @php
        session()->put('bookmarks.products.view-shops', url()->full());
    @endphp
    <dl>
        <dt>Email</dt>
        <dd>{{ $user->email }}</dd>
        <dt>Name</dt>
        <dd>{{ $user->name }}</dd>
        <dt>Role</dt>
        <dd>{{ $user->role }}</dd>
    </dl>
@endsection