@extends('layouts.main',
['title' => $user->name])

@section('content')
    <form action="{{route('users.update',
    ['user'=>$user->id])}}" method="POST">
        @csrf
        <label >
            <b>Email</b>
            <input type="email" name="email"  value="{{$user->email}}">
        </label><br>
        <label >
            <b>Name</b>
            <input type="text" name="name"  value="{{$user->name}}">
        </label><br>
        
        <button type="submit">Update</button>
        <a href="{{ route('users.view',
        ['user' => $user->id])}}">
            <button type="button">Cancel</button>
        </a>
    </form>
@endsection