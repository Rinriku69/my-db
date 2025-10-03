@extends('layouts.main', [
    'title' => $user->name,
])

@section('header')
     <nav>
        <form action="{{route('users.delete',['user'=>$user->id])}}" method="post"
            id="app-form-delete">
            @csrf
        </form>
        <ul>

            <li>
                <a href="{{ route('users.list') }}">&lt; Back</a>
            </li>
            
            <li>
                <a
                    href="{{route('users.updateForm',['user'=>$user->id])}}">Update</a>
            </li>
            @can('delete', $user )
            @if ($user->email !== \Auth::user()->email)
                
            
                <li>
                <button type="submit" form="app-form-delete" class="app-cl-link">Delete</button>
            </li> @endif
            @endcan
           
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